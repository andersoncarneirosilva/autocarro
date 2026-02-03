<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait MultiTenantModelTrait 
{
    public static function bootMultiTenantModelTrait()
    {
        if (auth()->check()) {
            // 1. Antes de criar, injeta o empresa_id do usuário logado
            static::creating(function ($model) {
                $model->empresa_id = auth()->user()->empresa_id;
            });

            // 2. Em qualquer consulta (Select), filtra pela empresa do usuário
            static::addGlobalScope('empresa_id', function (Builder $builder) {
                $builder->where('empresa_id', auth()->user()->empresa_id);
            });
        }
    }
}