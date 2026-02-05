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

public function updateStatus(Request $request, $id)
    {
        // 1. Validação dos dados recebidos
        $request->validate([
            'pago' => 'required|integer|in:0,1',
        ]);

        // 2. Busca o gasto ou retorna 404
        $gasto = VeiculoGasto::findOrFail($id);

        // 3. Atualiza apenas o campo pago
        $gasto->pago = $request->pago;
        
        // Opcional: registrar a data do pagamento se houver essa coluna
        if ($request->pago == 1) {
            $gasto->data_pagamento = now();
        }

        $gasto->save();

        // 4. Retorna o objeto atualizado e status 200
        return response()->json([
            'message' => 'Status do gasto atualizado com sucesso!',
            'gasto' => $gasto
        ], 200);
    }


}