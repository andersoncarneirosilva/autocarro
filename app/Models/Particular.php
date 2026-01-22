<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Particular extends Model
{
    use HasFactory;

    // Define explicitamente o nome da tabela caso o plural do Laravel falhe
    protected $table = 'particulares';

    protected $fillable = [
        'nome',
        'cpf',
        'fones',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'user_id'
    ];

    protected $casts = [
        'fones' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}