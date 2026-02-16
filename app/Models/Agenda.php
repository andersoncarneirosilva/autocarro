<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MultiTenantModelTrait;

class Agenda extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    protected $table = 'agendas'; // Garante o plural correto

    protected $fillable = [
        'empresa_id',
        'profissional_id',
        'cliente_nome',
        'cliente_telefone',
        'servicos_json',
        'data_hora_inicio',
        'data_hora_fim',
        'pedido_especial',
        'valor_total',
        'status'
    ];

    protected $casts = [
        'servicos_json' => 'array',
        'data_hora_inicio' => 'datetime',
        'data_hora_fim' => 'datetime',
        'valor_total' => 'decimal:2'
    ];

    public function profissional()
{
    return $this->belongsTo(Profissional::class, 'profissional_id');
}

// app/Models/Agenda.php

public function cliente()
{
    // Verifique se a coluna na tabela agenda é cliente_id
    return $this->belongsTo(Cliente::class, 'cliente_id');
}
}