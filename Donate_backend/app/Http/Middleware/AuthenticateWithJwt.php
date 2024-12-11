<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AuthenticateWithJwt;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register route middleware groups
        $middleware->group('web', [
            SubstituteBindings::class,
        ]);

        $middleware->group('api', [
            SubstituteBindings::class,
            AuthenticateWithJwt::class, // Custom JWT middleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling configuration
    })->create();
