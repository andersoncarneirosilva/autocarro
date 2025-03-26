<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Rota para criar preferência
Route::post('/create-preference', [PaymentController::class, 'createPreference'])->middleware('auth:sanctum');

// Rota para processar pagamentos
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->middleware('auth:sanctum');

// Rota para criar pagamento PIX, deve ser protegida por autenticação

// Route::middleware('auth:sanctum')->post('/create-pix-payment', [PaymentController::class, 'createPixPayment']);
Route::post('/create-pix-payment', [PaymentController::class, 'createPixPayment']);

// Rota para receber notificações de webhook
Route::post('/webhook-payment', [PaymentController::class, 'handleWebhook']);

// Rota para retornar usuário autenticado (semelhante ao exemplo)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Broadcast::routes(['middleware' => ['auth:sanctum']]);
Route::post('/broadcasting/auth', function (Request $request) {
    Log::info('Recebendo autenticação WebSocket', [
        'user_id' => auth()->id(),
        'socket_id' => $request->socket_id
    ]);

    if (!auth()->check()) {
        Log::error('Usuário não autenticado.');
        return response()->json(['error' => 'Usuário não autenticado'], 403);
    }

    // Responde corretamente para o Pusher
    return Broadcast::auth($request);
});
