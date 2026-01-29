<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| PAGAMENTOS (Ações iniciadas pelo usuário)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // Criar pagamento PIX
    Route::post('/create-pix-payment', [PaymentController::class, 'createPixPayment']);

    // (se existir)
    Route::post('/create-preference', [PaymentController::class, 'createPreference']);

    // (se existir)
    Route::post('/process-payment', [PaymentController::class, 'processPayment']);
});
/*
|--------------------------------------------------------------------------
| WEBHOOK MERCADO PAGO (Chamado pelo Mercado Pago)
|--------------------------------------------------------------------------
*/
Route::post('/webhook-payment', [WebhookController::class, 'paymentUpdated']);



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
