<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profissional extends Model
{
    protected $table = 'profissionais';

    protected $fillable = [
        'foto', 'nome', 'documento', 'telefone', 'email', 
        'data_nascimento', 'genero', 'cor_agenda', 'especialidade',
        'nive_acesso', 'status', 'password', 
        'servicos', 'horarios', 'user_id', 'empresa_id'
    ];

    protected $casts = [
        'servicos' => 'array',
        'horarios' => 'array',
        'nive_acesso' => 'boolean',
        'status' => 'boolean',
    ];

    protected $hidden = ['password'];

    /**
     * Relacionamento: O funcionário pertence a uma empresa (User).
     */
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'empresa_id');
    }
}