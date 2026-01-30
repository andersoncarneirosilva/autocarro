<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    protected $model;

    public function __construct(Cliente $cliente)
    {
        $this->model = $cliente;
    }

    public function index(Request $request)
    {
        confirmDelete('Atenção', 'Deseja excluir esse cliente?');

        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        // Ajuste no Model: getClientes agora deve receber o empresaId
        // Se o seu model ainda usa userId lá dentro, mude para empresaId
        $clientes = $this->model->getClientes($request->search, $empresaId);

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;

        try {
            $validatedData = $request->validate([
                'nome' => 'required|string|max:255',
                'cpf' => 'required|string|max:255',
                'rg' => 'required|string|max:255',
                'fone' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'cep' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'numero' => 'required|string|max:255',
                'bairro' => 'required|string|max:255',
                'cidade' => 'required|string|max:255',
                'estado' => 'required|string|max:255',
                'complemento' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            alert()->error('Todos os campos são obrigatórios!');
            return redirect()->route('clientes.create');
        }

        // LÓGICA ALCECAR: Salva quem criou e a qual empresa pertence
        $validatedData['user_id'] = $user->id;
        $validatedData['empresa_id'] = $empresaId;

        $cliente = $this->model->create($validatedData);

        if ($cliente) {
            return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
        }

        return redirect()->route('clientes.index')->with('error', 'Erro ao cadastrar cliente!');
    }

    public function buscarClientes(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->empresa_id ?? $user->id;
        $search = $request->get('term');

        // Busca apenas clientes da mesma EMPRESA
        $clientes = Cliente::where('empresa_id', $empresaId)
            ->where('nome', 'like', "%$search%")
            ->get();

        return response()->json($clientes->map(function ($cliente) {
            return ['id' => $cliente->id, 'text' => $cliente->nome];
        }));
    }

    public function edit($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();

        // Garante que só edita clientes da própria empresa
        $cliente = $this->model->where('empresa_id', $empresaId)->find($id);

        if (!$cliente) {
            return redirect()->route('clientes.index')->with('error', 'Cliente não encontrado.');
        }

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();
        $cliente = $this->model->where('empresa_id', $empresaId)->find($id);

        if (!$cliente) {
            alert()->error('Erro: Cliente não encontrado!');
            return redirect()->route('clientes.index');
        }

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'rg' => 'required|string|max:255',
            'fone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cep' => 'required|string|max:255',
            'endereco' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'complemento' => 'nullable|string|max:255',
        ]);

        $cliente->update($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();
        $cli = $this->model->where('empresa_id', $empresaId)->find($id);

        if (!$cli) {
            alert()->error('Erro ao excluir: Cliente não encontrado!');
            return redirect()->route('clientes.index');
        }

        $cli->delete();
        return back()->with('success', 'Cliente excluído com sucesso!');
    }
}