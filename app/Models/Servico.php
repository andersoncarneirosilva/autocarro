<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\MultiTenantModelTrait; // Importação da sua Trait

class Servico extends Model
{
    use HasFactory, SoftDeletes, MultiTenantModelTrait; // Ativação do Multi-tenancy

    protected $table = 'servicos';

    protected $fillable = [
        'nome',
        'preco',
        'duracao',
        'descricao',
        'empresa_id',
        'status',
        'image'
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'duracao' => 'integer',
        'status' => 'boolean',
    ];

    // Acessor para facilitar a exibição no padrão brasileiro
    public function getPrecoFormatadoAttribute()
    {
        return number_format($this->preco, 2, ',', '.');
    }

    public function empresa()
{
    return $this->belongsTo(Empresa::class);
}
}