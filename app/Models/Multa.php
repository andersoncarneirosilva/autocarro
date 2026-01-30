<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class Multa extends Model
{
    use MultiTenantModelTrait;
    
    protected $fillable = [
        'veiculo_id', 'codigo_infracao', 'descricao', 
        'valor', 'data_infracao', 'data_vencimento', 
        'status', 'orgao_emissor', 'observacoes','empresa_id'
    ];

    // Relacionamento: Uma multa pertence a um veículo
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}