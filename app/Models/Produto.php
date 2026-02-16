<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait; // Importante

class Produto extends Model
{
    use MultiTenantModelTrait; // O "mágica" acontece aqui

    protected $table = 'produtos';

    protected $fillable = [
        'empresa_id', // O Trait vai preencher via boot
        'nome', 
        'codigo_barras', 
        'marca', 
        'preco_custo', 
        'preco_venda', 
        'estoque_atual', 
        'estoque_minimo', 
        'categoria'
    ];
}