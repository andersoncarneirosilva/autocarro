<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
class ChatController extends Controller
{
    //
    public function index()
{
    // Pegando as mensagens ordenadas do mais antigo para o mais recente
    $messages = Message::orderBy('created_at', 'asc')->get();
    //dd($messages);
    return view('chat.index', compact('messages'));
}

}
