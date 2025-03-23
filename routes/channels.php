<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais

// Canal privado para o usuário (exemplo: "chat.{userId}")
// Broadcast::channel('chat.{userId}', function ($user, $userId) {
//     Log::info('Autenticando canal:', [
//         'user_id' => $user->id ?? 'não autenticado',
//         'canal' => $userId,
//         'socket_id' => request()->socket_id ?? 'não definido'
//     ]);

//     // Retorna true somente se o ID do usuário autenticado for igual ao ID do canal
//     return (int) $user->id === (int) $userId;
// });

// Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
//     return $user->chats()->where('id', $chatId)->exists();
// });

Broadcast::channel('chat', function ($user) {
    // Verifique se o usuário tem permissão para acessar o canal privado
    return $user !== null;  // ou qualquer outra lógica de permissão
});
