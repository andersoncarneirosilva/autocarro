<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['auth:sanctum']]);



Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    Log::info("Autenticando usuário {$user->id} no chat {$chatId}");

    $temAcesso = \App\Models\User::where('id', $user->id)
                                     ->exists();

    Log::info("Usuário tem acesso? " . ($temAcesso ? 'Sim' : 'Não'));

    return $temAcesso;
});
