<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure; // Importe o Closure
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards)
{
    // Obter o domínio da requisição (exemplo: tenant1.localhost)
    $tenantDomain = $request->getHost(); // Obtém o domínio completo

    // Se você precisar apenas do nome do domínio sem o "www", você pode usar algo como:
    $tenantDomain = explode('.', $tenantDomain)[0]; // Extrai o subdomínio

    // Definir o cookie dinamicamente com base no domínio do tenant
    config(['session.cookie' => $tenantDomain . '_session']);

    return parent::handle($request, $next, ...$guards);
}
}
