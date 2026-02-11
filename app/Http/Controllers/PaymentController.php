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
    /*
    |--------------------------------------------------------------------------
    | TELAS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $userId = Auth::id();
        return view('planos.index', compact('userId'));
    }

    public function selecionarPlano(Request $request)
    {
        // Criamos uma lista de preços oficial dentro do código
        $tabelaPrecos = [
            'Standard' => 49.99,
            'Pro'      => 69.99,
        ];

        $nomeDoPlano = $request->plano;
        $valorDoPlano = $tabelaPrecos[$nomeDoPlano] ?? null;

        if (!$valorDoPlano) {
            return redirect()->back()->with('error', 'Plano inválido.');
        }

        return redirect()
            ->route('pagamento.index')
            ->with([
                'plano' => $nomeDoPlano,
                'preco' => $valorDoPlano, // O preço é salvo na sessão aqui!
            ]);
    }

    public function paginaPagamento()
    {
        $user = Auth::user();

        if (! session('plano') || ! session('preco')) {
            return redirect('/')->with('error', 'Selecione um plano.');
        }

        return view('pagamento.index', [
            'plano'     => session('plano'),
            'preco'     => session('preco'),
            'userEmail' => $user->email,
            'user_id'   => $user,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CRIAR PAGAMENTO PIX
    |--------------------------------------------------------------------------
    */

    public function createPixPayment(Request $request)
{
    Log::info('Entrou na createPixPayment');

    $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Usuário não autenticado'], 401);
    }

    // 1️⃣ TABELA DE PREÇOS (O Servidor é o único dono da verdade)
    // Se você tiver esses valores no banco, substitua por uma query.
    $planosDisponiveis = [
        'Standard' => 49.99,
        'Pro'      => 69.99,
    ];

    // Pegamos o nome do plano enviado pelo JS
    $planoSolicitado = $request->plano;

    // 2️⃣ VALIDAÇÃO DE SEGURANÇA
    if (!isset($planosDisponiveis[$planoSolicitado])) {
        Log::warning('Tentativa de pagamento com plano inválido', ['user_id' => $user->id, 'plano' => $planoSolicitado]);
        return response()->json(['error' => 'Plano inválido ou não selecionado.'], 400);
    }

    // O VALOR REAL vem do nosso array, nunca do $request->amount
    $valorFinal = $planosDisponiveis[$planoSolicitado];

    try {
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        /*
        | 3️⃣ Criar pedido local (Assinatura Pendente)
        */
        $pedido = Assinatura::create([
            'plano'        => $planoSolicitado,
            'valor'        => $valorFinal, // Valor seguro
            'status'       => 'pending',
            'class_status' => 'badge badge-outline-warning',
            'user_id'      => $user->id,
            'data_inicio'  => now(),
            'data_fim'     => now()->addDays(30),
        ]);

        $pedido->external_reference = 'assinatura_' . $pedido->id;
        $pedido->save();

        /*
        | 4️⃣ Criar pagamento no Mercado Pago
        */
        $response = Http::withToken($accessToken)->post(
            'https://api.mercadopago.com/v1/payments',
            [
                'transaction_amount' => (float) $valorFinal, // Valor seguro enviado ao MP
                'payment_method_id'  => 'pix',
                'payer' => [
                    'email' => $user->email,
                    'first_name' => explode(' ', $user->name)[0], // Boa prática enviar o nome
                ],
                'external_reference' => $pedido->external_reference,
                'notification_url'   => url('api/webhook-payment'),
                'description'        => "Assinatura Alcecar - Plano " . $planoSolicitado,
            ]
        );

        if ($response->failed()) {
            Log::error('Erro Mercado Pago', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return response()->json(['error' => 'Erro ao criar pagamento'], 500);
        }

        $payment = $response->json();

        Log::info('PIX criado com sucesso', [
            'pedido_id'  => $pedido->id,
            'plano'      => $planoSolicitado,
            'valor'      => $valorFinal
        ]);

        return response()->json([
            'qr_code'         => data_get($payment, 'point_of_interaction.transaction_data.qr_code'),
            'qr_code_base64'  => data_get($payment, 'point_of_interaction.transaction_data.qr_code_base64'),
            'ticket_url'      => data_get($payment, 'point_of_interaction.transaction_data.ticket_url'),
        ]);

    } catch (\Exception $e) {
        Log::error('Erro PIX: ' . $e->getMessage());
        return response()->json(['error' => 'Erro interno ao processar pagamento'], 500);
    }
}
}
