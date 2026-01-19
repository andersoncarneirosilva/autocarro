<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Revenda; // Certifique-se de ter este Model criado
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('login.register');
    }

    public function store(Request $request): RedirectResponse
{
    // 1. Validação
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'whatsapp' => ['required', 'string'],
    ]);

    try {
        return DB::transaction(function () use ($request) {
            
            // Determina se é revenda pelo preenchimento do CNPJ
            $isRevenda = $request->filled('cnpj');

            // Criar o Usuário
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nivel_acesso' => $isRevenda ? 'Revenda' : 'Usuário',
                'telefone' => $request->whatsapp,
                'perfil' => $isRevenda ? 'Lojista' : 'Cliente',
            ]);

            // Se for revenda, tenta salvar na tabela de revendas
            if ($isRevenda) {
                DB::table('revendas')->insert([
                    'nome'   => $request->name,
                    'CPNJ'   => $request->cnpj, // Use CNPJ se corrigiu no banco
                    'fones'  => json_encode(['whatsapp' => $request->whatsapp]),
                    'rua'    => $request->rua ?? '',
                    'numero' => $request->numero ?? '',
                    'bairro' => $request->bairro ?? '',
                    'cidade' => $request->cidade ?? '',
                    'estado' => $request->estado ?? '',
                    'cep'    => $request->cep ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            event(new Registered($user));
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        });
    } catch (\Exception $e) {
        // Se algo der errado, volta com o erro para o usuário
        return back()->withInput()->withErrors(['error' => 'Erro ao cadastrar: ' . $e->getMessage()]);
    }
}
}