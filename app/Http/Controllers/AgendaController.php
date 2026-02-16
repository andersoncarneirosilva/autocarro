<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Servico;
use App\Models\Profissional;
use App\Models\Cliente;
use App\Models\Financeiro;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AgendaController extends Controller
{
    public function index()
    {
        $profissional = Profissional::all();
        $servicos = Servico::all();
        $clientes = Cliente::all(); // Busque todos os clientes

        // Adicione 'clientes' ao retorno da view
        return view('agenda.index', compact('profissional', 'servicos', 'clientes'));
    }



public function store(Request $request)
{
    // 1. Validação básica
    $request->validate([
        'data_agendamento' => 'required',
        'hora_selecionada' => 'required',
        'profissional_id'  => 'required',
        'servicos_ids'     => 'required|array'
    ]);

    $servicosSelecionados = Servico::whereIn('id', $request->servicos_ids)->get();
    
    $totalPreco = 0;
    $totalDuracao = 0;
    $servicosSnapshot = [];
    $nomesServicos = [];

    foreach ($servicosSelecionados as $s) {
        $totalPreco += $s->preco;
        $totalDuracao += $s->duracao;
        $nomesServicos[] = $s->nome;
        $servicosSnapshot[] = [
            'id' => $s->id,
            'nome' => $s->nome,
            'preco' => $s->preco
        ];
    }

    $dataHoraString = $request->data_agendamento . ' ' . $request->hora_selecionada;
    $inicio = Carbon::parse($dataHoraString);
    $fim = (clone $inicio)->addMinutes($totalDuracao);

    $empresaId = auth()->user()->empresa_id ?? 1;

    // 2. Criar o Agendamento (Agenda)
    $agenda = Agenda::create([
        'profissional_id'  => $request->profissional_id,
        'cliente_nome'     => $request->cliente_nome,
        'cliente_telefone' => $request->cliente_telefone,
        'servicos_json'    => $servicosSnapshot,
        'data_hora_inicio' => $inicio,
        'data_hora_fim'    => $fim,
        'valor_total'      => $totalPreco,
        'status'           => 'pendente',
        'empresa_id'       => $empresaId,
    ]);

    // 3. Lógica de Comissão (Exemplo: 30% ou pegando do profissional)
    // Se você tiver a coluna 'comissao' na tabela profissionais, pode usar: 
    // $profissional = Profissional::find($request->profissional_id);
    // $valorComissao = ($totalPreco * ($profissional->comissao / 100));
    $valorComissao = $totalPreco * 0.30; // Valor fixo de 30% como exemplo

    // 4. Criar o registro automático em Financeiro (Contas a Receber)
    Financeiro::create([
        'empresa_id'      => $empresaId,
        'agendamento_id'  => $agenda->id,
        'profissional_id' => $request->profissional_id,
        'descricao'       => "Serviço: " . implode(', ', $nomesServicos) . " - Cliente: " . $request->cliente_nome,
        'valor'           => $totalPreco,
        'comissao_valor'  => $valorComissao,
        'tipo'            => 'receita', // Identifica como Contas a Receber
        'forma_pagamento' => 'Pendente', // Será preenchido na finalização
        'data_pagamento'  => $inicio->format('Y-m-d'), // Data prevista
        'observacoes'     => 'Gerado automaticamente via agendamento.',
    ]);

    return redirect()->back()->with('success', 'Agendado e lançado no financeiro com sucesso!');
}

public function getEventos()
{
    return Agenda::with('profissional')->get()->map(function($a) {
        // Pega a cor do profissional ou usa azul como fallback
        // Se estiver concluído, podemos forçar uma cor verde para facilitar a visão
        $corOriginal = $a->profissional->cor_agenda ?? '#727cf5';
        $cor = ($a->status == 'Concluído') ? '#0acf97' : $corOriginal;

        return [
            'id'              => $a->id,
            'title'           => $a->cliente_nome,
            'start'           => $a->data_hora_inicio->toIso8601String(),
            'end'             => $a->data_hora_fim->toIso8601String(),
            'backgroundColor' => $cor,
            'borderColor'     => $cor,
            'textColor'       => '#ffffff',
            'allDay'          => false,
            
            // ADICIONE ESTAS LINHAS ABAIXO:
            'extendedProps' => [
                'valor_total'   => $a->valor_total,
                'status'        => $a->status,
                'servico'       => $a->servicos_json[0]['nome'] ?? 'Serviço',
            ]
        ];
    });
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

public function concluirAtendimento(Request $request)
{
    // Validação básica
    $request->validate([
        'agenda_id' => 'required|exists:agendas,id',
        'forma_pagamento' => 'required'
    ]);

    try {
        $agenda = Agenda::findOrFail($request->agenda_id);

        // 1. Atualiza o status do agendamento
        $agenda->status = 'Concluído';
        $agenda->save();

        // 2. Localiza o registro financeiro vinculado (criado no momento do agendamento)
        // Procuramos pelo agendamento_id na sua tabela financeiro
        $financeiro = \App\Models\Financeiro::where('agendamento_id', $agenda->id)->first();

        if ($financeiro) {
            $financeiro->update([
                'forma_pagamento' => $request->forma_pagamento,
                'data_pagamento'  => now(),
                // Se você tiver um campo de status no financeiro, mude para pago/confirmado
                'observacoes'     => $financeiro->observacoes . " | Finalizado via Calendário em " . now()->format('d/m/Y H:i')
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Atendimento finalizado com sucesso!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erro ao processar: ' . $e->getMessage()
        ], 500);
    }
}

}