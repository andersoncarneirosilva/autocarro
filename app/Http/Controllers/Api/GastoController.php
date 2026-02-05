<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VeiculoGasto;
use App\Models\Veiculo;
use Illuminate\Support\Facades\Log;

class GastoController extends Controller
{


public function index()
{
    try {
        // Log para garantir que o código chegou aqui
        \Log::info('Buscando gastos para o usuário: ' . (auth()->user()->id ?? 'Ninguém logado'));

        $gastos = VeiculoGasto::with('veiculo')
            ->orderBy('data_gasto', 'desc')
            ->get();

        return response()->json($gastos);
    } catch (\Throwable $e) { // Throwable pega erros de sintaxe também
        return response()->json([
            'error' => 'Falha no Laravel',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}


}