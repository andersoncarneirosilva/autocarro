<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        try {
            // Inicializar o SDK do Mercado Pago
            SDK::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN')); // Certifique-se de configurar o token no .env

            // Dados recebidos do cliente
            $formData = $request->all();

            // Criar uma preferência de pagamento
            $preference = new Preference();

            $item = new Item();
            $item->title = $formData['title'] ?? 'Produto Padrão';
            $item->quantity = $formData['quantity'] ?? 1;
            $item->unit_price = $formData['unit_price'] ?? 0.0;

            $preference->items = [$item];
            $preference->save();

            // Retornar o link para iniciar o pagamento
            return response()->json([
                'init_point' => $preference->init_point,
            ]);
        } catch (\Exception $e) {
            // Registrar o erro no log e retornar uma mensagem de erro
            \Log::error('Erro ao criar o pagamento: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao processar o pagamento'], 500);
        }
    }
}
