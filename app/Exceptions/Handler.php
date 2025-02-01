<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

//     public function render($request, Throwable $exception)
// {
//     // Verifica se o erro é 404 (Página Não Encontrada)
//     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
//         return response()->view('errors.404', [], 404);
//     }

//     // Verifica se o erro é 403 (Proibido)
//     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
//         return response()->view('errors.403', [], 403);
//     }

//     // Verifica se o erro é 405 (Método Não Permitido)
//     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
//         return response()->view('errors.405', [], 405);
//     }

//     // Verifica se o erro é 500 (Erro Interno do Servidor)
//     if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $exception->getStatusCode() == 500) {
//         return response()->view('errors.500', [], 500);
//     }

//     // Verifica se o erro é 401 (Não Autorizado)
//     if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
//         return response()->view('errors.401', [], 401);
//     }

//     // Você pode adicionar outras verificações conforme necessário para outros códigos de erro HTTP

//     // Para todos os outros erros, chamamos o método padrão do Laravel para renderizar a página de erro
//     return parent::render($request, $exception);
// }


}
