<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais


Broadcast::channel('chat', function () {
    \Log::info('Tentativa de inscrição no canal "chat"');
    return true;  // Para permitir inscrição sem autenticação
});



Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Aqui você pode verificar se o usuário faz parte do chat
    $chat = Chat::find($chatId);
    return $chat && $chat->users->contains($user);
});
