<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Adiantamento;
use Carbon\Carbon;

class DashModel extends Model
{
    use HasFactory;

    /* public function getUsersDash(){

        //$users = User::count();
        $users = DB::table('users')->where('perfil', 'Administrador')->count();
        return $users;
    } */

    public function getCountAdDash(){

        //$countAd = Adiantamento::count();
        $mytime = date('m');
        //dd("DATA - " . $mytime);
        $countAd = DB::table('adiantamentos')->where('numeromes', $mytime)->count();
        return $countAd;
    }
}
