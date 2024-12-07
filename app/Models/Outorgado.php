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
    ];


    public function getCountOutorgados(){
        $countOut = DB::table('outorgados')->count();
        //dd($countAd);
        return $countOut;
    }

    

    
}