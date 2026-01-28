<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendedorController extends Controller
{
    /**
     * Exibe apenas os vendedores da mesma empresa do Admin logado
     */
    public function index()
    {
        // Pega o ID da empresa do Admin (se ele não tiver empresa_id, assume o próprio ID)
        $empresaId = auth()->user()->empresa_id ?? auth()->id();

        $vendedores = User::where('nivel_acesso', 'Vendedor')
            ->where('empresa_id', $empresaId) // Filtra pela empresa
            ->orderBy('name')
            ->get();
        
        return view('vendedores.index', compact('vendedores'));
    }

    /**
     * Salva um novo vendedor vinculado à empresa do Admin
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'cpf'      => 'required|unique:users,cpf',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'cpf.required'  => 'O campo CPF é obrigatório.',
            'cpf.unique'    => 'Este CPF já está cadastrado no sistema.',
            'email.unique'  => 'Este e-mail já está em uso.',
        ]);

        // Lógica de Empresa: 
        // Se o Anderson (ID 1) cadastrar, o empresa_id será 1.
        $empresaId = auth()->user()->empresa_id ?? auth()->id();

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'cpf'          => $request->cpf,
            'telefone'     => $request->telefone,
            'password'     => Hash::make($request->password), 
            'nivel_acesso' => 'Vendedor',
            'empresa_id'   => $empresaId, // <-- VINCULAÇÃO AQUI
            'status'       => 'Ativo',
        ]);

        return redirect()->route('vendedores.index')->with('success', 'Vendedor cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $empresaId = auth()->user()->empresa_id ?? auth()->id();

        // Garante que o Admin só edite vendedores da sua própria empresa
        $vendedor = User::where('nivel_acesso', 'Vendedor')
            ->where('empresa_id', $empresaId)
            ->findOrFail($id);

        return response()->json($vendedor);
    }

    public function update(Request $request, $id)
    {
        $empresaId = auth()->user()->empresa_id ?? auth()->id();

        $vendedor = User::where('nivel_acesso', 'Vendedor')
            ->where('empresa_id', $empresaId)
            ->findOrFail($id);

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
            $data['password'] = Hash::make($request->password);
        }

        $vendedor->update($data);

        return redirect()->route('vendedores.index')->with('success', 'Vendedor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $empresaId = auth()->user()->empresa_id ?? auth()->id();

        $vendedor = User::where('nivel_acesso', 'Vendedor')
            ->where('empresa_id', $empresaId)
            ->findOrFail($id);
            
        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('success', 'Vendedor removido do sistema.');
    }
}