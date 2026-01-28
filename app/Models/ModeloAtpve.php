<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloAtpve extends Model
{
    protected $fillable = [
        'user_id',
        'conteudo',
        'cidade',
        'empresa_id'
    ];
}
