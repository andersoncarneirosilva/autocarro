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
    // 1. Limpa CPF e CNPJ antes de qualquer coisa (apenas números)
    $request->merge([
        'cpf' => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
        'cnpj' => $request->cnpj ? preg_replace('/\D/', '', $request->cnpj) : null,
    ]);

    // 2. Identifica o tipo de conta
    $isRevenda = $request->filled('cnpj') || $request->account_type === 'dealer';

    // 3. Pool de frases aleatórias para documento duplicado
    $frasesDuplicado = [
        'Epa! Este documento já possui um cadastro ativo no Alcecar.',
        'Opa, cadastro duplicado! Este CPF/CNPJ já está na nossa garagem.',
        'Parece que você já tem uma conta! Este documento já está registrado.',
        'Este documento já está sendo utilizado por outro usuário.'
    ];
    $mensagemDuplicado = $frasesDuplicado[array_rand($frasesDuplicado)];

    // 4. Regras de Validação
    $rules = [
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'whatsapp' => ['required', 'string'],
    ];

    if ($isRevenda) {
        $rules['cnpj'] = ['required', 'string', 'unique:users,CPF']; // CNPJ tbm valida na coluna CPF de users
    } else {
        $rules['cpf']  = ['required', 'string', 'unique:users,CPF'];
    }

    $messages = [
        'email.unique'  => 'Este e-mail já está cadastrado. Tente recuperar sua senha.',
        'cpf.unique'    => $mensagemDuplicado,
        'cnpj.unique'   => $mensagemDuplicado,
        'cpf.required'  => 'O campo CPF é obrigatório para usuários particulares.',
        'cnpj.required' => 'O campo CNPJ é obrigatório para revendas.',
    ];

    $request->validate($rules, $messages);

    try {
        return DB::transaction(function () use ($request, $isRevenda) {
            
            // 5. Criar o Usuário Principal
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                'CPF'          => $isRevenda ? $request->cnpj : $request->cpf, 
                'password'     => Hash::make($request->password),
                'nivel_acesso' => $isRevenda ? 'Revenda' : 'Usuário',
                'telefone'     => $request->whatsapp,
                'perfil'       => $isRevenda ? 'Lojista' : 'Cliente',
                'plano'        => 'Basic',
                'status'       => 'Ativo',
                'credito'      => 10,
                'size_folder'  => 50,
            ]);

            // 6. Se for revenda, salvar com user_id na tabela de revendas
            if ($isRevenda) {
                DB::table('revendas')->insert([
                    'user_id'    => $user->id, // Vínculo correto (Relacionamento 1:1)
                    'nome'       => $request->name,
                    'CPNJ'       => $request->cnpj, 
                    'fones'      => json_encode(['whatsapp' => $request->whatsapp]),
                    'rua'        => $request->rua ?? '',
                    'numero'     => $request->numero ?? '',
                    'bairro'     => $request->bairro ?? '',
                    'cidade'     => $request->cidade ?? '',
                    'estado'     => $request->estado ?? '',
                    'cep'        => $request->cep ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            event(new Registered($user));
            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
        });
    } catch (\Exception $e) {
        \Log::error("Erro no cadastro Alcecar: " . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['error' => 'Não foi possível concluir o cadastro. Erro: ' . $e->getMessage()]);
    }
}
}