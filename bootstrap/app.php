<?php

use App\Exceptions\NotFoundHttpHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // GLOBAL
        $exceptions->context(fn () => [
            'url'        => request()->fullUrl(),
            'method'     => request()->method(),
            'ip'         => request()->ip(),
            'user_agent' => request()->userAgent(),
            'input'      => request()->except(['current_password', 'password', 'password_confirmation', 'token']),
        ]);

        NotFoundHttpHandler::register($exceptions);
    })->create();
