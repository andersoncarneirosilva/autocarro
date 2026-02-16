<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use App\Models\WhatsappInstance;
use App\Services\SetupNovoUsuario;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
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
    // 1. Limpeza dos dados (Removendo pontuação)
    $documentoLimpo = preg_replace('/\D/', '', $request->documento);
    $whatsappLimpo = preg_replace('/\D/', '', $request->whatsapp);

    $request->merge([
        'documento' => $documentoLimpo,
        'whatsapp'  => $whatsappLimpo,
    ]);

    // 2. Validação com Mensagens Customizadas
    $rules = [
        'nome_responsavel' => ['required', 'string', 'max:255'],
        'razao_social'     => ['required', 'string', 'max:255'],
        'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'whatsapp'         => ['required', 'string', 'min:10'],
        'password'         => ['required', 'confirmed', Rules\Password::defaults()],
    ];

    // Regra dinâmica para CPF ou CNPJ
    if ($request->tipo_doc == 'cpf') {
        $rules['documento'] = ['required', 'string', 'unique:users,cpf'];
    } else {
        $rules['documento'] = ['required', 'string', 'unique:empresas,cnpj'];
    }

    // Mensagens de erro específicas
    $messages = [
        'email.unique'     => 'Este endereço de e-mail já está sendo utilizado.',
        'documento.unique' => $request->tipo_doc == 'cpf' ? 'Este CPF já está cadastrado.' : 'Este CNPJ já está cadastrado.',
        'whatsapp.min'     => 'O número de WhatsApp é inválido.',
    ];

    $request->validate($rules, $messages);

    try {
        $user = DB::transaction(function () use ($request) {
            
            // Cria a Empresa
            $empresa = Empresa::create([
                'nome_responsavel'  => $request->nome_responsavel,
                'razao_social'      => $request->razao_social,
                'nome_fantasia'     => $request->razao_social,
                'cnpj'              => $request->tipo_doc == 'cnpj' ? $request->documento : null,
                'slug'              => Str::slug($request->razao_social),
                'email_corporativo' => $request->email,
                'whatsapp'          => $request->whatsapp,
                'status'            => true,
            ]);

            // Cria o Usuário Administrador
            $user = User::create([
                'name'         => $request->nome_responsavel,
                'email'        => $request->email,
                'cpf'          => $request->tipo_doc == 'cpf' ? $request->documento : null,
                'telefone'     => $request->whatsapp,
                'nivel_acesso' => 'Administrador',
                'status'       => 'Ativo',
                'plano'        => 'Teste',
                'empresa_id'   => $empresa->id,
                'password'     => Hash::make($request->password),
            ]);

            SetupNovoUsuario::criarDadosIniciais($empresa->id);

            return $user;
        });

        event(new Registered($user));
        Auth::login($user);

        return redirect()->intended(route('dashboard.index'))
            ->with('success', 'Bem-vindo ao Agenda Rosa!');

    } catch (\Exception $e) {
        \Log::error("Erro no cadastro: " . $e->getMessage());

        return back()
            ->withInput()
            ->withErrors(['error' => 'Ocorreu um erro ao salvar os dados. Verifique se as informações estão corretas.']);
    }
}

}