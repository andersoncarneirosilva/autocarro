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

    public function getCountDocs(){
        $counts = [];
        for ($month = 1; $month <= 12; $month++) {
            $countMonth = DB::table('veiculos')
                            ->whereMonth('created_at', $month)
                            ->count();
            $counts[] = $countMonth;
        }
        return $counts;
    }
    

    public function getCountProcs(){
        $countAd = DB::table('procuracaos')->count();
        return $countAd;
    }
    public function getCountOrdens(){
        $countOrder = DB::table('ordems')->count();
        return $countOrder;
    }
}
