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


// LOGIN APP
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $token = $user->createToken('app-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
});