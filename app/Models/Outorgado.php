<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Outorgado extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_outorgado',
        'cpf_outorgado',
        'rg_outorgado',
        'end_outorgado',
        'telefone_outorgado',
        'email_outorgado',
        'user_id',
        'empresa_id'
    ];

    public function getSearch($search, $empresaId) {
    return $this->where('empresa_id', $empresaId)
                ->where('nome_outorgado', 'LIKE', "%{$search}%")
                ->paginate(10);
}
}
