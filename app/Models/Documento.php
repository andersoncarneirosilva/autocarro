<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Documento extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'colaborador',
        'documento',
        'subdocumento',
        'arquivo',
    ];

    public function getDocumentos(string|null $colaborador = null, string|null $documento = null){
        $pags = $this->where(function ($query) use ($colaborador, $documento) {
            if($colaborador){
                $query->where('colaborador', $colaborador);
            }
            if($documento){
                $query->where('documento', $documento);
            }
        })->paginate(10);
        return $pags;
    }

    
}
