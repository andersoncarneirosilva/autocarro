<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloProcuracao extends Model
{
    protected $table = 'modelo_procuracoes';

    protected $fillable = [
    'user_id',
    'outorgados',
    'conteudo',
    'cidade'
];

    // Converte automaticamente o JSON de IDs em Array e vice-versa
    protected $casts = [
        'outorgados' => 'array'
    ];
}