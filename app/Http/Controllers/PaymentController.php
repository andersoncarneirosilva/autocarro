<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Log;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function index(Request $request){

        $userId = Auth::id();

        return view('pagamentos.index', compact(['userId']));
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());

        // Verifica se é um evento de atualização de pagamento
        if ($request->type === 'payment' && $request->action === 'payment.updated') {
            $paymentId = $request->data['id'];

            // Buscar detalhes do pagamento via API do Mercado Pago
            $payment = $this->getPaymentDetails($paymentId);

            if ($payment) {
                // Atualizar status no banco de dados
                $this->updatePaymentStatus($payment);
            }
        }

        return response()->json(['status' => 'success']);
    }

    private function getPaymentDetails($paymentId)
    {
        $accessToken = env('MP_ACCESS_TOKEN');
        $url = "https://api.mercadopago.com/v1/payments/{$paymentId}";

        $response = Http::withToken($accessToken)->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        Log::error('Erro ao buscar pagamento: ' . $response->body());
        return null;
    }

    private function updatePaymentStatus($payment)
    {
        $order = Order::where('payment_id', $payment['id'])->first();

        if ($order) {
            $order->status = $payment['status']; // Ex: approved, pending, rejected
            $order->save();

            Log::info("Pedido {$order->id} atualizado para {$payment['status']}");
        }
    }

}
