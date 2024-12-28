<?php

namespace App\Http\Controllers\Auth;
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
    public function store(LoginRequest $request): RedirectResponse
    {
        // Tentar autenticar o usuário com o guard 'web' ou o guard do tenant
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            // Regenerar a sessão para segurança
            $request->session()->regenerate();

            // Redirecionar para a página inicial após o login bem-sucedido
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Se a autenticação falhar, redirecionar com erros
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

        return redirect('/login');
    }
}
