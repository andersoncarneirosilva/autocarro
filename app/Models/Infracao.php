<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infracao extends Model
{
    // Informe ao Laravel o nome exato da tabela no banco
    protected $table = 'infracoes';

    protected $fillable = [
        'codigo',
        'descricao',
        'gravidade',
        'pontos',
        'valor'
    ];
}