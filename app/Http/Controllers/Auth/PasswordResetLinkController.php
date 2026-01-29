<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CustomResetPasswordMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

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

    if (! $user) {
        return back()->withErrors(['email' => 'O e-mail não foi encontrado.']);
    }

    try {
        // Gerar o token
        $token = Password::createToken($user);

        // Criar a URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

        // Enviar o e-mail
        // IMPORTANTE: O Zoho exige que o remetente seja identico ao login do SMTP
        Mail::to($user->email)->send(new CustomResetPasswordMail($resetUrl));
        
        \Illuminate\Support\Facades\Log::info("E-mail de recuperação enviado para: " . $user->email);

        return redirect()->route('confirm.email', ['email' => $request->email]);

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Falha ao enviar e-mail: " . $e->getMessage());
        return back()->withErrors(['email' => 'Erro ao enviar e-mail. Tente novamente mais tarde.']);
    }
}
}
