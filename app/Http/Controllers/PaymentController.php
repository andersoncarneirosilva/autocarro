<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\PaymentMethod;
use MercadoPago\MPRequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\MercadoPagoConfig;
class PaymentController extends Controller
{
    public function index(Request $request){

     
        return view('pagamentos.index');
    }


    public function createPayment(Request $request)
{
    //dd($request);
    // Configuração do token de acesso
    MercadoPagoConfig::setAccessToken("TEST-2084613033449498-123021-969ac33b8b6dc086af4603bc3bbde743-168922160");

    // Instância do cliente e opções de requisição
    $client = new PaymentClient();
    $request_options = new RequestOptions();

    // Gerar uma chave única para evitar duplicidades
    $idempotencyKey = "0d5020ed-1af6-469c-ae06-c3bec19954bb";

    $request_options->setCustomHeaders([
        "X-Idempotency-Key: $idempotencyKey"
    ]);

    // Criar pagamento
    try {
        $payment = $client->create([
            "transaction_amount" => $request->transaction_amount,
            "payment_method_id" => $request->payment_method_id,
            "payer" => [
                "email" => $request->email,
            ],
        ], $request_options);
    } catch (\MercadoPago\Exceptions\MPApiException $e) {
        // Obtenha a mensagem do erro
        echo "Erro na API: " . $e->getMessage() . "\n";
    
        // Se disponível, obtenha o código HTTP e os detalhes da resposta
        if (method_exists($e, 'getHttpStatusCode')) {
            echo "Código HTTP: " . $e->getHttpStatusCode() . "\n";
        }
        if (method_exists($e, 'getApiResponse')) {
            echo "Detalhes da Resposta: " . json_encode($e->getApiResponse(), JSON_PRETTY_PRINT) . "\n";
        }
    
        exit;
    }
    

    // Retornar resposta ou depuração
    return response()->json($payment);
}



}
