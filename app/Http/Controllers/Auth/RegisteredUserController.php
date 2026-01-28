<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('login.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Limpa CPF e WhatsApp
        $request->merge([
            'cpf'      => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
            'whatsapp' => $request->whatsapp ? preg_replace('/\D/', '', $request->whatsapp) : null,
        ]);

        // 2. Pool de frases (Estilo Alcecar)
        $frasesDuplicado = [
            'Epa! Este CPF já possui um cadastro ativo no Alcecar.',
            'Opa, cadastro duplicado! Este CPF já está na nossa garagem.',
            'Parece que você já tem uma conta! Este CPF já está registrado.'
        ];
        $mensagemDuplicado = $frasesDuplicado[array_rand($frasesDuplicado)];

        // 3. Validação
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf'      => ['required', 'string', 'unique:users,cpf'],
            'whatsapp' => ['required', 'string', 'min:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Este e-mail já está cadastrado.',
            'cpf.unique'   => $mensagemDuplicado,
            'whatsapp.min' => 'O número do WhatsApp parece incompleto.',
        ]);

        try {
            // 4. Criação do Usuário
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'cpf'          => $request->cpf,
                'telefone'     => $request->whatsapp,
                'nivel_acesso' => 'Administrador', // Alterado para Administrador (ele manda na empresa dele)
                'status'       => 'Ativo',
                'password'     => Hash::make($request->password),
            ]);

            // LÓGICA ALCECAR: O primeiro cadastro define a si mesmo como a empresa
            // Isso faz com que $user->empresa_id seja igual ao $user->id
            $user->update([
                'empresa_id' => $user->id
            ]);

            event(new Registered($user));
            Auth::login($user);

            return redirect()->route('dashboard.index')
                ->with('success', 'Bem-vindo ao Alcecar! Sua garagem está pronta.');

        } catch (\Exception $e) {
            \Log::error("Erro no cadastro Alcecar: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao processar seu cadastro.']);
        }
    }
}