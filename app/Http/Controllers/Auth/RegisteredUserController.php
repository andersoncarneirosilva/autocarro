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
        // 1. Limpa CPF e WhatsApp (Remove máscaras para salvar apenas números)
        $request->merge([
            'cpf'      => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
            'whatsapp' => $request->whatsapp ? preg_replace('/\D/', '', $request->whatsapp) : null,
        ]);

        // 2. Pool de frases para duplicidade (Padrão Alcecar)
        $frasesDuplicado = [
            'Epa! Este CPF já possui um cadastro ativo no Alcecar.',
            'Opa, cadastro duplicado! Este CPF já está na nossa garagem.',
            'Parece que você já tem uma conta! Este CPF já está registrado.'
        ];
        $mensagemDuplicado = $frasesDuplicado[array_rand($frasesDuplicado)];

        // 3. Validação baseada na tabela 'users'
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
            // 4. Criação simplificada na tabela única
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'cpf'          => $request->cpf,
                'telefone'     => $request->whatsapp,
                'nivel_acesso' => 'Particular',
                'status'       => 'Ativo',
                'password'     => Hash::make($request->password),
            ]);

            event(new Registered($user));
            Auth::login($user);

            // Redireciona para a home ou dashboard após o login automático
            // Redireciona com a mensagem de sucesso que o SweetAlert vai capturar
return redirect()->route('dashboard.index')->with('success', 'Bem-vindo ao Alcecar! Seu cadastro foi realizado com sucesso.');

        } catch (\Exception $e) {
            \Log::error("Erro no cadastro Alcecar: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao processar seu cadastro.']);
        }
    }
}