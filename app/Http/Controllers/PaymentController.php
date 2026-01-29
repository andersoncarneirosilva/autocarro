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
        return redirect()
            ->route('pagamento.index')
            ->with([
                'plano' => $request->plano,
                'preco' => $request->preco,
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
        if (! $user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        try {
            $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

            /*
            | 1️⃣ Criar pedido local
            */
            $pedido = Assinatura::create([
                'plano'        => $request->plano ?? 'Padrão',
                'valor'        => $request->amount,
                'status'       => 'pending',
                'class_status' => 'badge badge-outline-warning',
                'user_id'      => $user->id,
                'data_inicio'  => now(),
                'data_fim'     => now()->addDays(30),
            ]);

            $pedido->external_reference = 'assinatura_' . $pedido->id;
            $pedido->save();

            /*
            | 2️⃣ Criar pagamento no Mercado Pago
            */
            $response = Http::withToken($accessToken)->post(
                'https://api.mercadopago.com/v1/payments',
                [
                    'transaction_amount' => (float) $request->amount,
                    'payment_method_id'  => 'pix',
                    'payer' => [
                        'email' => $user->email,
                    ],
                    'external_reference' => $pedido->external_reference,
                    'notification_url'   => url('api/webhook-payment'),
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

            Log::info('PIX criado', [
                'pedido_id'  => $pedido->id,
                'payment_id' => $payment['id'] ?? null,
            ]);

            return response()->json([
                'qr_code'        => data_get($payment, 'point_of_interaction.transaction_data.qr_code'),
                'qr_code_base64'=> data_get($payment, 'point_of_interaction.transaction_data.qr_code_base64'),
                'ticket_url'    => data_get($payment, 'point_of_interaction.transaction_data.ticket_url'),
            ]);

        } catch (\Exception $e) {
            Log::error('Erro PIX: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno'], 500);
        }
    }
}
