<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'plano',
        'valor',
        'class_status',
        'status',
        'external_reference',

        'data_inicio',
        'data_fim',

        'user_id',
    ];

    
}
