<?php

namespace App\Http\Controllers;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Log;

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
    Log::info('📥 Webhook Recebido:', $request->all());  // Log completo dos dados

    // Acessar o ID diretamente, se não estiver em 'data'
    if (!$request->has('id')) {
        Log::error('🚨 ID de pagamento não encontrado no Webhook.', ['dados' => $request->all()]);
        return response()->json(['status' => 'error', 'message' => 'ID de pagamento não encontrado no Webhook.'], 400);
    }

    $paymentId = $request->input('id');
    Log::info('✅ ID do pagamento recebido:', ['payment_id' => $paymentId]);

    return response()->json(['status' => 'success']);
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
