<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Se você usa o Sanctum (como está no seu composer), 
        // o Laravel 11 já o configura automaticamente, mas se 
        // tiver middlewares manuais, registre-os aqui.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();