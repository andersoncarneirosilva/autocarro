<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]); // Certifique-se de que a autenticação está correta
        //Broadcast::routes();

        require base_path('routes/channels.php');
    //     Broadcast::routes();

    // Broadcast::channel('chat.{userId}', function ($user, $userId) {
    //     logger('Autenticando usuário para canal privado: ' . $userId);
    //     return (int) $user->id === (int) $userId;
    // });
    }
}
