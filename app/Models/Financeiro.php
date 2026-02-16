<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financeiro extends Model
{
    protected $table = 'financeiros';

    
    protected $fillable = [
    'empresa_id', 
    'agendamento_id', 
    'profissional_id', 
    'descricao', 
    'valor', 
    'comissao_valor', 
    'tipo', 
    'forma_pagamento', 
    'data_pagamento',
    'observacoes'
];

// Cast para garantir que a data seja tratada como objeto Carbon
protected $casts = [
    'data_pagamento' => 'date',
];

public function agendamento()
{
    // Especificamos 'agendamento_id' como a FK e apontamos para o Model Agenda
    return $this->belongsTo(Agenda::class, 'agendamento_id');
}

public function profissional()
{
    return $this->belongsTo(Profissional::class, 'profissional_id');
}

}
