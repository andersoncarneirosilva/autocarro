<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Método para retornar as notificações de um usuário autenticado
    public function getNotifications()
    {
        $notifications = Auth::user()->notifications()->take(10)->get();

        return response()->json($notifications);
    }
}
