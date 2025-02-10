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

        // Verifica se é um evento de atualização de pagamento
        if ($request->type === 'payment' && $request->action === 'payment.updated') {
            $paymentId = $request->data['id'];

            // Buscar detalhes do pagamento via API do Mercado Pago
            $payment = $this->getPaymentDetails($paymentId);

            if ($payment) {
                // Atualizar status no banco de dados
                $this->updatePaymentStatus($payment);
            }
        }

        return response()->json(['status' => 'success']);
    }


}
