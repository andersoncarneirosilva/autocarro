<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes();



// Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
//     Log::info("Autenticando usuário {$user->id} no chat {$chatId}");

//     $temAcesso = \App\Models\User::where('user_id', $user->id)->get();

//     Log::info("Usuário tem acesso? " . ($temAcesso ? 'Sim' : 'Não'));

//     return $temAcesso;
// });
