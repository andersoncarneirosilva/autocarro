<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais

// Canal privado para o usuário (exemplo: "chat.{userId}")
Broadcast::channel('chat.{userId}', function ($user, $userId) {
    Log::info('Autenticando canal para o usuário:', [
        'user_id' => $user->id ?? 'não autenticado',
        'canal' => $userId,
        'socket_id' => request()->socket_id ?? 'não definido'
    ]);

    // Certifique-se de que o usuário tem permissão para acessar o canal
    $authenticated = (int) $user->id === (int) $userId;

    if ($authenticated) {
        Log::info('Usuário autenticado no canal', ['user_id' => $user->id]);
    } else {
        Log::error('Usuário não autorizado a acessar o canal', ['user_id' => $user->id]);
    }

    return $authenticated;
});


Route::post('/broadcasting/auth', function (Request $request) {
    Log::info('Autenticação de WebSocket chamada.', [
        'socket_id' => $request->socket_id,
        'user_id' => auth()->id(),
    ]);
    
    if (auth()->check()) {
        Log::info('Usuário autenticado:', ['user_id' => auth()->id()]);
    } else {
        Log::error('Usuário não autenticado.');
    }

    return response()->json(['message' => 'Autenticado']);
});


Broadcast::channel('chat', function ($user) {
    return $user !== null;
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

