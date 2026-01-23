<?php

namespace App\Http\Controllers;

use App\Models\Particular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Veiculo;
use App\Models\Anuncio;

class ParticularController extends Controller
{
   public function index()
{
    // 1. Pegamos o ID do usuário particular logado
    $userId = Auth::id();

    // 2. Buscamos apenas os veículos que pertencem a este usuário
    // Usamos o eager loading 'user.revenda' para evitar erros no link de detalhes do seu Blade
    $veiculos = Anuncio::with(['user.revenda'])
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->get();

        //dd($veiculos);
    // 3. Retornamos a view passando a variável veiculos
    return view('particulares.index', compact('veiculos'));
}


    public function create()

    {

        return view('particulares.create');

    }

public function store(Request $request)
{
    $request->validate([
        'ano' => ['required', 'regex:/^\d{4}\/\d{4}$/'],
        'valor' => ['required'], // Certifique-se de validar o valor
    ], [
        'ano.regex' => 'O campo ano deve seguir o padrão Fabricação/Modelo (ex: 2020/2021).'
    ]);

    // Obtém os dados exceto tokens e arquivos
    $data = $request->except(['_token', 'images']);

    // 2. Limpa o 'valor'
    if ($request->filled('valor')) {
        $data['valor'] = str_replace(['.', ','], ['', '.'], $request->valor);
    }

    // 3. Limpa o 'valor_oferta'
    if ($request->filled('valor_oferta')) {
        $data['valor_oferta'] = str_replace(['.', ','], ['', '.'], $request->valor_oferta);
    } else {
        $data['valor_oferta'] = null; // Garante que não envie string vazia
    }

    if (isset($data['kilometragem'])) {
        $data['kilometragem'] = str_replace(',', '', $request->kilometragem);
    }

    // Atribui o Usuário logado ao anúncio
    $data['user_id'] = Auth::id();

    // Tratamento de Adicionais (Transforma ACEITA_TROCA em Aceita Troca)
    $adicionaisArray = array_map(function ($item) {
        return ucwords(str_replace('_', ' ', strtolower($item)));
    }, $request->input('adicionais', []));
    $data['adicionais'] = json_encode($adicionaisArray, JSON_UNESCAPED_UNICODE);

    // Tratamento de Opcionais (Transforma AIRBAG em Airbag)
    $opcionaisArray = array_map(function ($item) {
        return ucwords(str_replace('_', ' ', strtolower($item)));
    }, $request->input('opcionais', []));
    $data['opcionais'] = json_encode($opcionaisArray, JSON_UNESCAPED_UNICODE);

    // Upload de múltiplas imagens
    $imagens = [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('veiculos', 'public');
            $imagens[] = $path;
        }
    }
    $data['images'] = json_encode($imagens);

    // --- CAMPOS MANUAIS FIXOS ---
    $data['status'] = 'ATIVO'; 
    $data['status_anuncio'] = 'Publicado';
    $data['placa'] = strtoupper($request->placa);

    // Cria o registro no banco de dados
    Anuncio::create($data);

    return redirect()
        ->route('particulares.index')
        ->with('success', 'Anúncio cadastrado com sucesso!');
}

    public function show(Particular $particular)
    {
        return $particular;
    }

    public function update(Request $request, Particular $particular)
    {
        $particular->update($request->all());
        return $particular;
    }

    public function destroy($id)
{
    // Busca o anúncio garantindo que pertence ao usuário logado (segurança)
    $anuncio = Anuncio::where('user_id', Auth::id())->findOrFail($id);

    // Opcional: Deletar as imagens do storage antes de excluir o registro
    $imagens = json_decode($anuncio->images, true) ?? [];
    foreach ($imagens as $img) {
        if (Storage::disk('public')->exists($img)) {
            Storage::disk('public')->delete($img);
        }
    }

    $anuncio->delete();

    return redirect()->route('particulares.index')
        ->with('success', 'Anúncio removido com sucesso!');
}
}