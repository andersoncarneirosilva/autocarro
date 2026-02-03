<?php

namespace App\Http\Resources; // <-- Verifique se esta linha está exatamente assim

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource // <-- O nome deve ser exatamente este
{
    public function toArray($request)
{
    return [
        'total_ativos' => (int) $this['totalAtivos'],
        'total_vendidos' => (int) $this['totalVendidos'],
        'receita_vendas' => (float) $this['receitaVendas'],
        'valor_estoque' => (float) $this['valorEstoque'],
        'contas_a_pagar' => (float) $this['contasAPagar'],
        'quantidade_pendente' => (int) $this['quantidadePendente'],
        // values()->all() garante que o JSON seja um array [] e não um objeto {}
        'ultimos_veiculos' => $this['ultimosVeiculos'] ? $this['ultimosVeiculos']->values()->all() : [],
    ];
}
}