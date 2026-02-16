<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financeiro;
use App\Models\Profissional;
use Carbon\Carbon;

class FinanceiroController extends Controller
{
    public function index(Request $request)
{
    $empresaId = auth()->user()->empresa_id ?? auth()->id();

    // Se não houver mês/ano na URL, usa o vigente (atualmente Fevereiro de 2026)
    $mes = $request->get('mes', now()->month);
    $ano = $request->get('ano', now()->year);

    $registros = Financeiro::with(['agendamento', 'profissional'])
        ->where('empresa_id', $empresaId)
        ->whereMonth('data_pagamento', $mes)
        ->whereYear('data_pagamento', $ano)
        ->orderBy('data_pagamento', 'desc')
        ->get();

    $totalReceitas = $registros->where('tipo', 'receita')->sum('valor');
    $totalDespesas = $registros->where('tipo', 'despesa')->sum('valor');
    $totalComissoes = $registros->sum('comissao_valor');
    
    $lucroLiquido = $totalReceitas - $totalDespesas - $totalComissoes;

    $profissionais = Profissional::where('empresa_id', $empresaId)->get();

    return view('financeiro.index', compact(
        'registros', 'totalReceitas', 'totalDespesas', 
        'totalComissoes', 'lucroLiquido', 'profissionais', 'mes', 'ano'
    ));
}

    public function store(Request $request)
{
    // 1. Limpeza manual antes da validação
    $input = $request->all();

    if (isset($input['valor'])) {
        // Transforma "2.500,00" em "2500.00"
        $input['valor'] = str_replace(['.', ','], ['', '.'], $input['valor']);
    }

    if (isset($input['comissao_valor'])) {
        // Transforma "50,00" em "50.00"
        $input['comissao_valor'] = str_replace(['.', ','], ['', '.'], $input['comissao_valor']);
    } else {
        $input['comissao_valor'] = 0;
    }

    // 2. Substitui os dados no Request para que a validação 'numeric' funcione
    $request->merge($input);

    // 3. Agora a validação vai passar!
    $data = $request->validate([
        'descricao'       => 'required|string|max:255',
        'valor'           => 'required|numeric', // Agora ele enxerga 2500.00
        'tipo'            => 'required|in:receita,despesa',
        'data_pagamento'  => 'required|date',
        'forma_pagamento' => 'nullable|string',
        'profissional_id' => 'nullable|exists:profissionais,id',
        'comissao_valor'  => 'nullable|numeric',
        'observacoes'     => 'nullable|string'
    ]);

    $data['empresa_id'] = auth()->user()->empresa_id;

    Financeiro::create($data);

    return redirect()->back()->with('success', 'Lançamento realizado com sucesso!');
}

    public function destroy($id)
    {
        $registro = Financeiro::where('empresa_id', auth()->user()->empresa_id ?? auth()->id())
                             ->findOrFail($id);
        $registro->delete();

        return redirect()->back()->with('success', 'Registro excluído!');
    }

   public function receber()
{
    $empresaId = auth()->user()->empresa_id;

    // Busca os profissionais para o Modal de cadastro
    $profissionais = \App\Models\Profissional::where('empresa_id', $empresaId)
        ->orderBy('nome', 'asc')
        ->get();

    $registros = Financeiro::where('empresa_id', $empresaId)
        ->where('tipo', 'receita')
        ->orderBy('data_pagamento', 'desc')
        ->paginate(15);

    $totalReceber = $registros->sum('valor');

    // Agora enviamos as 3 variáveis para a View
    return view('financeiro.receber', compact('registros', 'totalReceber', 'profissionais'));
}

public function pagar()
{
    $produtos = \App\Models\Produto::orderBy('nome', 'asc')->get();
    $registros = Financeiro::where('empresa_id', auth()->user()->empresa_id)
        ->where('tipo', 'despesa')
        ->orderBy('data_pagamento', 'desc')
        ->paginate(15);

    $totalPagar = $registros->sum('valor');

    return view('financeiro.pagar', compact('registros', 'totalPagar', 'produtos'));
}
}