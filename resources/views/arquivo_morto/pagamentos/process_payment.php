
<?php
  use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

MercadoPagoConfig::setAccessToken('YOUR_ACCESS_TOKEN');

$client = new PaymentClient;
$request_options = new RequestOptions;
$request_options->setCustomHeaders(['X-Idempotency-Key: <SOME_UNIQUE_VALUE>']);

$payment = $client->create([
    'transaction_amount' => (float) $_POST['<TRANSACTION_AMOUNT>'],
    'payment_method_id' => $_POST['<PAYMENT_METHOD_ID>'],
    'payer' => [
        'email' => $_POST['<EMAIL>'],
    ],
], $request_options);
echo implode($payment);
?>
