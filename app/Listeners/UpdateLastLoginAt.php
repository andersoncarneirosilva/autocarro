<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class UpdateLastLoginAt
{
    /**
     * Trata o evento de login.
     */
    public function handle(Login $event): void
    {
        // O $event->user contém o objeto do usuário que acabou de logar
        $event->user->update([
            'last_login_at' => Carbon::now()
        ]);
    }
}