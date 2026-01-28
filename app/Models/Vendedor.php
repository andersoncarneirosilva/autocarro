<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vendedor extends Model
{
    // 1. Aponta para a tabela de usuários
    protected $table = 'users';

    // 2. Global Scope: Toda vez que você usar Vendedor::all(), 
    // ele já filtra automaticamente apenas os vendedores.
    protected static function booted()
    {
        static::addGlobalScope('apenasVendedores', function (Builder $builder) {
            $builder->where('nivel_acesso', 'Vendedor');
        });
    }

    protected $fillable = [
        'name', 'email', 'cpf', 'telefone', 'nivel_acesso', 'password', 'status', 'empresa_id'
    ];
}