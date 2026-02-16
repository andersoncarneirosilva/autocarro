<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendWhatsappReminders extends Command
{
    protected $signature = 'whatsapp:send-reminders';
    protected $description = 'Envia lembretes de agendamento via WhatsApp';

    public function handle()
{
    //Log::info('--- INÍCIO DO PROCESSO DE LEMBRETES ---');

    $configuracoes = \App\Models\WhatsappSetting::where('reminder_is_active', true)->get();
    
    //Log::info("Empresas ativas encontradas no banco: " . $configuracoes->count());

    foreach ($configuracoes as $config) {
        //Log::info("Processando Empresa ID: {$config->empresa_id}");
        
        $instancia = \App\Models\WhatsappInstance::where('empresa_id', $config->empresa_id)->first();

        if (!$instancia) {
            //Log::warning("Empresa {$config->empresa_id} sem instância de WhatsApp conectada.");
            continue;
        }

        $minutosParaEnvio = (int) $config->reminder_time;
        $alvo = now()->addMinutes($minutosParaEnvio);
        $inicioJanela = (clone $alvo)->subMinutes(5);
        $fimJanela = (clone $alvo)->addMinutes(5);

        Log::info("Buscando agendamentos entre {$inicioJanela->format('H:i')} e {$fimJanela->format('H:i')}");

        $agendamentos = \App\Models\Agenda::where('empresa_id', $config->empresa_id)
            ->where('status', 'confirmado')
            ->whereNull('lembrete_enviado_em')
            ->whereBetween('data_hora_inicio', [$inicioJanela, $fimJanela])
            ->get();

        Log::info("Agendamentos encontrados: " . $agendamentos->count());

        $agendamentos = \App\Models\Agenda::where('empresa_id', $config->empresa_id)
            ->where('status', 'confirmado')
            ->whereNull('lembrete_enviado_em')
            ->whereBetween('data_hora_inicio', [$inicioJanela, $fimJanela]) // Busca no futuro
            ->get();
        // -------------------

        Log::info("Empresa {$config->empresa_id}: Aguardando agendamentos para daqui a {$minutosParaEnvio}min. Encontrados: " . $agendamentos->count());

        foreach ($agendamentos as $agenda) {
            $enviado = $this->dispararWhatsApp($agenda, $config->reminder_template, $instancia);

            if ($enviado) {
                $agenda->update(['lembrete_enviado_em' => now()]);
            }
        }
    }

    Log::info('--- FIM DO PROCESSO DE LEMBRETES ---');
}

    private function dispararWhatsApp($agenda, $template, $instancia)
{
    $baseUrl = rtrim(env('EVOLUTION_API_URL'), '/');

    // 1. Extração de dados para as novas variáveis
    // Pegando o primeiro serviço do array decodificado
    $servicos = is_array($agenda->servicos_json) ? $agenda->servicos_json : json_decode($agenda->servicos_json, true);
    $nomeServico = $servicos[0]['nome'] ?? 'Serviço';

    // Buscando nomes através dos relacionamentos (certifique-se que existam na Model Agenda)
    $nomeProfissional = $agenda->profissional->nome ?? 'Profissional';
    $nomeEmpresa = $agenda->empresa->name ?? 'nossa empresa';

    // 2. Substituição expandida de variáveis
    $mensagem = str_replace(
        ['{nome}', '{horario_inicio}', '{data}', '{serviço}', '{profissional}', '{empresa}'],
        [
            $agenda->cliente_nome, 
            \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('H:i'), 
            \Carbon\Carbon::parse($agenda->data_hora_inicio)->format('d/m'),
            $nomeServico,
            $nomeProfissional,
            $nomeEmpresa
        ],
        $template
    );

    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'apikey' => $instancia->token 
        ])->post("{$baseUrl}/message/sendText/{$instancia->name}", [
            'number' => $agenda->cliente_telefone,
            'textMessage' => [
                'text' => $mensagem
            ],
            'delay' => 1200,
            'linkPreview' => true
        ]);

        if ($response->successful()) {
            \Illuminate\Support\Facades\Log::info("WhatsApp enviado com sucesso para: {$agenda->cliente_telefone}");
            return true;
        }

        \Illuminate\Support\Facades\Log::error("Erro na resposta da Evolution API", [
            'status' => $response->status(),
            'body' => $response->json()
        ]);
        return false;

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Erro crítico: " . $e->getMessage());
        return false;
    }
}
}