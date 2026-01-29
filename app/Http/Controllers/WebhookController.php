<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function paymentUpdated(Request $request)
    {
        Log::info('Webhook recebido', $request->all());

        if ($request->type !== 'payment' || ! isset($request->data['id'])) {
            return response()->json(['message' => 'Evento ignorado'], 200);
        }

        $paymentId = $request->data['id'];
        $accessToken = env('MERCADO_PAGO_ACCESS_TOKEN');

        /*
        | 1️⃣ Buscar pagamento no Mercado Pago
        */
        $response = Http::withToken($accessToken)
            ->get("https://api.mercadopago.com/v1/payments/{$paymentId}");

        if (! $response->successful()) {
            Log::error('Erro ao buscar pagamento', [
                'payment_id' => $paymentId,
                'response'   => $response->body()
            ]);

            return response()->json(['error' => 'Erro ao consultar pagamento'], 200);
        }

        $payment = $response->json();

        /*
        | 2️⃣ Buscar assinatura pelo external_reference
        */
        if (empty($payment['external_reference'])) {
            Log::error('Pagamento sem external_reference', ['payment' => $payment]);
            return response()->json(['message' => 'Sem referência'], 200);
        }

        $assinatura = Assinatura::where(
            'external_reference',
            $payment['external_reference']
        )->first();

        if (! $assinatura) {
            Log::error('Assinatura não encontrada', [
                'external_reference' => $payment['external_reference']
            ]);

            return response()->json(['message' => 'Assinatura não encontrada'], 200);
        }

        /*
        | 3️⃣ Se ainda estiver pendente, não faz nada
        */
        if ($payment['status'] === 'pending') {
            Log::info("Pagamento pendente", ['assinatura_id' => $assinatura->id]);
            return response()->json(['message' => 'Pagamento pendente'], 200);
        }

        /*
        | 4️⃣ Pagamento aprovado
        */
        if ($payment['status'] === 'approved') {

            // Evita duplicação
            if ($assinatura->status === 'paid') {
                Log::info("Pagamento já processado", ['assinatura_id' => $assinatura->id]);
                return response()->json(['message' => 'Já processado'], 200);
            }

            $assinatura->update([
                'status'       => 'paid',
                'class_status' => 'badge badge-outline-success',
            ]);

            /*
            | 5️⃣ Atualizar usuário
            */
            $user = User::find($assinatura->user_id);

            if ($user) {
                $user->update([
                    'plano'          => $assinatura->plano,
                    'payment_status' => 'paid',
                    'credito'        => $user->credito + $payment['transaction_amount'],
                ]);
            }

            Log::info('Pagamento aprovado e usuário atualizado', [
                'user_id'       => $user->id ?? null,
                'assinatura_id' => $assinatura->id,
                'valor'         => $payment['transaction_amount']
            ]);

            return response()->json(['message' => 'Pagamento confirmado']);
        }

        /*
        | 6️⃣ Outros status
        */
        Log::warning('Status não tratado', [
            'status' => $payment['status']
        ]);

        return response()->json(['message' => 'Status ignorado'], 200);
    }
}
