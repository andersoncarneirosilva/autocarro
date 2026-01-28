<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        $user = Auth::user();
        
        // LÓGICA ALCECAR: Se for vendedor, buscamos quem é o administrador dele
        $gestor = null;
        if ($user->empresa_id) {
            $gestor = User::find($user->empresa_id);
        }

        return view('perfil.index', compact('user', 'gestor'));
    }

    public function update(Request $request, $id)
    {
        // 1. Segurança Máxima: O usuário logado só pode editar o PRÓPRIO ID
        if (Auth::id() != $id) {
            return redirect()->route('perfil.index')->with('error', 'Acesso não autorizado!');
        }

        $user = $this->model->findOrFail($id);

        // 2. Validação de dados básicos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // 3. Atualizar Senha
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6',
                'password_confirm' => 'same:password'
            ], [
                'password_confirm.same' => 'As senhas não coincidem!'
            ]);

            $user->password = Hash::make($request->password);
        }

        // 4. Atualizar Imagem (Mantendo a organização por pasta de usuário)
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $userFolder = "usuarios/usuario_{$user->id}";
            $imagePath = $request->file('image')->store($userFolder, 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->route('perfil.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}