<?php

use App\Exceptions\RequestException;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Responses\ExceptionResponse;
use App\Jobs\FetchLastComments;
use App\Jobs\UpdateFilms;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schedule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'role' => EnsureUserHasRole::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return new ExceptionResponse($e, 'Запрос требует аутентификации.', 401);
//                return response()->json([
//                    'message' => 'Запрос требует аутентификации.'
//                ], 401);
            }
        })->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return new ExceptionResponse($e, 'Страница не найдена.', 404);
            }
        })->render(function (RequestException $e, Request $request) {
            if ($request->expectsJson()) {
                return new ExceptionResponse($e);
            }
        })/*->render(using: function (Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return new ExceptionResponse($e, null);
            }
        })*/;
    })->create();
