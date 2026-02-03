<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VeiculoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'versao' => $this->versao,
            'placa' => $this->placa,
            'cor' => $this->cor,
            'ano_fabricacao' => $this->ano_fabricacao,
            'ano_modelo' => $this->ano_modelo,
            'cambio' => $this->cambio,
            'kilometragem' => (int) $this->kilometragem,
            'valor' => (double) $this->valor,
            'valor_oferta' => (double) $this->valor_oferta,
            'status' => $this->status,
            
            // Decodifica as imagens se for um JSON string no banco
            'images' => is_string($this->images) ? json_decode($this->images) : $this->images,
            
            // Informações adicionais úteis para o app
            'detalhes' => [
                'combustivel' => $this->combustivel,
                'potencia' => $this->potencia,
                'portas' => $this->portas,
                'cilindrada' => $this->cilindrada,
            ],
            
            // Datas formatadas
            'data_cadastro' => $this->created_at->format('d/m/Y'),
        ];
    }
}