<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes(['middleware' => ['auth:sanctum']]);



// Broadcast::channel('chat', function () {
//     \Log::info('Tentativa de inscrição no canal "chat"');
//     return true;  // Para permitir inscrição sem autenticação
// });



// Broadcast::channel('private-chat.{chatId}', function ($user, $chatId) {
//     return true; // Permitir acesso a todos os usuários para teste
// });

// Route::post('/broadcasting/auth', function (Illuminate\Http\Request $request) {
//     return Broadcast::auth($request);
// })->middleware('auth');  // Verifique se o middleware 'auth' está permitindo o acesso
