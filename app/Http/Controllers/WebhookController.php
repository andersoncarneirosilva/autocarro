<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paymentUpdated(Request $request)
    {
        // Log de depuração para verificar os dados recebidos
        Log::info('Notificação de pagamento atualizada:', $request->all());

        // Aqui, você pode processar os dados recebidos da notificação
        // Exemplo: atualizar o status de pagamento do usuário no banco de dados

        return response()->json(['status' => 'success']); // Resposta de sucesso
    }
}