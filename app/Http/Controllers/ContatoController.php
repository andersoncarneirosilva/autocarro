<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoMail;

class ContatoController extends Controller
{
    public function enviarEmail(Request $request)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email',
        'mensagem' => 'required|string',
    ]);

    // Captura os dados do formulário
    $dados = [
        'nome' => $request->input('nome'),
        'email' => $request->input('email'),
        'mensagem' => $request->input('mensagem'),
    ];
    //dd($dados);
    // Enviar e-mail
    Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContatoMail($dados));
    alert()->success('E-mail enviado com sucesso!');
    return redirect('/');
}
}
