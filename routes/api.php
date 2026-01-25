<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;
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

Route::get('/users/{id}', function ($id) {
    return User::find($id);
});

Route::get('/chat/last-message', [ChatController::class, 'lastMessage']);
Route::post('/chat/get-chat', [ChatController::class, 'getChat'])->middleware('auth');

Route::post('/chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');


// Rotas para buscar dados dinamicamente
Route::get('/api/modelos/{marca_id}', function($marca_id) {
    return App\Models\Modelo::where('marca_id', $marca_id)->get();
});

Route::get('/api/versoes/{modelo_id}', function($modelo_id) {
    return App\Models\Versao::where('modelo_id', $modelo_id)->get();
});