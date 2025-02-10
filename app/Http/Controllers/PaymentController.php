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

    if (!isset($request->type) || !isset($request->action)) {
        Log::error('Erro: Requisição inválida', $request->all());
        return response()->json(['error' => 'Invalid request'], 400);
    }

    if ($request->type === 'payment' && $request->action === 'payment.updated') {
        $paymentId = $request->data['id'] ?? null;

        if (!$paymentId) {
            Log::error('Erro: ID do pagamento ausente', $request->all());
            return response()->json(['error' => 'Payment ID missing'], 400);
        }

        // Buscar detalhes do pagamento no Mercado Pago
        $payment = $this->getPaymentDetails($paymentId);

        if ($payment) {
            $this->updatePaymentStatus($payment);

            return response()->json([
                'status' => 'success',
                'payment_token' => $payment['id'], // Retorna o ID do pagamento
                'status_detail' => $payment['status'] // Retorna o status do pagamento
            ]);
        }
    }

    return response()->json(['error' => 'Payment not found'], 404);
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

    public function createPreference(Request $request)
    {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN'); // Definir no .env
        $url = "https://api.mercadopago.com/checkout/preferences";

        $response = Http::withToken($accessToken)->post($url, [
            "items" => [
                [
                    "title" => "Produto Teste",
                    "quantity" => 1,
                    "unit_price" => $request->amount / 100
                ]
            ],
            "payer" => [
                "email" => $request->payer_email
            ],
            "back_urls" => [
                "success" => url('/pagamento-sucesso'),
                "failure" => url('/pagamento-falha'),
                "pending" => url('/pagamento-pendente')
            ],
            "auto_return" => "approved"
        ]);

        if ($response->failed()) {
            return response()->json(["error" => "Erro ao criar a preferência"], 500);
        }

        return response()->json(["preferenceId" => $response->json()["id"]]);
    }

}
