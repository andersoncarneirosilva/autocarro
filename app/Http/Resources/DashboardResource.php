<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    // Remove o envelope "data" que o Laravel coloca por padrão
    public static $wrap = null;

    // app/Http/Resources/DashboardResource.php
public function toArray($request)
{
    return [
        'total_ativos'      => $this['totalAtivos'],      // Ajuste para snake_case
        'total_vendidos'    => $this['totalVendidos'],
        'receita_vendas'    => $this['receitaVendas'],
        'valor_estoque'     => $this['valorEstoque'],
        'contas_a_pagar'    => $this['contasAPagar'],
        'quantidade_pendente' => $this['quantidadePendente'],
        // Isso aqui é o que resolve o ID=0 e os campos nulos:
        'ultimos_veiculos'  => $this['ultimosVeiculos'], 
    ];
}
}