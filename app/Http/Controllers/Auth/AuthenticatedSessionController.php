<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('login.index');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
    //         $request->session()->regenerate();

    //         return redirect()->intended(RouteServiceProvider::HOME);
    //     }

    //     return back()->withErrors([
    //         'email' => 'As credenciais fornecidas são incorretas.',
    //     ]);
    // }
    public function store(LoginRequest $request): RedirectResponse
{
    // 1. Pega o tipo de conta selecionado no formulário (user ou dealer)
    $accountTypeSelected = $request->input('account_type');

    // 2. Tenta a autenticação básica
    if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
        
        $user = Auth::user();

        // 3. Verificação de Status (Segurança extra para o Alcecar)
        if ($user->status !== 'Ativo') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Sua conta está inativa. Entre em contato com o suporte.',
            ]);
        }

        // 4. Validação do Tipo de Conta (Garante que o login condiz com o perfil)
        $isDealerSelection = ($accountTypeSelected === 'dealer' && $user->nivel_acesso !== 'Revenda');
        $isUserSelection = ($accountTypeSelected === 'user' && $user->nivel_acesso !== 'Particular');

        if ($isDealerSelection || $isUserSelection) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Esta conta não possui acesso como ' . ($accountTypeSelected === 'dealer' ? 'Revenda.' : 'Pessoa Particular.'),
            ]);
        }

        $request->session()->regenerate();

        // 5. Redirecionamentos baseados no Layout/Pasta
        
        // Particular vai para a nova estrutura de painel
        if ($user->nivel_acesso === 'Particular') {
            return redirect()->route('particulares.index');
        }

        // Revenda vai para o painel padrão de anúncios
        if ($user->nivel_acesso === 'Revenda') {
            return redirect()->route('anuncios.index');
        }

        // Caso exista um Admin ou outro nível, vai para o Home padrão
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    return back()->withErrors([
        'email' => 'As credenciais fornecidas são incorretas.',
    ]);
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Realizar o logout do usuário
        Auth::guard('web')->logout();

        // Invalidar a sessão e regenerar o token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
