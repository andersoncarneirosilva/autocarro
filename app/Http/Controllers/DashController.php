<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Produto;
use App\Models\Financeiro;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashController extends Controller
{
    public function index(Request $request) 
{
    $empresaId = auth()->user()->empresa_id;

    $range = $request->get('date');

    if ($range && str_contains($range, ' - ')) {
        $dates = explode(' - ', $range);
        // Criamos o Carbon a partir do 01/MM/YYYY que enviamos via JS
        $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->startOfMonth();
        $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->endOfMonth();
    } else {
        $startDate = now()->startOfYear();
        $endDate = now()->endOfYear();
    }

    // 2. Widgets (Totais do período selecionado)
    $receitasMes = Financeiro::where('empresa_id', $empresaId)
        ->where('tipo', 'receita')
        ->whereBetween('data_pagamento', [$startDate, $endDate])
        ->sum('valor');

    $despesasMes = Financeiro::where('empresa_id', $empresaId)
        ->where('tipo', 'despesa')
        ->whereBetween('data_pagamento', [$startDate, $endDate])
        ->sum('valor');

    $estoqueBaixo = Produto::where('empresa_id', $empresaId)
        ->whereRaw('estoque_atual <= estoque_minimo')->count();

    // 3. Agrupamento por Mês para o Gráfico
    $labels = [];
    $dataReceitas = [];
    $dataDespesas = [];

    // Criamos um período que pula de mês em mês
    $periodo = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);

    foreach ($periodo as $mes) {
        $labels[] = $mes->translatedFormat('M/Y'); // Ex: Jan/2026

        $dataReceitas[] = (float) Financeiro::where('empresa_id', $empresaId)
            ->where('tipo', 'receita')
            ->whereMonth('data_pagamento', $mes->month)
            ->whereYear('data_pagamento', $mes->year)
            ->sum('valor');

        $dataDespesas[] = (float) Financeiro::where('empresa_id', $empresaId)
            ->where('tipo', 'despesa')
            ->whereMonth('data_pagamento', $mes->month)
            ->whereYear('data_pagamento', $mes->year)
            ->sum('valor');
    }

    $rangeSelecionado = $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');

    // Semanas
    $inicioSemanaAtual = now()->startOfWeek();
    $fimSemanaAtual = now()->endOfWeek();
    $inicioSemanaPassada = now()->subWeek()->startOfWeek();
    $fimSemanaPassada = now()->subWeek()->endOfWeek();

    $labelsSemana = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
    $dadosSemanaAtual = [];
    $dadosSemanaPassada = [];

    for ($i = 0; $i < 7; $i++) {
        // Semana Atual
        $diaAtual = $inicioSemanaAtual->copy()->addDays($i)->format('Y-m-d');
        $dadosSemanaAtual[] = (float) Financeiro::where('empresa_id', $empresaId)
            ->where('tipo', 'receita')
            ->whereDate('data_pagamento', $diaAtual)->sum('valor');

        // Semana Passada
        $diaPassado = $inicioSemanaPassada->copy()->addDays($i)->format('Y-m-d');
        $dadosSemanaPassada[] = (float) Financeiro::where('empresa_id', $empresaId)
            ->where('tipo', 'receita')
            ->whereDate('data_pagamento', $diaPassado)->sum('valor');
    }

    $totalSemanaAtual = array_sum($dadosSemanaAtual);
    $totalSemanaPassada = array_sum($dadosSemanaPassada);

    $agendamentos = Agenda::with('cliente')
    ->where('empresa_id', auth()->user()->empresa_id)
    ->orderBy('data_hora_inicio', 'desc')
    ->take(10)
    ->get();

    return view('dashboard.index', compact(
        'receitasMes', 'despesasMes', 'estoqueBaixo', 
        'labels', 'dataReceitas', 'dataDespesas', 'startDate', 'endDate',
        'labelsSemana', 'dadosSemanaAtual', 'dadosSemanaPassada', 
        'totalSemanaAtual', 'totalSemanaPassada', 'agendamentos'
    ));
}

}