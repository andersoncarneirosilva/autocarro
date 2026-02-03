<?php

namespace App\Http\Controllers\Api;

// O segredo está nesta linha abaixo: apontar para a pasta correta do Controller base
use App\Http\Controllers\Controller; 
use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        try {
            // O Trait MultiTenant filtrará automaticamente por empresa_id
            $veiculos = Veiculo::all();
            return VeiculoResource::collection($veiculos);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao listar veículos',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $veiculo = Veiculo::find($id);
            if (!$veiculo) {
                return response()->json(['message' => 'Veículo não encontrado'], 404);
            }
            return new VeiculoResource($veiculo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updatePrecos(Request $request, $id)
{
    // Busca o veículo (usando withoutGlobalScopes se necessário, como no seu Dashboard)
    $veiculo = Veiculo::withoutGlobalScopes()->find($id);

    if (!$veiculo) {
        return response()->json(['message' => 'Veículo não encontrado'], 404);
    }

    $validated = $request->validate([
        'valor'               => 'required|numeric',
        'valor_compra'        => 'nullable|numeric',
        'valor_oferta'        => 'nullable|numeric',
        'exibir_parcelamento' => 'required', // Remova 'boolean' temporariamente se der erro
        'qtd_parcelas'        => 'required|integer',
        'taxa_juros'          => 'required|numeric',
        'valor_parcela'       => 'nullable|numeric',
    ]);

    try {
        // Atualiza os dados no banco
        $veiculo->update([
            'valor'               => $request->valor,
            'valor_compra'        => $request->valor_compra,
            'valor_oferta'        => $request->valor_oferta,
            'exibir_parcelamento' => $request->exibir_parcelamento,
            'qtd_parcelas'        => $request->qtd_parcelas,
            'taxa_juros'          => $request->taxa_juros,
            // Se você quiser salvar o valor da parcela calculado:
            'valor_parcela'       => $request->valor_parcela, 
        ]);

        return response()->json(['message' => 'Preços atualizados com sucesso!'], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Erro ao salvar: ' . $e->getMessage()], 500);
    }
}

}