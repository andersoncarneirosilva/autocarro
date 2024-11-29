<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pedido extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fornecedor',
        'numero_ordem',
        'arquivo',
        'prazo_entrega',
        'status',
        'numero_nota',
        'data_emissao',
        'valor_nota',
        'vencimentos'
    ];

}