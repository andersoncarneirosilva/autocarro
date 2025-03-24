<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(); // Isso cria as rotas necessárias para autenticação de canais


Broadcast::channel('chat', function ($user) {
    \Log::info('Canal "chat" conectado:', ['user' => $user]);
    return $user !== null;
});


