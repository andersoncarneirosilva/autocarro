<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paymentUpdated(Request $request)
    {
        // Verificar a assinatura secreta
        $secret = 'e43ce5c0e39755009f7c04f83627ba0040a9bc03c13f60ba15599a343d0e2725';
        $signature = $request->header('X-MercadoPago-Signature');

        if ($signature !== $secret) {
            Log::error('Assinatura inválida', ['signature' => $signature]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Log::info('Webhook do Mercado Pago', $request->all());

        // Lógica para processar a notificação, por exemplo, atualizar o pagamento no banco de dados
        // Exemplo: Payment::updateStatus($request->input('data.id'), $request->input('data.status'));

        return response()->json(['status' => 'success']);
    }
}
