<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait MultiTenantModelTrait 
{
    public static function bootMultiTenantModelTrait()
{
    // Verifique se existe um usuário autenticado ANTES de aplicar o escopo
    if (auth()->check() && auth()->user()->empresa_id) {
        
        static::creating(function ($model) {
            $model->empresa_id = auth()->user()->empresa_id;
        });

        static::addGlobalScope('empresa_id', function (Builder $builder) {
            $builder->where('empresa_id', auth()->user()->empresa_id);
        });
    }
}
}