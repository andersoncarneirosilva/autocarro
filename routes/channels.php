<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais


Broadcast::channel('chat', function () {
    \Log::info('Tentativa de inscrição no canal "chat"');
    return true;  // Para permitir inscrição sem autenticação
});



Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    // Verifique se o usuário tem permissão para acessar este chat
    // Supondo que você tenha um relacionamento entre o usuário e o chat, como User -> chats
    return $user->chats->contains($chatId);
});
