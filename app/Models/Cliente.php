<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'cpf',
        'rg',
        'fone',
        'email',
        'cep',
        'endereco',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'complemento',
        'user_id',
        'empresa_id'
    ];

    public function getClientes(string $search = null, $empresaId) 
{
    $clientes = $this->where(function ($query) use ($search, $empresaId) {
        // MUDANÇA AQUI: Filtra pela empresa
        $query->where('empresa_id', $empresaId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                  ->orWhere('cpf', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }
    })
    ->orderBy('nome', 'asc')
    ->paginate(10);

    return $clientes;
}

}
