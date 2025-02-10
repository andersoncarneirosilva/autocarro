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

    public function processPayment(Request $request)
{
    Log::info('Dados recebidos:', $request->all());

    try {
        $transactionAmount = 10; // Valor da transação

        // Verificar se o valor da transação é positivo
        if ($transactionAmount <= 0) {
            return response()->json(['status' => 'error', 'message' => 'O valor da transação deve ser positivo.'], 400);
        }

        // Obter o token de acesso
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
        $preferenceData = [
            "items" => [
                [
                    "title" => "Produto Exemplo",
                    "quantity" => 1,
                    "unit_price" => 10000, // Valor total da transação
                ]
            ],
            "payer" => [
                "email" => $request->input('payer.email')
            ],
            "payment_methods" => [
                "excluded_payment_types" => [
                    [
                        "id" => "ticket"
                    ]
                ],
                "installments" => 1
            ],
            "back_urls" => [
                "success" => "http://www.your-site.com/success",
                "failure" => "http://www.your-site.com/failure",
                "pending" => "http://www.your-site.com/pending"
            ],
            "auto_return" => "approved",
        ];
        
        // Requisição para criar a preferência
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('https://api.mercadopago.com/checkout/preferences', $preferenceData);
        
        $preference = $response->json();
        
        if ($response->successful()) {
            // Encontre o usuário pelo e-mail (supondo que você tenha o e-mail do pagador)
            $payerEmail = $request->input('payer.email');
            $user = User::where('email', $payerEmail)->first();
        
            if ($user) {
                // Atualize o valor de 'credito' na tabela 'user'
                $user->credito += $transactionAmount; // Adiciona o valor da transação
                $user->save(); // Salva a alteração no banco de dados
        
                Log::info('Valor de crédito atualizado para o usuário.', ['user_id' => $user->id, 'new_credito' => $user->credito]);
            } else {
                // Se o usuário não for encontrado
                Log::error('Usuário não encontrado para o pagamento.', ['email' => $payerEmail]);
            }
        
            // Retorne o preferenceId para o frontend
            return response()->json([
                'status' => 'success',
                'message' => 'Preferência criada com sucesso e crédito adicionado.',
                'preferenceId' => $preference['id']
            ]);
        } else {
            // Logar o erro
            Log::error('Erro ao criar a preferência', ['response' => $response->json()]);
            return response()->json(['status' => 'error', 'message' => 'Erro ao criar a preferência'], 500);
        }

        // Preparar dados para a requisição do pagamento
        $paymentData = [
            'transaction_amount' => $transactionAmount,
            'payment_method_id' => $request->input('paymentMethodId'),
            'preference_id' => $preference['id'], // Usar o preferenceId obtido
            'payer' => [
                'email' => $request->input('payer.email')
            ]
        ];

        // Requisição para a API do Mercado Pago para realizar o pagamento
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('https://api.mercadopago.com/v1/payments', $paymentData);
        
        if ($response->successful()) {
            // Retorne a resposta do pagamento ou qualquer outro dado necessário
            return response()->json([
                'status' => 'success',
                'message' => 'Pagamento realizado com sucesso.',
                'paymentDetails' => $response->json()
            ]);
        } else {
            // Logar o erro
            Log::error('Erro na requisição do Mercado Pago', ['response' => $response->json()]);
            return response()->json(['status' => 'error', 'message' => 'Erro ao processar pagamento'], 500);
        }

    } catch (\Exception $e) {
        // Logar o erro inesperado
        Log::error('Erro ao processar pagamento: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Erro ao processar pagamento'], 500);
    }
}

public function handleNotification(Request $request)
    {
        // Exemplo de log para depuração
        Log::info('Notificação recebida:', $request->all());

        // Aqui você pode implementar o tratamento dos dados da notificação
        // e realizar as ações necessárias, como atualizar o status de pagamento
        // ou qualquer outra lógica que precise ser executada.

        return response()->json(['status' => 'success']); // Retorna a resposta de sucesso
    }


    public function webhook(Request $request)
{
    Log::info('📥 Webhook Recebido:', $request->all());

    // Buscar o 'id' do pagamento dentro do objeto "data"
    $paymentId = $request->input('data.id'); 

    if (!$paymentId) {
        Log::error('🚨 Nenhum identificador de pagamento encontrado no Webhook.', ['dados' => $request->all()]);
        return response()->json(['status' => 'error', 'message' => 'Nenhum identificador de pagamento encontrado no Webhook.'], 400);
    }

    Log::info('✅ Identificador de pagamento encontrado:', ['payment_id' => $paymentId]);

    // Agora, use esse identificador para verificar o status do pagamento
    return $this->checkPixPaymentStatus($paymentId);
}


    
    public function checkPaymentStatus($paymentId)
{
    $accessToken = 'SEU_ACCESS_TOKEN_AQUI';

    $client = new Client();
    $url = "https://api.mercadopago.com/v1/payments/{$paymentId}";

    try {
        $response = $client->get($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type'  => 'application/json',
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['status'])) {
            Log::info('✅ Status do pagamento verificado:', ['payment' => $data]);
            return response()->json(['status' => 'success', 'payment_status' => $data['status']]);
        } else {
            Log::error('🚨 Erro ao verificar status do pagamento:', ['response' => $data]);
            return response()->json(['error' => 'Erro ao verificar status do pagamento'], 400);
        }
    } catch (\Exception $e) {
        Log::error('🚨 Erro ao verificar status do pagamento:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Erro ao verificar status do pagamento'], 500);
    }
}

    
    public function createPayment(Request $request)
{
    $accessToken = 'TEST-8914757128151217-052016-2aecf8b6d63e0a16384bbcb38ac43421-168922160';

    $client = new Client();
    $url = "https://api.mercadopago.com/v1/payments";

    try {
        $response = $client->post($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'token' => $request->input('token'),
                'transaction_amount' => $request->input('transaction_amount'),
                'payment_method_id' => $request->input('payment_method_id'),
                'payer' => [
                    'email' => $request->input('payer.email'),
                    'identification' => [
                        'type' => $request->input('payer.identification.type'),
                        'number' => $request->input('payer.identification.number'),
                    ],
                ],
                'installments' => $request->input('installments'),
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['id'])) {
            Log::info("✅ Pagamento criado com sucesso!", ['payment_id' => $data['id']]);

            return response()->json([
                'status' => 'success',
                'payment_id' => $data['id'],
                'payment_status' => $data['status'],
            ]);
        } else {
            Log::error("🚨 Erro ao criar pagamento", ['response' => $data]);
            return response()->json(['error' => 'Erro ao criar pagamento'], 400);
        }
    } catch (\Exception $e) {
        Log::error("🚨 Erro ao criar pagamento", ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Erro ao criar pagamento'], 500);
    }
}




    






public function createPreference(Request $request)
{
    try {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        $preferenceData = [
            "items" => [
                [
                    "title" => "Produto Exemplo",
                    "quantity" => 1,
                    "unit_price" => 10000, // Valor total
                ]
            ],
            "payer" => [
                "email" => $request->input('payer_email')
            ],
            "back_urls" => [
                "success" => url('/success'),
                "failure" => url('/failure'),
                "pending" => url('/pending')
            ],
            "auto_return" => "approved",
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post('https://api.mercadopago.com/checkout/preferences', $preferenceData);

        $preference = $response->json();

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'preferenceId' => $preference['id']
            ]);
        } else {
            Log::error('Erro ao criar a preferência', ['response' => $preference]);
            return response()->json(['status' => 'error', 'message' => 'Erro ao criar a preferência'], 500);
        }

    } catch (\Exception $e) {
        Log::error('Erro ao criar preferência: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Erro interno'], 500);
    }
}


}
