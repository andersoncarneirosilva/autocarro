<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
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
        $user_id = User::find($userId);
        $userEmail = $user_id->email;

        // dd($userEmail);
        return view('planos.index', compact(['userId']));
    }

    public function selecionarPlano(Request $request)
    {
        // Recebe os dados do plano e redireciona para a página de pagamento
        return redirect()->route('pagamento.index')->with([
            'plano' => $request->input('plano'),
            'preco' => $request->input('preco'),
        ]);
    }

    public function paginaPagamento()
    {
        $userId = Auth::id();
        $user_id = User::find($userId);
        $userEmail = $user_id->email;
        // Recupera os dados do plano armazenados na sessão
        $plano = session('plano');
        $preco = session('preco');

        if (! $plano || ! $preco) {
            return redirect('/')->with('error', 'Por favor, selecione um plano antes de prosseguir.');
        }

        return view('pagamento.index', compact('plano', 'preco', 'userEmail', 'user_id'));
    }

    public function handleWebhook(Request $request)
    {
        try {
            Log::info('handleWebhook - Recebido:', $request->all());

            $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

            if ($request->type === 'payment' && isset($request->data['id'])) {
                $paymentId = $request->data['id'];

                // Buscar detalhes do pagamento
                $paymentData = $this->getPaymentDetails($paymentId, $accessToken);

                if (! $paymentData) {
                    Log::warning("handleWebhook - Pagamento não encontrado: ID {$paymentId}");

                    return response()->json(['message' => 'Pagamento não encontrado'], 200);
                }

                Log::info('handleWebhook - Resposta do Mercado Pago: '.json_encode($paymentData));

                // Verificar se existe external_reference
                if (empty($paymentData['external_reference'])) {
                    Log::error("Pagamento {$paymentData['id']} não contém external_reference.");
                    return response()->json(['message' => 'Pagamento sem external_reference'], 200);
                }

                $externalReference = $paymentData['external_reference'];

                Log::info("handleWebhook - Pagamento external_reference: {$externalReference}");

                // Buscar o pedido na tabela pedidos
                $pedido = Assinatura::where('external_reference', $externalReference)->first();

                if (! $pedido) {
                    Log::error("handleWebhook - Pedido não encontrado para external_reference {$externalReference}");

                    return response()->json(['message' => 'Pedido não encontrado'], 404);
                }

                // Chama a função para atualizar o status do pagamento
                Log::info("handleWebhook - Chamando updatePaymentStatus para pagamento ID {$paymentData['id']}");
                $this->updatePaymentStatus($paymentData, $pedido);

                return response()->json(['message' => 'Webhook processado com sucesso']);
            }

            Log::warning('handleWebhook - Evento Webhook não reconhecido:', $request->all());

            return response()->json(['message' => 'Nenhuma ação necessária'], 200);

        } catch (\Exception $e) {
            Log::error('Erro no webhook: '.$e->getMessage());

            return response()->json(['error' => 'Erro interno'], 500);
        }
    }

    public function createPixPayment(Request $request)
{
    Log::info('Entrou na createPixPayment');

    $user = Auth::user();
    if (! $user) {
        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    Log::info('Usuário autenticado', ['user_id' => $user->id]);

    try {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');
        if (! $accessToken) {
            throw new \Exception('Access Token Mercado Pago não configurado');
        }

        // 1️⃣ CRIA A ASSINATURA PRIMEIRO
        $pedido = new Assinatura;
        $pedido->valor = $request->amount;
        $pedido->status = 'pending';
        $pedido->class_status = 'badge badge-outline-warning';
        $pedido->user_id = $user->id;
        $pedido->plano = $request->plano ?? 'Padrão';
        $pedido->data_inicio = now();
        $pedido->data_fim = now()->addDays(30);
        $pedido->save(); // 🔥 agora $pedido->id existe

        // 2️⃣ DEFINE O external_reference CORRETO
        $pedido->external_reference = 'assinatura_'.$pedido->id;
        $pedido->save();

        // 3️⃣ CRIA O PAGAMENTO NO MERCADO PAGO
        $response = Http::withToken($accessToken)->post(
            'https://api.mercadopago.com/v1/payments',
            [
                'transaction_amount' => (float) $request->amount,
                'payment_method_id' => 'pix',
                'payer' => [
                    'email' => $request->payer_email,
                ],
                'external_reference' => $pedido->external_reference,
                'notification_url' => url('/webhook-payment'),
            ]
        );

        if ($response->failed()) {
            Log::error('Erro Mercado Pago', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json(['error' => 'Erro ao criar pagamento PIX'], 500);
        }

        $paymentData = $response->json();

        Log::info('Pagamento PIX criado', [
            'pedido_id' => $pedido->id,
            'payment_id' => $paymentData['id'] ?? null
        ]);

        return response()->json([
            'qr_code' => $paymentData['point_of_interaction']['transaction_data']['qr_code'] ?? null,
            'qr_code_base64' => $paymentData['point_of_interaction']['transaction_data']['qr_code_base64'] ?? null,
            'ticket_url' => $paymentData['point_of_interaction']['transaction_data']['ticket_url'] ?? null,
        ]);

    } catch (\Exception $e) {
        Log::error('Exceção ao criar pagamento PIX: ' . $e->getMessage());

        return response()->json(['error' => 'Erro interno ao processar o pagamento'], 500);
    }
}


    private function getPaymentDetails($paymentId)
    {
        Log::info('Entrou na : getPaymentDetails');
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
                Log::warning('Pagamento não encontrado. Tentando novamente... (Tentativa: '.($retryCount + 1).')');
            }

            $retryCount++;
            sleep(2); // Aguarda 2 segundos antes de tentar novamente
        }

        Log::error('Erro ao buscar pagamento após múltiplas tentativas: '.$response->body());

        return null;
    }

    private function updatePaymentStatus($payment)
    {
        Log::info("Entrou na função updatePaymentStatus para pagamento ID {$payment['id']} com status {$payment['status']}");

        if (! isset($payment['status'])) {
            Log::error("Pagamento ID {$payment['id']} não contém status válido.");

            return;
        }

        // Verificar se o external_reference existe e não está vazio
        if (empty($payment['id'])) {
            Log::error("Pagamento ID {$payment['id']} não contém external_reference válido.");

            return;
        }

        // Buscar o pedido pelo external_reference
        $pedido = \App\Models\Assinatura::where('external_reference', $payment['id'])->first();

        if (! $pedido) {
            Log::error("updatePaymentStatus - Pedido não encontrado para external_reference {$payment['id']}.");

            return;
        }

        // Buscar o usuário associado ao pedido
        $user = \App\Models\Assinatura::find($pedido->user_id);

        if (! $user) {
            Log::error("updatePaymentStatus - Usuário não encontrado para pedido ID {$pedido->id}.");

            return;
        }

        // Se for pagamento PIX pendente
        if ($payment['status'] === 'pending' && $payment['payment_method_id'] === 'pix') {
            Log::info("Pagamento PIX pendente para pedido ID {$pedido->id}. Aguardando confirmação.");

            return;
        }

        // ✅ Novo tratamento para pagamento aprovado
        if ($payment['status'] === 'approved') {
            Log::info("Pagamento aprovado para pedido ID {$pedido->id}. Atualizando status...");

            // Atualiza o status do pedido
            $pedido->class_status = 'badge badge-outline-success';
            $pedido->status = 'paid';
            $pedido->save();

            // Adiciona crédito ao usuário referente ao valor do pedido
            $user->payment_status = 'paid';
            $user->credito += $payment['transaction_amount'];
            $user->save();

            Log::info("Status do pedido atualizado para 'paid' e crédito adicionado ao usuário ID {$user->id}.");

            return;
        }

        // Se status não for tratado, logamos para análise
        Log::warning("Status não tratado para pagamento ID {$payment['id']}: {$payment['status']}");
    }
}
