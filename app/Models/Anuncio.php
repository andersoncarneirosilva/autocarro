<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    protected $fillable = [
        'marca',
        'modelo',
        'ano',
        'kilometragem',
        'cor',
        'cambio',
        'portas',
        'combustivel',
        'images',
        'observacoes',
        'status',
    ];
}
