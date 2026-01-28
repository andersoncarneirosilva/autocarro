<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerfilController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        return view('perfil.index', ['user' => auth()->user()]);
    }

    public function update(Request $request, $id)
    {
        // 1. Segurança: Garante que o usuário só edite a si próprio
        if (auth()->id() != $id) {
            return redirect()->route('perfil.index')->with('error', 'Acesso não autorizado!');
        }

        $user = $this->model->findOrFail($id);

        // 2. Atualizar Nome
        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        // 3. Atualizar Senha (com validação de confirmação)
        if ($request->filled('password')) {
            if ($request->password !== $request->password_confirm) {
                return redirect()->back()->with('error', 'As senhas não coincidem!');
            }
            
            if (strlen($request->password) < 6) {
                return redirect()->back()->with('error', 'A senha deve ter pelo menos 6 caracteres.');
            }

            $user->password = Hash::make($request->password);
        }

        // 4. Atualizar Imagem na pasta usuarios/{id}
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
            // Deleta a foto anterior se existir para economizar espaço
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Define a pasta baseada no ID do usuário
            $userFolder = "usuarios/usuario_{$user->id}";
            
            // Salva e recupera o caminho
            $imagePath = $request->file('image')->store($userFolder, 'public');

            $user->image = $imagePath;
        }

        $user->save();

        // Retorna com a sessão 'success' que dispara o seu Toast
        return redirect()->route('perfil.index')->with('success', 'Perfil atualizado com sucesso!');
    }
}