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
        'data_inicio', 
        'data_fim', 
        'external_reference', 
        'user_id'
    ];
}
