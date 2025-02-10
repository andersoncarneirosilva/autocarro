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
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
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

    public function processPayment(Request $request)
{
    $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN'); // Definir no .env
    $url = "https://api.mercadopago.com/v1/payments";

    // Capturar os dados da requisição
    $paymentData = [
        "transaction_amount" => $request->transaction_amount,
        "token" => $request->token,
        "description" => "Compra em Proconline",
        "installments" => $request->installments,
        "payment_method_id" => $request->payment_method_id,
        //"issuer_id" => $request->issuer_id,
        "payer" => [
            "email" => $request->payer['email'],
            "identification" => [
                "type" => $request->payer['identification']['type'],
                "number" => $request->payer['identification']['number']
            ]
        ],
        //"binary_mode" => true
    ];

    // Enviar requisição para o Mercado Pago
    $response = Http::withToken($accessToken)->post($url, $paymentData);

    if ($response->failed()) {
        Log::error('Erro ao processar pagamento controller:', [
            'status_code' => $response->status(),
            'response_body' => $response->body()
        ]);
        
        return response()->json([
            'error' => 'Erro ao processar pagamento controller',
            'details' => $response->json()
        ], 400);
    }
    

    return response()->json([
        'status' => 'success',
        'payment_id' => $response->json()['id'],
        'payment_status' => $response->json()['status'], // Exemplo: "approved", "pending", "rejected"
        'status_detail' => $response->json()['status_detail'] // Exemplo: "accredited"
    ]);
}


}