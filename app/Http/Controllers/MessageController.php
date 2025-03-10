<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use Log;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        // Validação da entrada
        $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        // Criando a mensagem
        $message = Message::create([
            'content' => $request->content,
            'user_id' => $request->user_id,
        ]);

        // Logando a ação
        Log::info('Disparando o evento NewMessage', ['message' => $message->content]);

        // Disparando o evento
        broadcast(new NewMessage($message));

        return response()->json(['message' => 'Mensagem enviada com sucesso']);
    }
}
