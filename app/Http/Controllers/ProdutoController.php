<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
{
    $query = Produto::query(); // O Trait já filtra a empresa aqui

    if ($request->search) {
        $query->where('nome', 'like', "%{$request->search}%");
    }

    // Busca os produtos paginados para a tabela
    $produtos = $query->orderBy('nome', 'asc')->paginate(15);

    // CALCULO CORRETO: Conta no banco onde atual <= minimo
    // Usamos o clone para não afetar a paginação acima
    $estoqueBaixoCount = Produto::whereRaw('estoque_atual <= estoque_minimo')->count();

    return view('estoque.index', compact('produtos', 'estoqueBaixoCount'));
}

    public function store(Request $request)
    {
        $input = $request->all();

        // Limpeza de moeda (Padrão Alcecar)
        $input['preco_custo'] = str_replace(['.', ','], ['', '.'], $input['preco_custo']);
        $input['preco_venda'] = str_replace(['.', ','], ['', '.'], $input['preco_venda']);
        $request->merge($input);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'preco_custo' => 'required|numeric',
            'preco_venda' => 'required|numeric',
            'estoque_atual' => 'required|integer',
            'estoque_minimo' => 'required|integer',
            'categoria' => 'required|string',
            'marca' => 'nullable|string',
            'codigo_barras' => 'nullable|string',
        ]);

        // O Trait injeta o empresa_id automaticamente no evento 'creating'
        Produto::create($data);

        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
{
    // 1. Localiza o produto (O Trait MultiTenant garante que só ache se for da empresa logada)
    $produto = Produto::findOrFail($id);

    // 2. Captura e limpa os valores de moeda
    $input = $request->all();
    if (isset($input['preco_custo'])) {
        $input['preco_custo'] = str_replace(['.', ','], ['', '.'], $input['preco_custo']);
    }
    if (isset($input['preco_venda'])) {
        $input['preco_venda'] = str_replace(['.', ','], ['', '.'], $input['preco_venda']);
    }
    $request->merge($input);

    // 3. Validação
    $data = $request->validate([
        'nome'           => 'required|string|max:255',
        'preco_custo'    => 'required|numeric',
        'preco_venda'    => 'required|numeric',
        'estoque_atual'  => 'required|integer',
        'estoque_minimo' => 'required|integer',
        'categoria'      => 'required|string',
        'marca'          => 'nullable|string',
        'codigo_barras'  => 'nullable|string',
    ]);

    // 4. Atualiza os dados
    $produto->update($data);

    return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
}
}