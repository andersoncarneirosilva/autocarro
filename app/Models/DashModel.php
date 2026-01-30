<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\MultiTenantModelTrait;

class DashModel extends Model
{
    use HasFactory, MultiTenantModelTrait;

    /* public function getUsersDash(){

        //$users = User::count();
        $users = DB::table('users')->where('perfil', 'Administrador')->count();
        return $users;
    } */

    
}
