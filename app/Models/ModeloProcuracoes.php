<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeloProcuracoes extends Model
{
    use HasFactory;

    protected $table = 'modeloprocuracoes';
  

    protected $fillable = [
        'outorgados',
        'texto_inicial',
        'texto_final',
        'cidade',
        'user_id',
    ];

}
