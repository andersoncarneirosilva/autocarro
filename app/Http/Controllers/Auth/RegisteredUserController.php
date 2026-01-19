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
    // 1. Limpa CPF e CNPJ antes de qualquer coisa (Remove tudo que não for número)
    $request->merge([
        'cpf' => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
        'cnpj' => $request->cnpj ? preg_replace('/\D/', '', $request->cnpj) : null,
    ]);
    
    // 1. Identifica o tipo de conta (Revenda se houver CNPJ ou se o account_type for dealer)
    $isRevenda = $request->filled('cnpj') || $request->account_type === 'dealer';

    // 2. Regras de Validação Personalizadas
    $rules = [
        'name'     => ['required', 'string', 'max:255'],
        'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'whatsapp' => ['required', 'string'],
    ];

    // Mensagens de erro em português para o Alcecar
    $messages = [
        'email.unique' => 'Este e-mail já está cadastrado em nosso sistema.',
        'cpf.unique'   => 'Este CPF já está sendo utilizado.',
        'cnpj.required' => 'O campo CNPJ é obrigatório para revendas.',
        'cpf.required'  => 'O campo CPF é obrigatório para usuários particulares.',
    ];

    if ($isRevenda) {
        $rules['cnpj'] = ['required', 'string'];
    } else {
        $rules['cpf']  = ['required', 'string', 'unique:users,CPF'];
    }

    $request->validate($rules, $messages);

    try {
        return DB::transaction(function () use ($request, $isRevenda) {
            
            // Criar o Usuário Principal
            $user = User::create([
                'name'         => $request->name,
                'email'        => $request->email,
                // Salvamos o documento identificador na coluna CPF (seja CPF ou CNPJ)
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

            // Se for revenda, salvar dados complementares na tabela de revendas
            if ($isRevenda) {
                DB::table('revendas')->insert([
                    'nome'       => $request->name,
                    'CPNJ'       => $request->cnpj, // Atenção: Verifique se no banco é CPNJ ou CNPJ
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
        // Log do erro para o desenvolvedor (opcional)
        \Log::error("Erro ao cadastrar no Alcecar: " . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['error' => 'Não foi possível concluir o cadastro. Verifique os dados e tente novamente.']);
    }
}
}