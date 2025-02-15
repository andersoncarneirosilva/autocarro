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
        return view('planos.index', compact(['userId']));
    }

    public function selecionarPlano(Request $request)
    {
        // Recebe os dados do plano e redireciona para a página de pagamento
        return redirect()->route('pagamento.index')->with([
            'plano' => $request->input('plano'),
            'preco' => $request->input('preco')
        ]);
    }

    public function paginaPagamento()
    {
        // Recupera os dados do plano armazenados na sessão
        $plano = session('plano');
        $preco = session('preco');

        if (!$plano || !$preco) {
            return redirect('/')->with('error', 'Por favor, selecione um plano antes de prosseguir.');
        }

        return view('pagamento.index', compact('plano', 'preco'));
    }

    public function handleWebhook(Request $request)
{
    try {
        Log::info('Webhook recebido:', $request->all());

        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        if ($request->type === "payment" && isset($request->data['id'])) {
            $paymentId = $request->data['id'];

            // Buscar detalhes do pagamento
            $paymentData = $this->getPaymentDetails($paymentId, $accessToken);

            if (!$paymentData) {
                Log::warning("Pagamento não encontrado: ID {$paymentId}");
                return response()->json(["message" => "Pagamento não encontrado"], 200);
            }

            Log::info("Resposta do Mercado Pago: " . json_encode($paymentData));

            // Verificar se tem external_reference antes de continuar
            if (!isset($paymentData['external_reference']) || empty($paymentData['external_reference'])) {
                Log::error("Pagamento ID {$paymentData['id']} não contém external_reference.");
                return response()->json(["message" => "Pagamento sem external_reference"], 200);
            }

            // Buscar o usuário com base na external_reference
            $user = User::where('external_reference', $paymentData['external_reference'])->first();

            if (!$user) {
                Log::error("Usuário não encontrado para external_reference {$paymentData['external_reference']}");
                return response()->json(["message" => "Usuário não encontrado"], 404);
            }

            // Chama a função para atualizar o status do pagamento
            Log::info("Chamando updatePaymentStatus para pagamento ID {$paymentData['id']}");
            $this->updatePaymentStatus($paymentData, $user);

            return response()->json(["message" => "Webhook processado com sucesso"]);
        }

        Log::warning("Evento Webhook não reconhecido:", $request->all());
        return response()->json(["message" => "Nenhuma ação necessária"], 200);

    } catch (\Exception $e) {
        Log::error("Erro no webhook: " . $e->getMessage());
        return response()->json(["error" => "Erro interno"], 500);
    }
}

    
    public function createPixPayment(Request $request)
    {
        try {
            $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
    
            if (!$accessToken) {
                Log::error("Mercado Pago: Access Token não encontrado.");
                return response()->json(["error" => "Erro na configuração do Mercado Pago"], 500);
            }
    
            $url = "https://api.mercadopago.com/v1/payments";
    
            $response = Http::withToken($accessToken)->post($url, [
                "transaction_amount" => floatval($request->amount), 
                "payment_method_id" => "pix", 
                "payer" => [
                    "email" => $request->payer_email
                ],
                "external_reference" => auth()->id() ?? "pedido_" . time(), // Defina uma referência única
            ]);
    
            if ($response->failed()) {
                Log::error("Erro ao criar pagamento PIX: " . $response->body());
                return response()->json(["error" => "Erro ao criar pagamento PIX", "details" => $response->json()], 500);
            }
    
            $paymentData = $response->json();
    
            return response()->json([
                "qr_code" => $paymentData["point_of_interaction"]["transaction_data"]["qr_code"],
                "qr_code_base64" => $paymentData["point_of_interaction"]["transaction_data"]["qr_code_base64"],
                "ticket_url" => $paymentData["point_of_interaction"]["transaction_data"]["ticket_url"]
            ]);
    
        } catch (\Exception $e) {
            Log::error("Exceção ao criar pagamento PIX: " . $e->getMessage());
            return response()->json(["error" => "Erro interno ao processar o pagamento"], 500);
        }
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
    Log::info("Entrou na função updatePaymentStatus para pagamento ID {$payment['id']} com status {$payment['status']}");

    if (!isset($payment['status'])) {
        Log::error("Pagamento ID {$payment['id']} não contém status válido.");
        return;
    }

    if (!isset($payment['external_reference']) || empty($payment['external_reference'])) {
        Log::error("Pagamento ID {$payment['id']} não contém external_reference.");
        return;
    }

    // Buscar o usuário pelo external_reference
    $userId = Auth::id();
    $user = User::where('id', $userId)->first();

    if (!$user) {
        Log::error("Usuário não encontrado para external_reference {$payment['external_reference']}");
        return;
    }

    // Se for pagamento PIX pendente, direciona para página correta
    if ($payment['status'] === 'pending' && $payment['payment_method_id'] === 'pix') {
        Log::info("Pagamento PIX pendente para usuário ID {$user->id}. Aguardando confirmação.");
        return;
    }

    // Se status não for tratado, logamos para análise
    Log::warning("Status não tratado para pagamento ID {$payment['id']}: {$payment['status']}");
}



public function createPreference(Request $request)
{
    try {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        if (!$accessToken) {
            Log::error("Mercado Pago: Access Token não encontrado.");
            return response()->json(["error" => "Erro na configuração do Mercado Pago"], 500);
        }

        $url = "https://api.mercadopago.com/checkout/preferences";

        $amount = floatval($request->amount); // Garante que o valor é numérico

        $response = Http::withToken($accessToken)->post($url, [
            "items" => [
                [
                    "title" => "Produto Teste",
                    "quantity" => 1,
                    "currency_id" => "BRL", // Adicionado para evitar problemas de moeda
                    "unit_price" => $amount
                ]
            ],
            "payer" => [
                "email" => $request->payer_email
            ],
            "external_reference" => auth()->id() ?? "pedido_" . time(), // Defina uma referência única
            "back_urls" => [
                "success" => url('/pagamento-sucesso'),
                "failure" => url('/pagamento-falha'),
                "pending" => url('/pagamento-pendente')
            ],
            "auto_return" => "approved"
        ]);

        if ($response->failed()) {
            Log::error("Erro ao criar a preferência: " . $response->body());
            return response()->json(["error" => "Erro ao criar a preferência", "details" => $response->json()], 500);
        }

        return response()->json(["preferenceId" => $response->json()["id"]]);

    } catch (\Exception $e) {
        Log::error("Exceção ao criar preferência: " . $e->getMessage());
        return response()->json(["error" => "Erro interno ao processar a solicitação"], 500);
    }
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
        Log::info("Response: $response");
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

        $userId = Auth::id();
        $user = User::find($userId);
        //$user = User::where('id', $payment['external_reference'])->first();
        Log::info("Usuário $user");
        if (!$user) {
            Log::info("Usuário não encontrado para pagamento ID {$payment['id']} - External Reference: {$payment['external_reference']}");
            return;
        }
    
        // Se o pagamento foi aprovado, adiciona crédito ao usuário
        if ($payment['status'] === 'approved') {
            $user->credito += $payment['transaction_amount'];
            $user->save();
    
            Log::info("Crédito de {$payment['transaction_amount']} adicionado ao usuário ID {$user->id}");
            return;
        }
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
