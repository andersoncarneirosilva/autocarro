<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('login.index');  // A view onde o formulário de login está
    }

    // Processa o login
    public function login(Request $request)
    {
        // Validação dos dados
        // dd($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Se a validação falhar, redireciona com os erros
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)  // Passa os erros para a view
                ->withInput();             // Mantém os dados do formulário
        }

        // Se a validação passar, tenta fazer o login
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/home');  // Redireciona após login bem-sucedido
        }

        // Se o login falhar, exibe erro de credenciais
        return redirect()->route('login')
            ->withErrors(['email' => 'Credenciais inválidas.']);  // Exibe mensagem de erro
    }

    // Processa o logout
    public function logout(Request $request)
    {
        Auth::logout(); // Faz o logout do usuário
        $request->session()->invalidate(); // Invalida a sessão
        $request->session()->regenerateToken(); // Regenera o token CSRF para segurança

        return redirect()->route('login'); // Redireciona de volta para a página de login
    }
}
