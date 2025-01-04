<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Método para retornar as notificações de um usuário autenticado
    public function getNotifications()
    {
        $notifications = Auth::user()->notifications; // Recupera as notificações do usuário autenticado

        return response()->json($notifications);
    }
}
