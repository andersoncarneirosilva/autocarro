<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
//Route::post('/payment-updated', [PaymentController::class, 'webhook'])->name('payment.updated');
Route::post('/create-preference', [PaymentController::class, 'createPreference']);
Route::post('/payment-updated', [PaymentController::class, 'processPayment']);

Route::post('/payment-updated', [PaymentController::class, 'handleWebhook']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
