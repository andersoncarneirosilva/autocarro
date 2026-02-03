<?php

namespace App\Http\Controllers\Api;

use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;

public function index()
{
    // Retorna todos os veículos da empresa do usuário logado
    $veiculos = Veiculo::where('empresa_id', auth()->user()->empresa_id)
                       ->orderBy('created_at', 'desc')
                       ->get();

    return VeiculoResource::collection($veiculos);
}