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
        $empresaId = $userLogado->empresa_id ?? $userLogado->id;

        try {
            $validatedData = $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => 'required|email|unique:users,email',
                'telefone'     => 'required|string',
                'nivel_acesso' => 'required|string',
                'password'     => 'required|string|min:8|confirmed',
                'image'        => 'nullable|image|max:2048',
            ]);

            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['status'] = 'Ativo';
            
            // LÓGICA ALCECAR: Vincula o novo usuário à empresa do gestor
            $data['empresa_id'] = $empresaId;

            if ($request->hasFile('image')) {
                $nameSlug = Str::slug($request->name);
                $fileName = $nameSlug . "_" . time() . "." . $request->image->getClientOriginalExtension();
                // Organiza fotos por empresa/usuario para não virar bagunça
                $data['image'] = $request->image->storeAs("usuarios/empresa_{$empresaId}", $fileName, 'public');
            }

            User::create($data);

            return redirect()->route('users.index')->with('success', 'Vendedor cadastrado com sucesso!');

        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->validator->errors()->first())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao cadastrar: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $empresaId = Auth::user()->empresa_id ?? Auth::id();
        
        // Garante que o Admin só edite alguém da própria equipe
        $user = User::where('empresa_id', $empresaId)->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'telefone' => 'required',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'telefone', 'nivel_acesso', 'status']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Dados do usuário atualizados!');
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