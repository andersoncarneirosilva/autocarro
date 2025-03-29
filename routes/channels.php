<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['auth:sanctum']]);


Broadcast::channel('chat', function ($user) {
    \Log::info('Tentativa de inscrição no canal "chat"', ['user' => $user]);
    return $user !== null;  // Permite inscrição apenas para usuários autenticados
});
