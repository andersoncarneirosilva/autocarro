<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(Request $request)
    {
        $userLogado = Auth::user();
        $empresaId = $userLogado->empresa_id ?? $userLogado->id;
        $search = $request->query('search');

        // LÓGICA ALCECAR: Filtra apenas usuários da mesma empresa
        $users = User::where('empresa_id', $empresaId)
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('telefone', 'LIKE', "%{$search}%");
                });
            })
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
{
    $userLogado = Auth::user();
    // No Alcecar, a empresa_id do dono é o seu próprio ID
    $empresaId = $userLogado->empresa_id ?? $userLogado->id;

    // 1. Definição dos limites (Dono + Vendedores)
    $limites = [
        'Start'    => 1, // Só o dono
        'Standard' => 6, // Dono + 5 vendedores
        'Pro'      => 999 // Ilimitado
    ];

    // Buscamos o plano do DONO da empresa para validar o limite
    $dono = User::find($empresaId);
    $planoAtual = $dono->plano ?? 'Start';
    $limiteMaximo = $limites[$planoAtual] ?? 1;

    // Conta quantos usuários já existem nessa empresa
    $totalNaEmpresa = User::where('empresa_id', $empresaId)->count();

    // TRAVA DE LIMITE: Verifica se pode adicionar mais um
    if ($totalNaEmpresa >= $limiteMaximo) {
        $msg = $planoAtual == 'Start' 
            ? "Seu plano Start não permite vendedores adicionais." 
            : "Limite atingido! Seu plano {$planoAtual} permite no máximo " . ($limiteMaximo - 1) . " vendedores.";
            
        return redirect()->back()->with('error', $msg)->withInput();
    }

    // 2. Limpa o CPF (remove pontos e traço) antes da validação
    if ($request->has('cpf')) {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', $request->cpf),
        ]);
    }

    try {
        // 3. Validação detalhada
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'cpf'      => 'required|string|unique:users,cpf',
            'telefone' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'Este e-mail já está em uso.',
            'cpf.unique'   => 'Este CPF já está cadastrado no Alcecar.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.'
        ]);

        // 4. Preparação e Criação
        $data = $request->all();
        $data['password']     = Hash::make($request->password);
        $data['status']       = 'Ativo';
        $data['nivel_acesso'] = 'Vendedor';
        $data['empresa_id']   = $empresaId;
        $data['plano']        = $planoAtual; // Herda o plano do dono para consistência

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Vendedor cadastrado com sucesso!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->validator->errors()->all();
        return redirect()->back()->with('error', $errors[0])->withInput();
        
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro interno: ' . $e->getMessage())->withInput();
    }
}

    public function update(Request $request, $id)
{
    $empresaId = Auth::user()->empresa_id ?? Auth::id();
    $user = User::where('empresa_id', $empresaId)->findOrFail($id);

    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email,' . $id,
        'telefone' => 'nullable|string',
        'password' => 'nullable|string|min:8',
        'status'   => 'required|in:Ativo,Inativo',
    ]);

    $data = $request->only(['name', 'email', 'telefone', 'status']);

    // Só atualiza a senha se o campo for preenchido
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index')->with('success', 'Vendedor atualizado com sucesso!');
}

    public function destroy($id)
    {
        $userLogado = Auth::user();
        $empresaId = $userLogado->empresa_id ?? $userLogado->id;

        if ($userLogado->id === (int) $id) {
            return redirect()->route('users.index')->with('error', 'Você não pode se excluir!');
        }

        // Busca o usuário garantindo que ele pertence à mesma empresa
        $user = User::where('empresa_id', $empresaId)->find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'Usuário não encontrado na sua equipe!');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Membro da equipe removido!');
    }
}