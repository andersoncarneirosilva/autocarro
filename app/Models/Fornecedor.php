<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Fornecedor extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'representante',
        'telefone',
        'ipi',
        'icms',
        'margem',
        'marcador',
        'valor_pedido_minimo',
        'prazo_faturamento',
        'tipo_frete',
        'transportadora'
    ];

}