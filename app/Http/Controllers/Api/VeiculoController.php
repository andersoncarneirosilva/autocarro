<?php

namespace App\Http\Controllers\Api;

use App\Models\Veiculo;
use App\Http\Resources\VeiculoResource;

public function index()
{
    // O Laravel aplicará o Global Scope do Trait automaticamente aqui!
    $veiculos = Veiculo::orderBy('created_at', 'desc')->get();

    return VeiculoResource::collection($veiculos);
}