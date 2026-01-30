<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantModelTrait;

class ModeloComunicacao extends Model
{
    use HasFactory, MultiTenantModelTrait;

    protected $fillable = [
        'user_id',
        'outorgados',
        'conteudo',
        'cidade',
        'empresa_id'
    ];

    // Importante para o Alcecar tratar o JSON como array automaticamente
    protected $casts = [
        'outorgados' => 'array'
    ];
}