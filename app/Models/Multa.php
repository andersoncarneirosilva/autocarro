<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Multa extends Model
{
    protected $fillable = [
        'veiculo_id', 'codigo_infracao', 'descricao', 
        'valor', 'data_infracao', 'data_vencimento', 
        'status', 'orgao_emissor', 'observacoes'
    ];

    // Relacionamento: Uma multa pertence a um veículo
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}