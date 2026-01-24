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
use Illuminate\Support\Str; 


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('login.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Limpa CPF, CNPJ e WhatsApp
        $request->merge([
            'cpf'      => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
            'cnpj'     => $request->cnpj ? preg_replace('/\D/', '', $request->cnpj) : null,
            'whatsapp' => $request->whatsapp ? preg_replace('/\D/', '', $request->whatsapp) : null,
        ]);

        // 2. Identifica o tipo de conta
        $isRevenda = $request->filled('cnpj') || $request->account_type === 'dealer';

        // 3. Pool de frases
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
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
            'whatsapp' => ['required', 'string', 'min:10'],
        ];

        if ($isRevenda) {
            $rules['cnpj'] = ['required', 'string', 'unique:users,cpf']; 
        } else {
            $rules['cpf']  = ['required', 'string', 'unique:users,cpf'];
        }

        $messages = [
            'email.unique'  => 'Este e-mail já está cadastrado.',
            'cpf.unique'    => $mensagemDuplicado,
            'cnpj.unique'   => $mensagemDuplicado,
            'whatsapp.min'  => 'O número do WhatsApp parece incompleto.',
        ];

        $request->validate($rules, $messages);

        try {
            return DB::transaction(function () use ($request, $isRevenda) {
                
                $documento = $isRevenda ? $request->cnpj : $request->cpf;

                // 5. Criar o Usuário Principal
                $user = User::create([
                    'name'         => $request->name,
                    'email'        => $request->email,
                    'cpf'          => $documento,
                    'password'     => Hash::make($request->password),
                    'nivel_acesso' => $isRevenda ? 'Revenda' : 'Particular',
                    'telefone'     => $request->whatsapp,
                    'cidade'     => $request->cidade ?? '',
                    'estado'     => $request->estado ?? '',
                    'plano'        => 'Basic',
                    'status'       => 'Ativo',
                    'credito'      => 10,
                    'size_folder'  => 50,
                ]);

                // 6. Preparar dados comuns para as tabelas auxiliares
                $fonesJson = json_encode(['whatsapp' => $request->whatsapp]);
                $commonData = [
                    'user_id'    => $user->id,
                    'nome'       => $request->name,
                    'fones'      => $fonesJson,
                    'rua'        => $request->rua ?? '',
                    'numero'     => $request->numero ?? '',
                    'bairro'     => $request->bairro ?? '',
                    'cidade'     => $request->cidade ?? '',
                    'estado'     => $request->estado ?? '',
                    'cep'        => $request->cep ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($isRevenda) {
                    // Lógica de Slug exclusiva para Revendas
                    $slugBase = Str::slug($request->name);
                    $slug = $slugBase;
                    $i = 1;
                    while (DB::table('revendas')->where('slug', $slug)->exists()) {
                        $slug = $slugBase . '-' . $i;
                        $i++;
                    }

                    DB::table('revendas')->insert(array_merge($commonData, [
                        'cnpj' => $request->cnpj,
                        'slug' => $slug
                    ]));
                } else {
                    // Inserção na tabela de Particulares
                    DB::table('particulares')->insert(array_merge($commonData, [
                        'cpf' => $request->cpf // Salvamos o CPF na coluna CNPJ para manter o padrão que você pediu
                    ]));
                }

                event(new Registered($user));
                Auth::login($user);

                // --- AJUSTE DE REDIRECIONAMENTO PÓS-CADASTRO ---
                if ($user->nivel_acesso === 'Particular') {
                    return redirect()->route('particulares.index');
                }

                if ($user->nivel_acesso === 'Revenda') {
                    return redirect()->route('anuncios.index');
                }

                // Fallback caso seja outro nível
                return redirect(RouteServiceProvider::HOME);
            });
        } catch (\Exception $e) {
            \Log::error("Erro no cadastro Alcecar: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Ocorreu um erro ao processar seu cadastro.']);
        }
    }
}