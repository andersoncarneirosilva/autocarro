<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pagamento extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'colaborador',
        'email',
        'arquivo',
        'status',
        'mes',
        'numeromes',
        'class_status',
        'foto',
    ];

    public function getPagamentos(string|null $colaborador = null, string|null $mes = null, string|null $status = null){
        $pags = $this->where(function ($query) use ($colaborador, $mes, $status) {
            if($colaborador){
                $query->where('colaborador', $colaborador);
            }
            if($mes){
                $query->where('mes', $mes);
            }
            if($status){
                $query->where('status', $status);
            }
        })->paginate(10);
        return $pags;
    }

    public function extrairNomeUsuario($textoPagina){
        // Suposição: O nome do usuário está precedido pela palavra "Nome:" ou "Nome do usuário:"
        $padroes = ['/Nome\s*(\w+)/', '/Nome do funcionário:\s*(\w+)/'];
    
        foreach ($padroes as $padrao) {
            if (preg_match($padrao, $textoPagina, $matches)) {
                // O nome do usuário foi encontrado
                return $matches[1];
            }
        }
    
        // Caso nenhum nome de usuário seja encontrado
        return '';
    }
    
    public function extrairEmailUsuario($nomeUsuario){
    
        $emailUsuario = User::where('name', $nomeUsuario)->pluck('email')->first();
    
        return $emailUsuario;
    }
    
    public function extrairFotoUsuario($nomeUsuario){
    
        $fotoUsuario = User::where('name', $nomeUsuario)->pluck('image')->first();
    
        return $fotoUsuario;
    }

}
