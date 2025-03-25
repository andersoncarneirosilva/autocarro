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

    Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
        return (int) $user->id === (int) $chatId; // ou qualquer outra lógica de autorização
    });
    }
}
