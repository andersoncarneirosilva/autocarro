<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Definindo a política de acesso
        Gate::define('access-admin', function (User $user) {
            // dd($user);
            return $user->nivel_acesso == 'Administrador';
        });

        Gate::define('access-user', function (User $user) {
            // dd($user);
            return $user->nivel_acesso == 'Usuário';
        });

        Gate::define('access-produto', function (User $user) {
            // dd($user);
            return $user->nivel_acesso == 'Produto';
        });

        Gate::define('access-lojista', function (User $user) {
            // dd($user);
            return $user->perfil == 'Lojista';
        });

        Gate::define('access-despachante', function (User $user) {
            // dd($user);
            return $user->perfil == 'Despachante';
        });
    }
}
