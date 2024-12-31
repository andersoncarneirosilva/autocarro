<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\PaymentMethod;
use MercadoPago\MPRequestOptions;

class PaymentController extends Controller
{
    public function index(Request $request){

     
        return view('pagamentos.index');
    }


    public function createPayment(Request $request)
    {
        // Definindo o token de acesso do Mercado Pago
        SDK::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));

        // Criação de um objeto MPRequestOptions para customizar a requisição
        $requestOptions = new MPRequestOptions();
        $requestOptions->setCustomHeaders(["X-Idempotency-Key: " . uniqid()]);

        // Dados de pagamento recebidos via POST (ou outra fonte)
        $paymentData = [
            "payment_method_id" => $request->input('paymentMethodId'),
            "transaction_amount" => (float) $request->input('transactionAmount'),
            "payer" => [
                "email" => $request->input('email'),
            ]
        ];

        // Criando o pagamento via MercadoPago
        $payment = new Payment();
        $payment->transaction_amount = $paymentData['transaction_amount'];
        $payment->payment_method_id = $paymentData['payment_method_id'];
        $payment->payer = $paymentData['payer'];
        
        // Enviando a requisição com os parâmetros configurados
        try {
            $payment->save(null, $requestOptions);
            
            // Retornar a resposta do pagamento
            return response()->json([
                'status' => 'success',
                'message' => 'Pagamento criado com sucesso!',
                'payment' => $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar o pagamento: ' . $e->getMessage()
            ], 500);
        }
    }


}
