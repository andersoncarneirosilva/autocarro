<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendedorController extends Controller
{
    /**
     * Exibe a listagem de vendedores
     */
    public function index()
{
    // O Laravel já sabe que deve buscar na tabela 'users' onde nivel_acesso = 'Vendedor'
    $vendedores = Vendedor::orderBy('name')->get();
    
    return view('vendedores.index', compact('vendedores'));
}

    /**
     * Salva um novo vendedor e redireciona para a index
     */
    public function store(Request $request)
{
    // Ajuste as regras para os nomes reais dos inputs
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'cpf'      => 'required|unique:users,cpf',
        'password' => 'required|min:8',
    ], [
        // Mensagens personalizadas para o Alcecar
        'name.required' => 'O campo nome é obrigatório.',
        'cpf.required'  => 'O campo CPF é obrigatório.',
        'cpf.unique'    => 'Este CPF já está cadastrado no sistema.',
        'email.unique'  => 'Este e-mail já está em uso.',
    ]);

    // Cria o usuário na tabela users
    \App\Models\User::create([
        'name'         => $request->name,
        'email'        => $request->email,
        'cpf'          => $request->cpf,
        'telefone'     => $request->telefone,
        'password'     => bcrypt($request->password), // Criptografa a senha
        'nivel_acesso' => 'Vendedor',
        'status'       => 'Ativo',
    ]);

    return redirect()->route('vendedores.index')->with('success', 'Vendedor cadastrado com sucesso!');
}

   public function edit($id)
{
    $vendedor = \App\Models\User::where('nivel_acesso', 'Vendedor')->findOrFail($id);
    return response()->json($vendedor);
}

public function update(Request $request, $id)
{
    $vendedor = \App\Models\User::where('nivel_acesso', 'Vendedor')->findOrFail($id);

    $rules = [
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'cpf'   => 'required|unique:users,cpf,' . $id,
    ];

    if ($request->filled('password')) {
        $rules['password'] = 'min:8';
    }

    $request->validate($rules);

    $data = $request->only(['name', 'email', 'cpf', 'telefone', 'status']);
    
    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    $vendedor->update($data);

    return redirect()->route('vendedores.index')->with('success', 'Vendedor atualizado com sucesso!');
}

    /**
     * Remove um vendedor e redireciona para a index
     */
    public function destroy($id)
    {
        $vendedor = Vendedor::where('user_id', Auth::id())->findOrFail($id);
        $vendedor->delete();

        return redirect()->route('vendedores.index')
                         ->with('success', 'Vendedor removido do sistema.');
    }
}