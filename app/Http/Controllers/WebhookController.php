<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paymentUpdated(Request $request)
    {
        // Log dos dados recebidos
        Log::info('Webhook Mercado Pago recebido:', $request->all());

        // Aqui você pode processar os dados da notificação
        return response()->json(['status' => 'success']);
    }
}