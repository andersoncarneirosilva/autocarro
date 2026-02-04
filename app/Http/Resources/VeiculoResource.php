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
            
            // --- DOCUMENTOS (A peça que faltava!) ---
            // Isso envia o objeto documentos para o App se ele estiver carregado
            'documentos' => $this->documentos, 

            // --- CAMPOS DE REGISTRO ---
            'renavam' => $this->renavam,
            'chassi' => $this->chassi,
            'motor' => $this->motor,

            'fipe_marca_id'  => $this->fipe_marca_id,
            'fipe_modelo_id' => $this->fipe_modelo_id,
            'fipe_versao_id' => $this->fipe_versao_id,

            'crv' => $this->crv,
            'placa_anterior' => $this->placa_anterior ?? $this->placaAnterior, 
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

            // Decodifica as imagens
            'images' => is_string($this->images) ? json_decode($this->images) : $this->images,
            
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