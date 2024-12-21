<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UppercaseInput
{
    public function handle(Request $request, Closure $next)
    {
        // Transforma todos os campos do request para maiúsculas
        $request->merge(array_map(function ($value) {
            return is_string($value) ? strtoupper($value) : $value;
        }, $request->all()));

        return $next($request);
    }
}
