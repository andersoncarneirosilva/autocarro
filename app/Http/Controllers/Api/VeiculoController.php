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
}