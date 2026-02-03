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
            'valor_compra' => (double) $this->valor_compra,
            'status' => $this->status,
            
            // --- NOVOS CAMPOS DE REGISTRO (SINCRONIZADOS COM O APP) ---
            'renavam' => $this->renavam,
            'chassi' => $this->chassi,
            'motor' => $this->motor,
            'crv' => $this->crv,
            'placa_anterior' => $this->placaAnterior, // Laravel costuma usar camelCase, mas o App espera placa_anterior
            'tipo' => $this->tipo,
            'categoria' => $this->categoria,
            'combustivel' => $this->combustivel,
            'potencia' => $this->potencia,
            'cilindrada' => $this->cilindrada,
            'peso_bruto' => $this->peso_bruto,
            'carroceria' => $this->carroceria,
            'infos' => $this->infos,

            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'cidade' => $this->cidade,
            // ---------------------------------------------------------

            // Decodifica as imagens se for um JSON string no banco
            'images' => is_string($this->images) ? json_decode($this->images) : $this->images,
            
            // Mantendo o objeto detalhes para compatibilidade
            'detalhes' => [
                'combustivel' => $this->combustivel,
                'potencia' => $this->potencia,
                'portas' => $this->portas,
                'cilindrada' => $this->cilindrada,
            ],
            
            'data_cadastro' => $this->created_at ? $this->created_at->format('d/m/Y') : null,
        ];
    }
}