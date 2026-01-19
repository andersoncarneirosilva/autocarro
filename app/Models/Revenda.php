<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'fones',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
    ];

    protected $casts = [
        'fones' => 'array',
    ];
}
