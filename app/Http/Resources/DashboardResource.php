<?php

namespace App\Http\Resources\Api; // <-- Verifique se esta linha está exatamente assim

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource // <-- O nome deve ser exatamente este
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
            'ultimos_veiculos' => $this['ultimosVeiculos']
        ];
    }
}