<?php

namespace App\Http\Controllers;

use App\Models\Multa;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MultaController extends Controller
{
    public function index()
{
    $userId = Auth::id();
    // Pega as multas com paginação
    $multas = Multa::with('veiculo')
        ->whereHas('veiculo', fn($q) => $q->where('user_id', $userId))
        ->paginate(10);

    // Pega todos os veículos para o Select do Modal
    $veiculos_list = Veiculo::where('user_id', $userId)->orderBy('placa')->get();

    return view('multas.index', compact('multas', 'veiculos_list'));
}

    public function store(Request $request)
{
    // 1. Limpa o valor usando APENAS a sua função auxiliar
    $this->limparValor($request);

    // 2. Validação (O valor já estará no formato 145.90 aqui)
    $data = $request->validate([
        'veiculo_id'      => 'required|exists:veiculos,id',
        'descricao'       => 'required|string|max:255',
        'valor'           => 'required|numeric',
        'data_infracao'   => 'required|date',
        'codigo_infracao' => 'nullable|string|max:50',
        'data_vencimento' => 'nullable|date',
        'status'          => 'required|in:pendente,pago,recurso',
    ]);

    Multa::create($data);

    return redirect()->back()->with('success', 'Multa cadastrada com sucesso!');
}

public function update(Request $request, $id)
{
    // 1. Limpa o valor APENAS UMA VEZ usando o método auxiliar
    $this->limparValor($request);

    $userId = auth()->id();
    $multa = Multa::whereHas('veiculo', function($q) use ($userId) {
        $q->where('user_id', $userId);
    })->findOrFail($id);

    // 2. Validação (O valor já chega aqui como 190.00)
    $data = $request->validate([
        'veiculo_id'      => 'required|exists:veiculos,id',
        'descricao'       => 'required|string|max:255',
        'valor'           => 'required|numeric', // Agora passa sem erro
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

    

   private function limparValor(Request $request)
{
    if ($request->has('valor') && !empty($request->valor)) {
        $valor = $request->valor;

        // Se o valor contiver vírgula (veio da máscara do JS)
        if (strpos($valor, ',') !== false) {
            $valor = str_replace('.', '', $valor);  // Remove o ponto de milhar (ex: 1.250,00 -> 1250,00)
            $valor = str_replace(',', '.', $valor); // Troca a vírgula pelo ponto (ex: 1250,00 -> 1250.00)
        } 
        // Se não tiver vírgula, mas for apenas números, o Laravel já entende como float/int

        $request->merge(['valor' => (float) $valor]);
    }
}
public function updateStatus(Request $request, $id)
    {
        $multa = Multa::findOrFail($id);
        $multa->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status da multa atualizado!');
    }
public function marcarComoPago($id)
{
    $multa = Multa::whereHas('veiculo', function($q) {
        $q->where('user_id', auth()->id());
    })->findOrFail($id);

    $multa->update(['status' => 'pago']);

    return redirect()->back()->with('success', 'Multa marcada como paga!');
}

    public function destroy($id)
{
    $userId = auth()->id();
    $multa = Multa::whereHas('veiculo', function($q) use ($userId) {
        $q->where('user_id', $userId);
    })->findOrFail($id);

    $multa->delete();

    return redirect()->back()->with('success', 'Multa excluída com sucesso!');
}
}