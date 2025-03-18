<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais

// Canal privado para o usuário (exemplo: "chat.{userId}")
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});


Route::post('/broadcasting/auth', function (Request $request) {
    Log::info('Recebendo autenticação WebSocket', [
        'user_id' => auth()->id(),
        'socket_id' => $request->socket_id
    ]);

    return response()->json(['message' => 'Autenticado']);
});


// Canal público para todos os usuários (exemplo: "events")
Broadcast::channel('events', function ($user) {
    return true;  // Lógica de autorização (por exemplo, pode ser todos os usuários autenticados)
});

// Exemplo de canal para um evento específico (exemplo: "chat.{chatId}")
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Aqui você pode adicionar lógica para autorizar o usuário a participar do canal
    // Exemplo: se o usuário é participante do chat, ele pode ouvir o canal
    return $user->chats->contains($chatId);
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // A autenticação deve ser baseada no ID do usuário e não permitir acesso sem uma verificação válida
    return (int) $user->id === (int) $id;
});

