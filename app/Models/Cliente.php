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
    ];

    public function getClientes(?string $search, $userId)
    {
        return $this->where('user_id', $userId) // Filtro pelo usuário logado
            ->when($search, function ($query) use ($search) {
                // Se houver pesquisa, filtra por nome ou CPF
                $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('cpf', 'LIKE', "%{$search}%");
            })
            ->paginate(10); // Retorna os resultados paginados
    }

    public function ordens()
    {
        return $this->hasMany(Ordem::class);
    }
}
