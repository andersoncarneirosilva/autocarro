<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'total_ativos' => $this['totalAtivos'],
            'total_vendidos' => $this['totalVendidos'],
            'receita_vendas' => (float) $this['receitaVendas'],
            'valor_estoque' => (float) $this['valorEstoque'],
            'contas_a_pagar' => (float) $this['contasAPagar'],
            'quantidade_pendente' => $this['quantidadePendente'],
            'ultimos_veiculos' => $this['ultimosVeiculos']->map(function($veiculo) {
                return [
                    'id' => $veiculo->id,
                    'modelo' => $veiculo->modelo,
                    'placa' => $veiculo->placa,
                    'valor' => (float) $veiculo->valor,
                ];
            }),
        ];
    }
}