<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTrial
{
    public function handle(Request $request, Closure $next)
{
    $user = Auth::user();
    
    if ($user) {
        // 1. Identifica o dono da empresa (quem detém o plano e a data de início)
        $empresaId = $user->empresa_id ?? $user->id;
        $dono = \App\Models\User::find($empresaId);

        // 2. Só aplica a trava de tempo se o plano for exatamente 'Teste'
        if ($dono && $dono->plano === 'Teste') {
            
            $diasDeTeste = 7;
            $dataExpiracao = $dono->created_at->addDays($diasDeTeste);

            // 3. Verifica se a data atual passou da expiração
            if (now()->gt($dataExpiracao)) {
                
                // 4. Permite apenas rotas essenciais (Logout, Perfil e a página de Aviso)
                // Evita o loop infinito permitindo a própria rota 'assinatura-expirada'
                if (!$request->is('logout') && 
                    !$request->is('perfil*') && 
                    !$request->is('assinatura-expirada*')) {
                    
                    return redirect()->route('assinatura.expirada')
                        ->with('error', 'Seu período de teste de ' . $diasDeTeste . ' dias acabou!');
                }
            }
        }
    }

    return $next($request);
}
}