<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Api\VeiculoController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\GastoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Api\ApiDashController;

Route::middleware('auth:sanctum')->group(function () {

// Rota para pegar TUDO
Route::put('gastos/{id}/status', [GastoController::class, 'updateStatus']);
Route::get('/gastos', [GastoController::class, 'index']);

Route::put('veiculos/{id}/update-info-basica', [VeiculoController::class, 'updateInfoBasica']);
Route::put('veiculos/{id}/update-registro', [VeiculoController::class, 'updateRegistro']);
Route::put('veiculos/{id}/update-precos', [VeiculoController::class, 'updatePrecos']);
Route::put('veiculos/{id}/restore', [VeiculoController::class, 'restore']);
Route::put('veiculos/{id}/archive', [VeiculoController::class, 'archive']);
Route::delete('veiculos/{id}', [VeiculoController::class, 'destroy']);

    Route::get('veiculos/manutencao', [VeiculoController::class, 'getManutencao']);
    Route::get('/dashboard', [ApiDashController::class, 'getDashboardData']);
    Route::get('veiculos/arquivados', [VeiculoController::class, 'arquivados']);
    Route::get('veiculos/vendidos', [VeiculoController::class, 'vendidos']);
    // Rota para listar todos os veículos (GET /api/veiculos)
    Route::get('/veiculos', [VeiculoController::class, 'index']);
    
    // Opcional: Rota para ver detalhes de um veículo específico (GET /api/veiculos/2)
    Route::get('/veiculos/{id}', [VeiculoController::class, 'show']);
Route::post('/veiculos/manual', [VeiculoController::class, 'storeManual']);
    Route::post('/veiculos/cadastro-rapido', [VeiculoController::class, 'cadastroRapido']);
    // routes/api.php
Route::put('veiculos/{id}/update-registro', [VeiculoController::class, 'updateRegistro']);
});

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

