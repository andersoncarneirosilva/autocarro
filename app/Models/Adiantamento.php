<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Adiantamento extends Model
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
        
        $linhas = explode("\n", $textoPagina);
                //dd($linhas);
                $colunas = explode("\t", $linhas[4]);
                
                
                $nomeUsuario = $colunas[1];
                //dd($textoPagina, $colunas, $nomeUsuario);
                //dd($nomeUsuario);
        // Caso nenhum nome de usuário seja encontrado
        return $nomeUsuario ;
    }
    
    

    public function extrairEmailUsuario($nomeUsuario){
        //dd($nomeUsuario);
        $emailUsuario = Employee::where('name', $nomeUsuario)->pluck('email')->first();
        //dd($emailUsuario);
        return $emailUsuario;
    }
    
    public function extrairFotoUsuario($nomeUsuario){
        //dd($nomeUsuario);
        $fotoUsuario = Employee::where('name', $nomeUsuario)->pluck('image')->first();
        //dd($fotoUsuario);
        return $fotoUsuario;
    }
}
