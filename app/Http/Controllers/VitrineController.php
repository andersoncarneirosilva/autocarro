<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Profissional;
use App\Models\Cliente;
use App\Models\Financeiro;
use App\Models\Servico;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class VitrineController extends Controller
{
//     public function index($slug)
// {
//     // 1. Busca a empresa pelo slug de forma pública
//     $empresa = Empresa::where('slug', $slug)->firstOrFail();

//     // 2. Busca as fotos usando o ID da empresa encontrada, não do usuário logado
//     $fotos = \App\Models\Galeria::where('empresa_id', $empresa->id)
//         ->orderBy('ordem', 'asc')
//         ->get();

//     return view('vitrine.index', compact('empresa', 'fotos'));
// }

    public function show($slug)
{
    //dd($slug);
    // Busca a empresa com tudo que a vitrine precisa: serviços, profissionais e galeria
    $empresa = Empresa::where('slug', $slug)
        ->where('status', true)
        ->with([
            'servicos', 
            'profissionais',
            'galeria' => function($query) {
                $query->orderBy('ordem', 'asc');
            }
        ])
        ->firstOrFail();

    // Se você não tiver o relacionamento 'galeria' no Model Empresa, 
    // pode buscar as fotos manualmente assim:
    $fotos = \App\Models\Galeria::where('empresa_id', $empresa->id)
        ->orderBy('ordem', 'asc')
        ->get();

    return view('vitrine.index', compact('empresa', 'fotos'));
}


    public function agendar(Request $request)
{
    $request->validate([
        'profissional_id'  => 'required|exists:profissionais,id',
        'servico_id'       => 'required',
        'data_agendamento' => 'required|date',
        'hora_selecionada' => 'required',
        'cliente_nome'     => 'required|string|max:255',
        'cliente_whatsapp' => 'required',
    ]);

    try {
        // --- TRATAMENTO DO NÚMERO WHATSAPP ---
        // 1. Remove tudo que não for número
        $whatsapp = preg_replace('/\D/', '', $request->cliente_whatsapp);

        // 2. Se o número não começar com 55, adiciona o prefixo
        if (!str_starts_with($whatsapp, '55')) {
            $whatsapp = '55' . $whatsapp;
        }

        $profissional = Profissional::findOrFail($request->profissional_id);
        $servico = Servico::findOrFail($request->servico_id);

        $inicio = Carbon::createFromFormat('Y-m-d H:i', $request->data_agendamento . ' ' . $request->hora_selecionada);
        $duracao = $servico->duracao ?? 30;
        $fim = (clone $inicio)->addMinutes($duracao);

        // --- LÓGICA DE CÁLCULO DE COMISSÃO ---
        $servicosProfissional = is_array($profissional->servicos) ? $profissional->servicos : json_decode($profissional->servicos, true);
        $percentualComissao = 0;

        if ($servicosProfissional) {
            foreach ($servicosProfissional as $sp) {
                if ($sp['id'] == $request->servico_id) {
                    $percentualComissao = isset($sp['comissao']) && !is_null($sp['comissao']) ? (float) $sp['comissao'] : 0;
                    break;
                }
            }
        }

        $valorTotal = $servico->preco ?? $servico->valor ?? 0.00;
        $valorComissao = $valorTotal * ($percentualComissao / 100);

        // --- SALVAMENTO ---
        $agenda = new Agenda();
        $agenda->empresa_id       = $profissional->empresa_id;
        $agenda->profissional_id  = $request->profissional_id;
        $agenda->cliente_nome     = $request->cliente_nome;
        $agenda->cliente_telefone = $whatsapp; // SALVANDO O NÚMERO TRATADO AQUI
        
        $agenda->servicos_json    = [
            [
                'id' => $servico->id,
                'nome' => $servico->nome,
                'valor' => $valorTotal,
                'comissao_percentual' => $percentualComissao
            ]
        ];

        $agenda->data_hora_inicio = $inicio;
        $agenda->data_hora_fim    = $fim;
        $agenda->valor_total      = $valorTotal;
        $agenda->status           = 'confirmado'; // Em minúsculo para bater com seu Command
        $agenda->save();
        // --- DISPARO DO WHATSAPP ---
        $this->dispararConfirmacaoImediata($agenda);
        // LANÇAMENTO NO FINANCEIRO
        Financeiro::create([
            'empresa_id'      => $profissional->empresa_id,
            'agendamento_id'  => $agenda->id,
            'profissional_id' => $profissional->id,
            'descricao'       => "Agendamento: {$request->cliente_nome} - {$servico->nome}",
            'valor'           => $valorTotal,
            'comissao_valor'  => $valorComissao,
            'tipo'            => 'receita',
            'forma_pagamento' => 'Pendente',
            'data_pagamento'  => $request->data_agendamento,
            'observacoes'     => "Comissão de {$percentualComissao}% para o profissional."
        ]);

        
        return redirect()->back()->with([
            'success' => 'Agendamento Confirmado!',
            'agendamento_detalhes' => [
                'nome' => $request->cliente_nome,
                'data' => $inicio->format('d/m/Y'),
                'hora' => $inicio->format('H:i'),
                'servico' => $servico->nome
            ]
        ]);

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao processar: ' . $e->getMessage());
    }
}

private function dispararConfirmacaoImediata($agenda)
{
    Log::info("--- INICIANDO DISPARO DE CONFIRMAÇÃO (Agenda: {$agenda->id}) ---");

    try {
        $config = \App\Models\WhatsappSetting::where('empresa_id', $agenda->empresa_id)
            ->where('confirmation_is_active', true)
            ->first();

        if (!$config) {
            Log::warning("Abortado: Confirmação desativada para empresa {$agenda->empresa_id}");
            return;
        }

        $instancia = \App\Models\WhatsappInstance::where('empresa_id', $agenda->empresa_id)->first();
        if (!$instancia) {
            Log::error("Abortado: Instância não encontrada no banco para empresa {$agenda->empresa_id}");
            return;
        }

        // Dados para o template
        $servicos = is_array($agenda->servicos_json) ? $agenda->servicos_json : json_decode($agenda->servicos_json, true);
        $nomeServico = $servicos[0]['nome'] ?? 'Serviço';
        $nomeProfissional = $agenda->profissional->nome ?? 'Profissional';
        $nomeEmpresa = $agenda->empresa->nome_fantasia ?? 'nossa empresa';

        $mensagem = str_replace(
            ['{nome}', '{horario_inicio}', '{data}', '{serviço}', '{profissional}', '{empresa}'],
            [
                $agenda->cliente_nome, 
                \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('H:i'), 
                \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('d/m/Y'),
                $nomeServico,
                $nomeProfissional,
                $nomeEmpresa
            ],
            $config->confirmation_template
        );

        Log::info("Mensagem montada com sucesso para cliente: {$agenda->cliente_nome}");

        $this->enviarMensagemWhatsapp($instancia, $agenda->cliente_telefone, $mensagem);

    } catch (\Exception $e) {
        Log::error("Erro no processamento da confirmação: " . $e->getMessage());
    }
}

private function enviarMensagemWhatsapp($instancia, $telefone, $mensagem)
{
    $baseUrl = rtrim(env('EVOLUTION_API_URL'), '/');
    $instanceName = $instancia->name ?? $instancia->instance_name;
    $apiKey = $instancia->token ?? $instancia->api_key;
    $url = "{$baseUrl}/message/sendText/{$instanceName}";

    Log::info("Tentando envio via Evolution API", [
        'url' => $url,
        'instancia_banco' => $instanceName,
        'telefone_destino' => $telefone
    ]);

    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => $apiKey,
            'Content-Type' => 'application/json'
        ])->post($url, [
            'number' => $telefone,
            'textMessage' => ['text' => $mensagem],
            'delay' => 1200,
            'linkPreview' => true
        ]);

        if ($response->successful()) {
            Log::info("Sucesso! WhatsApp enviado para {$telefone}");
            return true;
        }

        Log::error("ERRO EVOLUTION API (404/500/401)", [
            'status' => $response->status(),
            'resposta' => $response->json(),
            'dica' => 'Se o erro for 404, a instância não existe no servidor da Evolution. Você precisa recriá-la ou renomeá-la.'
        ]);

        return false;

    } catch (\Exception $e) {
        Log::error("Erro de Conexão (Timeout ou URL Inválida): " . $e->getMessage());
        return false;
    }
}


public function getHorariosProfissional(Request $request, $id)
{
    try {
        $profissional = Profissional::find($id);
        if (!$profissional) {
            return response()->json(['error' => 'Profissional não encontrado'], 404);
        }

        // 1. Tratamento seguro dos serviços (Forçando INT para evitar erro no Carbon)
        $servicosIds = $request->input('servicos_ids');
        
        // Se vier do JS como valor único ou array, normalizamos
        $idsParaBusca = is_array($servicosIds) ? $servicosIds : ( $servicosIds ? [$servicosIds] : [] );

        // O cast (int) é vital aqui para evitar o erro Carbon\Carbon::rawAddUnit()
        $duracaoDesejada = (int) \App\Models\Servico::whereIn('id', $idsParaBusca)->sum('duracao');
        
        if ($duracaoDesejada <= 0) {
            $duracaoDesejada = 30; // Fallback para grade padrão
        }

        $horariosConfig = $profissional->horarios;
        if (!$horariosConfig) {
             return response()->json(['error' => 'Agenda não configurada para este profissional.'], 200);
        }

        $dataCarbon = Carbon::parse($request->data);
        $mapaDias = [0 => 'domingo', 1 => 'segunda', 2 => 'terça', 3 => 'quarta', 4 => 'quinta', 5 => 'sexta', 6 => 'sábado'];
        $diaChave = $mapaDias[$dataCarbon->dayOfWeek];

        if (!isset($horariosConfig[$diaChave]) || $horariosConfig[$diaChave]['trabalha'] == "0") {
            return response()->json(['error' => 'Profissional não atende neste dia.'], 200);
        }

        $configDia = $horariosConfig[$diaChave];

        // 2. Busca agendamentos para checar sobreposição (Intervalos Reais)
        $agendamentosNoDia = \App\Models\Agenda::where('profissional_id', $id)
            ->whereDate('data_hora_inicio', $request->data)
            ->where('status', '!=', 'cancelado')
            ->get(['data_hora_inicio', 'data_hora_fim']);

        // 3. Gerar Grade Dinâmica
        $grade = [];
        $inicioExpediente = Carbon::parse($configDia['inicio']);
        $fimExpediente = Carbon::parse($configDia['fim']);
        
        $atual = clone $inicioExpediente;

        // Loop principal: verifica se o início + duração cabe no expediente
        while ($atual->copy()->addMinutes($duracaoDesejada) <= $fimExpediente) {
            $horaInicioSlot = $atual->format('H:i');
            
            // Criamos os objetos Carbon para o intervalo que o usuário deseja ocupar
            $momentoInicio = Carbon::parse($request->data . ' ' . $horaInicioSlot);
            $momentoFim = $momentoInicio->copy()->addMinutes($duracaoDesejada);
            
            $estaOcupado = false;

            // Checa contra agendamentos existentes no banco
            foreach ($agendamentosNoDia as $agendamento) {
                $inicioOcupado = Carbon::parse($agendamento->data_hora_inicio);
                $fimOcupado = Carbon::parse($agendamento->data_hora_fim);

                // Lógica de interseção de horários
                if ($momentoInicio < $fimOcupado && $momentoFim > $inicioOcupado) {
                    $estaOcupado = true;
                    break;
                }
            }

            $grade[] = [
                'hora' => $horaInicioSlot,
                'ocupado' => $estaOcupado
            ];

            // Intervalos de 30 em 30 minutos na visualização da grade
            $atual->addMinutes(30); 
        }

        return response()->json([
            'grade' => $grade, 
            'duracao_aplicada' => $duracaoDesejada,
            'dia_semana' => $diaChave
        ]);

    } catch (\Exception $e) {
        \Log::error("Erro Crítico no Alcecar: " . $e->getMessage());
        return response()->json([
            'error' => 'Erro interno ao processar horários.',
            'debug' => $e->getMessage() 
        ], 500);
    }
}

}