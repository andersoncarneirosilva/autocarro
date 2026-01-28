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
                if (empty($paymentData['id'])) {
                    Log::error("Pagamento ID {$paymentData['id']} não contém external_reference.");

                    return response()->json(['message' => 'Pagamento sem external_reference'], 200);
                }

                $externalReference = $paymentData['id'];
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
    Log::info('Entrou na : createPixPayment');

    // 1. REMOVA a verificação de $request->bearerToken(). 
    // No Alcecar Web, usamos o Auth padrão.
    $user = Auth::user();

    if (!$user) {
        Log::error('Usuário não autenticado via sessão.');
        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    try {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        if (!$accessToken) {
            Log::error('Mercado Pago: Access Token não encontrado no .env.');
            return response()->json(['error' => 'Erro na configuração do servidor'], 500);
        }

        $url = 'https://api.mercadopago.com/v1/payments';

        // 2. Adicione o cabeçalho X-Idempotency-Key para evitar o erro 400
        $response = Http::withToken($accessToken)
            ->withHeaders([
                'X-Idempotency-Key' => uniqid('pix_', true)
            ])
            ->post($url, [
                'transaction_amount' => floatval($request->amount),
                'payment_method_id'  => 'pix',
                'description'        => "Plano " . ($request->plano ?? 'Alcecar'),
                'payer' => [
                    'email' => $request->payer_email,
                ],
                'external_reference' => 'user_' . $user->id . '_' . time(),
            ]);

        $paymentData = $response->json();

        // 3. Verifique se o Mercado Pago aceitou antes de tentar salvar no banco
        if ($response->failed()) {
            Log::error('Erro ao criar pagamento PIX no MP: ' . $response->body());
            return response()->json(['error' => 'Erro ao criar pagamento PIX', 'details' => $paymentData], 500);
        }

        // 4. Salvar o pedido no banco de dados (Tabela Assinaturas)
        $pedido = new Assinatura;
        $pedido->valor = $request->amount;
        $pedido->status = 'pending';
        $pedido->class_status = 'badge badge-outline-warning';
        $pedido->user_id = $user->id;
        $pedido->external_reference = $paymentData['id']; // ID real do Mercado Pago
        $pedido->data_inicio = now();
        $pedido->data_fim = now()->addDays(30);
        $pedido->plano = $request->plano ?? 'Padrão';
        $pedido->save();

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
    Log::info("Atualizando status do pagamento ID {$payment['id']} para {$payment['status']}");

    // Busca a assinatura pelo ID do Mercado Pago (external_reference)
    $pedido = \App\Models\Assinatura::where('external_reference', $payment['id'])->first();

    if (!$pedido) {
        Log::error("Pedido não encontrado para o ID {$payment['id']}");
        return;
    }

    if ($payment['status'] === 'approved') {
        // 1. Atualiza a Assinatura
        $pedido->class_status = 'badge badge-outline-success';
        $pedido->status = 'approved'; // ou 'paid', conforme seu JS espera
        $pedido->save();

        // 2. Atualiza o Usuário (Importante: usar o Model User)
        $user = \App\Models\User::find($pedido->user_id);
        if ($user) {
            $user->plano = $pedido->plano; // Define o novo plano (Start, Standard, Pro)
            // Se você usa validade de plano:
            // $user->plano_expira_em = now()->addDays(30); 
            $user->save();
            Log::info("Plano do usuário ID {$user->id} atualizado para {$pedido->plano}");
        }

        return;
    }
}
}
