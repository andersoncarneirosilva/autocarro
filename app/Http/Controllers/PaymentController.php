<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        return view('pagamentos.index', compact(['userId']));
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook recebido:', $request->all());
    
        if ($request->type === 'payment' && isset($request->data['id'])) {
            $paymentId = $request->data['id'];
    
            // Busca os detalhes do pagamento no Mercado Pago
            $payment = $this->getPaymentDetails($paymentId);
    
            if ($payment) {
                // Atualiza o status do pagamento no banco de dados
                $this->updatePaymentStatus($payment);
            }
        } else {
            Log::warning("Evento Webhook não reconhecido:", $request->all());
        }
    
        return response()->json(['status' => 'success']);
    }

    private function getPaymentDetails($paymentId)
    {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
        $url = "https://api.mercadopago.com/v1/payments/{$paymentId}";

        $retryCount = 0;
        $maxRetries = 3;
        $response = null;

        while ($retryCount < $maxRetries) {
            $response = Http::withToken($accessToken)->get($url);

            if ($response->successful()) {
                return $response->json();
            }

            // Caso a requisição falhe, faz uma nova tentativa
            if ($response->status() == 404) {
                Log::warning("Pagamento não encontrado. Tentando novamente... (Tentativa: " . ($retryCount + 1) . ")");
            }

            $retryCount++;
            sleep(2); // Aguarda 2 segundos antes de tentar novamente
        }

        Log::error('Erro ao buscar pagamento após múltiplas tentativas: ' . $response->body());
        return null;
    }

    private function updatePaymentStatus($payment)
{
    // Verificar se o pagamento foi aprovado
    if ($payment['status'] === 'approved') {
        // Pegar o usuário autenticado
        $userId = Auth::id();
        $user = User::find($userId);

        if ($user) {
            // Adicionar o crédito ao usuário
            $user->credito += $payment['transaction_amount']; // Usando o valor da transação do pagamento
            $user->save();

            Log::info("Crédito de {$payment['transaction_amount']} adicionado ao usuário {$user->id}");
        } else {
            Log::error("Usuário autenticado não encontrado para o pagamento ID {$payment['id']}");
        }
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
                "email" => $request->payer['email']
            ]
        ];

        // Adicionar informações de identificação se não for PIX
        if ($request->payment_method_id !== 'pix' && isset($request->payer['identification'])) {
            $paymentData['payer']['identification'] = [
                'type' => $request->payer['identification']['type'],
                'number' => $request->payer['identification']['number']
            ];
        }

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

    // Método para quando o pagamento for bem-sucedido
    public function paymentSuccess(Request $request)
    {
        // Pode processar dados adicionais do pagamento, se necessário
        return view('pagamentos.sucesso');
    }

    // Método para quando o pagamento falhar
    public function paymentFailure(Request $request)
    {
        // Pode processar dados adicionais sobre a falha do pagamento
        return view('pagamentos.falha');
    }

    // Método para quando o pagamento for pendente
    public function paymentPending(Request $request)
    {
        // Pode processar dados adicionais sobre o status pendente do pagamento
        return view('pagamentos.pendente');
    }
}
