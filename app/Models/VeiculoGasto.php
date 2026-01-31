<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait; // Importante!

class VeiculoGasto extends Model
{
    use MultiTenantModelTrait;

    protected $table = 'veiculo_gastos';

    protected $fillable = [
        'empresa_id', // Adicionado ao fillable
        'veiculo_id', 
        'descricao', 
        'categoria', 
        'valor', 
        'data_gasto', 
        'fornecedor', 
        'codigo_infracao',
        'pago'
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'veiculo_id');
    }
}