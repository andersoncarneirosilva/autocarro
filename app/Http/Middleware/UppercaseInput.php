<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UppercaseInput
{
    // Lista de campos que não devem ser convertidos
    protected $exclude = ['email', 'cpf'];

    public function handle(Request $request, Closure $next)
    {
        // Transforma os campos do request em maiúsculas, exceto os da lista de exclusão
        $request->merge(array_map(function ($value, $key) {
            if (in_array($key, $this->exclude)) {
                return $value; // Retorna o valor original se estiver na lista de exclusão
            }

            return is_string($value) ? strtoupper($value) : $value; // Converte para maiúsculas
        }, $request->all(), array_keys($request->all())));

        return $next($request);
    }
}
