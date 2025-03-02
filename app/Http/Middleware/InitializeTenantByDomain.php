<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Facades\Tenancy;

class InitializeTenantByDomain
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // dd($request);
        // Tente identificar o tenant com base no domínio
        try {
            Tenancy::initializeForDomain($request->getHost());
        } catch (\Exception $e) {
            // Se não encontrar o tenant, redireciona ou faz outra ação, dependendo da lógica
            return redirect('/');  // Por exemplo, redireciona para a central se não encontrar o tenant
        }

        return $next($request);
    }
}
