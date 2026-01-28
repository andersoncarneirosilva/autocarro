<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Configuracao extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'endereco',
        'cpf',
        'marca',
        'placa',
        'chassi',
        'cor',
        'ano',
        'modelo',
        'renavam',
        'arquivo_doc',
        'arquivo_proc',
        'empresa_id'
    ];
}
