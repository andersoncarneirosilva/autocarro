<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    // Remove o envelope "data" que o Laravel coloca por padrão
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'total_ativos'        => (int) $this['totalAtivos'],
            'total_vendidos'      => (int) $this['totalVendidos'],
            'receita_vendas'      => (float) $this['receitaVendas'],
            'valor_estoque'       => (float) $this['valorEstoque'],
            'contas_a_pagar'      => (float) $this['contasAPagar'],
            'quantidade_pendente' => (int) $this['quantidadePendente'],
            'ultimos_veiculos'    => $this['ultimosVeiculos'] ? $this['ultimosVeiculos']->map(function($v) {
                return [
                    'modelo' => $v->modelo,
                    'placa'  => $v->placa,
                    'valor'  => (float) $v->valor
                ];
            })->values()->all() : [],
        ];
    }
}