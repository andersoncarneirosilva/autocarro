<?php

namespace App\Http\Controllers\Api;

use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;

class VeiculoController extends Controller
{
    public function index()
    {
        // Usamos try-catch para ver o erro no Logcat se algo falhar no banco
        try {
            // O Trait MultiTenant cuidará do filtro automaticamente
            $veiculos = Veiculo::all();
            return VeiculoResource::collection($veiculos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
}