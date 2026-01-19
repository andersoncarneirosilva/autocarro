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
    // 1. Tenta autenticar
    if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
        
        $request->session()->regenerate();

        // 2. Obtém o usuário logado
        $user = Auth::user();

        // 3. Verifica o nível de acesso
        // Importante: Verifique se no banco está exatamente "Usuário" (com acento)
        if ($user->nivel_acesso === 'Usuário') {
            return redirect()->route('anuncios.index');
        }
        if ($user->nivel_acesso === 'Revenda') {
            return redirect()->route('anuncios.index');
        }

        // 4. Se não for 'Usuário', vai para o dashboard padrão
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
