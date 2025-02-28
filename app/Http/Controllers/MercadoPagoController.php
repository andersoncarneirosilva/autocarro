<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use Illuminate\Support\Facades\Log;

class MercadoPagoController extends Controller
{
    public function createPaymentPreference(Request $request)
{
    try {
        Log::info('Criando preferência de pagamento');

        $this->authenticate();
        Log::info('Autenticado com sucesso');

        $amount = $request->input('amount', 10000);
        Log::info("Valor do pagamento: {$amount}");

        $payer = [
            "name" => "Cliente Teste",
            "surname" => "da Silva",
            "email" => "cliente@email.com",
        ];

        $requestData = [
            "items" => [
                [
                    "title" => "Pagamento Pix",
                    "quantity" => 1,
                    "unit_price" => $amount / 100,
                    "currency_id" => "BRL",
                ]
            ],
            "payer" => $payer,
            "payment_methods" => [
                "excluded_payment_methods" => [],
                "installments" => 1,
            ],
            "back_urls" => [
                'success' => route('mercadopago.success'),
                'failure' => route('mercadopago.failed'),
            ],
            "auto_return" => "approved",
        ];

        Log::info('Criando preferência com o Mercado Pago', $requestData);

        $client = new PreferenceClient();
        $preference = $client->create($requestData);

        Log::info('Preferência criada com sucesso', ['id' => $preference->id]);

        return response()->json([
            'id' => $preference->id,
            'init_point' => $preference->init_point,
        ]);
    } catch (\Exception $e) {
        Log::error("Erro ao criar preferência: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


    public function processPayment(Request $request)
    {
        $this->authenticate();

        $data = $request->all();
        Log::info('Recebendo pagamento:', $data);

        if (empty($data['transaction_amount']) || empty($data['payer'])) {
            return response()->json(["message" => "Dados inválidos."], 400);
        }

        try {
            $client = new PaymentClient();
            $payment = $client->create([
                "transaction_amount" => $data['transaction_amount'],
                "payment_method_id" => "pix",
                "payer" => [
                    "email" => $data['payer']['email']
                ]
            ]);

            return response()->json(["status" => "approved", "message" => "Pagamento realizado com sucesso!"]);
        } catch (\Exception $e) {
            return response()->json(["status" => "error", "message" => $e->getMessage()], 500);
        }
    }

    protected function authenticate()
    {
        $mpAccessToken = config('services.mercadopago.token');
        if (!$mpAccessToken) {
            throw new \Exception("O token de acesso do Mercado Pago não está configurado.");
        }
        MercadoPagoConfig::setAccessToken($mpAccessToken);
    }
}
