<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomResetPasswordMail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('login.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'O e-mail não foi encontrado.']);
    }

    // Gerar o token
    $token = Password::createToken($user);

    // Criar a URL de redefinição de senha
    $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
    
    // Enviar o e-mail personalizado
    Mail::to($user->email)->send(new CustomResetPasswordMail($resetUrl));

    // 🔹 Redirecionar para a página `confirm-email`
    return redirect()->route('confirm.email', ['email' => $request->email]);
}
}
