<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['auth:sanctum']]);



Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    Log::info("🔐 Autenticando usuário {$user->id} no chat {$chatId}");

    // Verifica se o usuário está autenticado
    if (!$user) {
        Log::warning("🚫 Usuário não autenticado tentou acessar o chat {$chatId}");
        return false;
    }

    $temAcesso = \App\Models\User::where('id', $user->id)->exists();
    Log::info("✅ Usuário tem acesso ao chat {$chatId}? " . ($temAcesso ? 'Sim' : 'Não'));

    return $temAcesso ? ['id' => $user->id, 'name' => $user->name] : false;
});