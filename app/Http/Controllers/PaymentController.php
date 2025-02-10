<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use MercadoPago;

class PaymentController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());

        // Verifica se o evento é de atualização de pagamento
        if ($request->type === 'payment' && $request->action === 'payment.updated') {
            $paymentId = $request->data['id'];

            // Busca os detalhes do pagamento no Mercado Pago
            $payment = $this->getPaymentDetails($paymentId);

            if ($payment) {
                // Atualiza o status do pagamento no banco de dados
                $this->updatePaymentStatus($payment);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function getPaymentDetails($paymentId)
    {
        MercadoPago\SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));

        try {
            return MercadoPago\Payment::find_by_id($paymentId);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar pagamento: ' . $e->getMessage());
            return null;
        }
    }

    private function updatePaymentStatus($payment)
    {
        $order = \App\Models\Order::where('payment_id', $payment->id)->first();

        if ($order) {
            $order->status = $payment->status; // Ex: approved, pending, rejected
            $order->save();

            Log::info("Pedido {$order->id} atualizado para {$payment->status}");
        }
    }
}
