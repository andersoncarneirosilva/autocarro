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
        'end_outorgado',
        'email_outorgado',
        'user_id',
    ];

    public function getSearch(?string $search, $userId)
    {
        return $this->where('user_id', $userId) // Filtro pelo usuário logado
            ->when($search, function ($query) use ($search) {
                // Se houver pesquisa, filtra por renavam ou placa
                $query->where('nome', 'LIKE', "%{$search}%")
                    ->orWhere('cpf', 'LIKE', "%{$search}%");
            })
            ->paginate(10); // Retorna os resultados paginados
    }
}
