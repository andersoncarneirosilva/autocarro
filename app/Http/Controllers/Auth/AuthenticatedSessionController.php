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
    $accountTypeSelected = $request->input('account_type');

    if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
        
        $user = Auth::user();

        if ($user->status !== 'Ativo') {
            Auth::logout();
            return back()->withErrors(['email' => 'Sua conta está inativa.']);
        }

        // --- AJUSTE PARA ADMINISTRADOR ---
        // Se NÃO for Administrador, aplicamos a trava de tipo de conta
        if ($user->nivel_acesso !== 'Administrador') {
            $isDealerSelection = ($accountTypeSelected === 'dealer' && $user->nivel_acesso !== 'Revenda');
            $isUserSelection = ($accountTypeSelected === 'user' && $user->nivel_acesso !== 'Particular');

            if ($isDealerSelection || $isUserSelection) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Esta conta não possui acesso como ' . ($accountTypeSelected === 'dealer' ? 'Revenda.' : 'Pessoa Particular.'),
                ]);
            }
        }

        $request->session()->regenerate();

        // --- REDIRECIONAMENTOS ---
        
        // 1. Administrador vai para o Dashboard Geral
        if ($user->nivel_acesso === 'Administrador') {
           return redirect()->intended(RouteServiceProvider::HOME);
        }

        // 2. Particular
        if ($user->nivel_acesso === 'Particular') {
            return redirect()->route('particulares.index');
        }

        // 3. Revenda
        if ($user->nivel_acesso === 'Revenda') {
            return redirect()->route('anuncios.index');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    return back()->withErrors(['email' => 'As credenciais fornecidas são incorretas.']);
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
