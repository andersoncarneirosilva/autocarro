<?php

namespace App\Http\Controllers;

use App\Models\VeiculoGasto;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoGastoController extends Controller
{
    public function index(Request $request)
{
    // Buscamos os gastos com o relacionamento do veículo carregado
    // para evitar o problema de N+1 consultas (performance)
    $query = VeiculoGasto::with('veiculo');

    // Filtro opcional por veículo (caso queira filtrar na tela geral)
    if ($request->has('veiculo_id')) {
        $query->where('veiculo_id', $request->veiculo_id);
    }

    $veiculos = Veiculo::orderBy('placa')->get();

    $gastos = $query->orderBy('data_gasto', 'desc')->paginate(15);

    return view('gastos.index', compact('gastos', 'veiculos'));
}

    public function store(Request $request)
{
    // 1. Tratamento do Valor (Converte R$ para Decimal)
    if ($request->filled('valor')) {
        $valorLimpo = str_replace(['.', ','], ['', '.'], $request->valor);
        $request->merge(['valor' => $valorLimpo]);
    }

    // 2. Garantir que a multa tenha uma data (se o modal não enviou)
    if ($request->categoria === 'Multa' && !$request->filled('data_gasto')) {
        $request->merge(['data_gasto' => now()->format('Y-m-d')]);
    }

    // 3. Validação Flexível
    $dadosValidados = $request->validate([
        'veiculo_id'      => 'required|exists:veiculos,id',
        'categoria'       => 'required|string',
        'descricao'       => 'required|string|max:255',
        'valor'           => 'required|numeric',
        'data_gasto'      => 'required|date', // Se for multa e não tiver data, o merge acima resolve
        'fornecedor'      => 'nullable|string|max:255',
        'codigo_infracao' => 'nullable|string|max:100', // IMPORTANTE: Deve estar aqui!
        'pago'            => 'nullable'
    ]);

    // 4. Ajuste do Pago
    $dadosValidados['pago'] = $request->has('pago') ? 1 : 0;

    // 5. Salvar
    try {
        VeiculoGasto::create($dadosValidados);
        
        $msg = $request->categoria === 'Multa' ? 'Multa registrada!' : 'Gasto registrado!';
        return redirect()->back()->with('success', $msg);
        
    } catch (\Exception $e) {
        // Se der erro, ele te avisa o que foi
        return redirect()->back()->with('error', 'Erro ao salvar: ' . $e->getMessage());
    }
}

    // Deletar um gasto se necessário
    public function destroy($id)
    {
        $gasto = VeiculoGasto::findOrFail($id);
        $gasto->delete();

        return redirect()->back()->with('success', 'Gasto removido!');
    }

    public function alternarPagamento($id)
    {
        // A Trait já garante que você só encontre gastos da SUA empresa
        $gasto = VeiculoGasto::findOrFail($id);
        
        $gasto->update([
            'pago' => !$gasto->pago
        ]);

        $mensagem = $gasto->pago ? 'Pagamento confirmado!' : 'Pagamento estornado!';
        
        return redirect()->back()->with('success', $mensagem);
    }
}