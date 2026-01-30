<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class ModeloProcuracao extends Model
{
    use MultiTenantModelTrait;

    protected $table = 'modelo_procuracoes';

    protected $fillable = [
    'user_id',
    'outorgados',
    'conteudo',
    'cidade',
    'empresa_id'
];

    // Converte automaticamente o JSON de IDs em Array e vice-versa
    protected $casts = [
        'outorgados' => 'array'
    ];
}