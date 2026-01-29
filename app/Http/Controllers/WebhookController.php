<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paymentUpdated(Request $request)
    {
        // Verificar a assinatura secreta
        //dd($request);
        $secret = '3d02871d3906a49505606e52310ee70618ff1c666a3b22b25fdfd63ecbb172a3';
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
