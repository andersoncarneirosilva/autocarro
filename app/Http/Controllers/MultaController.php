<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MultaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        // 1. Busca multas de veículos que pertencem à EMPRESA
        $multas = Multa::with('veiculo')
            ->whereHas('veiculo', fn($q) => $q->where('empresa_id', $empresaId))
            ->orderBy('data_infracao', 'desc')
            ->paginate(10);

        // 2. Lista de veículos da EMPRESA para o Modal de cadastro
        $veiculos_list = Veiculo::where('empresa_id', $empresaId)
            ->where('status', 'Ativo')
            ->orderBy('placa')
            ->get();

        return view('multas.index', compact('multas', 'veiculos_list'));
    }

    public function store(Request $request)
    {
        $this->limparValor($request);

        $data = $request->validate([
            'veiculo_id'      => 'required|exists:veiculos,id',
            'descricao'       => 'required|string|max:255',
            'valor'           => 'required|numeric',
            'data_infracao'   => 'required|date',
            'codigo_infracao' => 'nullable|string|max:50',
            'data_vencimento' => 'nullable|date',
            'status'          => 'required|in:pendente,pago,recurso',
        ]);

        // Opcional: Adicionar empresa_id na tabela multas se você criou a coluna lá
        $data['empresa_id'] = Auth::user()->empresa_id ?? Auth::id();

        Multa::create($data);

        return redirect()->back()->with('success', 'Multa cadastrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $this->limparValor($request);
        
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        // Garante que a multa pertence a um veículo da empresa
        $multa = Multa::whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->findOrFail($id);

        $data = $request->validate([
            'veiculo_id'      => 'required|exists:veiculos,id',
            'descricao'       => 'required|string|max:255',
            'valor'           => 'required|numeric',
            'data_infracao'   => 'required|date',
            'codigo_infracao' => 'nullable|string|max:50',
            'data_vencimento' => 'nullable|date',
            'orgao_emissor'   => 'nullable|string|max:100',
            'status'          => 'required|in:pendente,pago,recurso',
            'observacoes'     => 'nullable|string',
        ]);

        $multa->update($data);

        return redirect()->route('multas.index')->with('success', 'Multa atualizada com sucesso!');
    }

    public function marcarComoPago($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();

        $multa = Multa::whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->findOrFail($id);

        $multa->update(['status' => 'pago']);

        return redirect()->back()->with('success', 'Multa marcada como paga!');
    }

    public function destroy($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();

        $multa = Multa::whereHas('veiculo', function($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->findOrFail($id);

        $multa->delete();

        return redirect()->back()->with('success', 'Multa excluída com sucesso!');
    }

    private function limparValor(Request $request)
    {
        if ($request->has('valor') && !empty($request->valor)) {
            $valor = $request->valor;
            if (strpos($valor, ',') !== false) {
                $valor = str_replace('.', '', $valor);
                $valor = str_replace(',', '.', $valor);
            } 
            $request->merge(['valor' => (float) $valor]);
        }
    }
}