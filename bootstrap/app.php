<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // 1) Register Laravel’s built‑in route middleware aliases as before:
        $middleware->alias([
            // 'auth' => \App\Http\Middleware\Authenticate::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
        // 2) Register your custom “role.selected” middleware with a single‐array call:
        $middleware->alias([
            'role.selected' => \App\Http\Middleware\EnsureRoleSelected::class,
            'menu.access' => \App\Http\Middleware\CheckMenuAccess::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
