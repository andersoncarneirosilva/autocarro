<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Emprestimo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'colaborador',
        'motivo',
        'email',
        'qt_parcela',
        'parcela',
        'total',
        'data_vencimento',
        'class_status',
        'status'
    ];

    public function getCatDoc(string|null $search = null){

        $cat = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('email', $search);
                $query->orWhere('name', 'LIKE', "%{$search}%");
            }
        })->paginate(10);

        return $cat;
    }

    public function getEmprestimos(string|null $search = null){

        $pags = $this->where(function ($query) use ($search) {
            if($search){
                $query->where('colaborador', $search);
                $query->orWhere('email', 'LIKE', "%{$search}%");
            }
        })->paginate(10);
        //dd($users);
        return $pags;
    }

}