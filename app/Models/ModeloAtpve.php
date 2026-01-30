<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class ModeloAtpve extends Model
{
    use MultiTenantModelTrait;
    
    protected $fillable = [
        'user_id',
        'conteudo',
        'cidade',
        'empresa_id'
    ];
}
