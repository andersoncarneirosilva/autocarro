<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Profissional;
use App\Models\Servico;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Cliente;
use App\Models\Financeiro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PublicAgendamentoController extends Controller
{
    public function index($slug)
    {
        // 1. Busca o salão pelo slug ou falha se não existir
        $salao = Empresa::where('slug', $slug)->firstOrFail();

        // 2. Busca dados vinculados a este salão específico
        $profissionais = Profissional::where('empresa_id', $salao->id)->get();
        $servicos = Servico::where('empresa_id', $salao->id)->get();

        return view('publico.agendamento', compact('salao', 'profissionais', 'servicos'));
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