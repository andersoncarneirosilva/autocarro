<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VeiculoGasto;
use Illuminate\Support\Facades\Log;

class GastoController extends Controller
{
    public function index()
{
    try {
        // Buscamos os gastos com o relacionamento 'veiculo' para mostrar na lista geral
        // Se o MultiTenant estiver ativo, ele já filtrará por empresa_id aqui.
        $gastos = VeiculoGasto::with('veiculo') 
            ->orderBy('data_gasto', 'desc')
            ->get();

        // Se você não usa Resources para gastos ainda, pode retornar o JSON direto:
        return response()->json($gastos);
        
        // OU se quiser usar Resource (recomendado para manter o padrão Alcecar):
        // return GastoResource::collection($gastos);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Erro ao buscar lista de gastos',
            'details' => $e->getMessage()
        ], 500);
    }
}


}