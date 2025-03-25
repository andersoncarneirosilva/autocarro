<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais


Broadcast::channel('chat', function () {
    \Log::info('Tentativa de inscrição no canal "chat"');
    return true;  // Para permitir inscrição sem autenticação
});



Broadcast::channel('private-chat.{chatId}', function ($user, $chatId) {
    return $user->canAccessChat($chatId); // Exemplo de verificação personalizada
});

