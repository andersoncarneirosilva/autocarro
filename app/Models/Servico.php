<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Servico extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome_servico',
        'valor_servico',
        'arrecadacao_servico',
        'maodeobra_servico'
    ];

    /*public static function pesquisaStatus($id)
    {
        $data = DB::table('parcelas')
            ->where('emprestimo_id', $id)
            ->where('status', 'PENDENTE')
            ->count();
        
        if($data == 0){
            DB::table('emprestimos')
                ->where('id', $id)
                ->update(['status' => 'PAGO', 'class_status' => 'badge badge-success-lighten']);
        }

        return $data;
    }*/

    
}