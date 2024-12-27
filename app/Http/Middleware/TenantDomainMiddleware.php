<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TenantDomainMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtém o domínio/subdomínio do host
        $tenantDomain = $request->getHost();

        // Recupera a lista de domínios da configuração
        $centralDomains = config('central_domains.central_domains');

        // Verifica se o domínio está na lista
        if (!in_array($tenantDomain, $centralDomains)) {
            // Se o domínio não estiver na lista, aborta e retorna um erro
            abort(404, 'Não foi possível identificar o locatário no domínio ' . $tenantDomain);
        }

        return $next($request); // Continua a execução da requisição
    }
}
