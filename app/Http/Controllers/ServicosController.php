<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicosController extends Controller
{
    public function index()
    {
        // Pega os serviços da empresa logada
        $servicos = Servico::where('empresa_id', auth()->user()->empresa_id)->get();
        return view('servicos.index', compact('servicos'));
    }

    public function store(Request $request)
{
    $precoLimpo = str_replace(['.', ','], ['', '.'], $request->preco);
    $empresaId = auth()->user()->empresa_id;

    $request->merge(['preco' => $precoLimpo]);

    $request->validate([
        'nome' => 'required|string|max:255',
        'preco' => 'required|numeric',
        'duracao' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validação da image
    ]);

    $caminhoimage = null;
    if ($request->hasFile('image')) {
        // Salva em: storage/app/public/servicos/ID_DA_EMPRESA
        $caminhoimage = $request->file('image')->store("servicos/{$empresaId}", 'public');
    }

    Servico::create([
        'nome' => $request->nome,
        'preco' => $request->preco,
        'duracao' => $request->duracao,
        'descricao' => $request->descricao,
        'image' => $caminhoimage, // Salva o caminho no banco
        'empresa_id' => $empresaId,
    ]);

    return redirect()->back()->with('success', 'Serviço salvo!');
}


public function update(Request $request, $id)
{
    $servico = Servico::findOrFail($id);
    $empresaId = auth()->user()->empresa_id;

    // Tratamento do preço
    $precoRaw = $request->preco;
    $precoLimpo = str_contains($precoRaw, ',') 
        ? str_replace(',', '.', str_replace('.', '', $precoRaw)) 
        : $precoRaw;
    
    $precoFinal = (float) $precoLimpo;
    $request->merge(['preco' => $precoFinal]);

    $request->validate([
        'nome' => 'required|string|max:255',
        'preco' => 'required|numeric',
        'duracao' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $dados = [
        'nome' => $request->nome,
        'preco' => $precoFinal,
        'duracao' => $request->duracao,
        'descricao' => $request->descricao,
    ];

    if ($request->hasFile('image')) {
        // 1. Deleta a image antiga se existir no storage
        if ($servico->image && \Storage::disk('public')->exists($servico->image)) {
            \Storage::disk('public')->delete($servico->image);
        }

        // 2. Sobe a nova image
        $dados['image'] = $request->file('image')->store("{$empresaId}/servicos", 'public');
    }

    $servico->update($dados);

    return redirect()->route('servicos.index')->with('success', 'Serviço atualizado!');
}

    public function destroy($id)
{
    // 1. Busca o serviço garantindo que pertence à empresa do usuário
    $servico = Servico::where('id', $id)
        ->where('empresa_id', auth()->user()->empresa_id)
        ->firstOrFail();

    // 2. Verifica se o serviço possui image e se ela existe no disco 'public'
    if ($servico->image && \Storage::disk('public')->exists($servico->image)) {
        \Storage::disk('public')->delete($servico->image);
    }

    // 3. Deleta o registro do banco de dados
    $servico->delete();

    return redirect()->back()->with('success', 'Serviço e imagem removidos com sucesso!');
}
}