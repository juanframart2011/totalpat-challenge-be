<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Session\Middleware\StartSession;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Schedule; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // ⬇️  Aquí añadimos StartSession al grupo API
        $middleware->api(prepend: [
            StartSession::class,                         // 👈 habilita la sesión
            EnsureFrontendRequestsAreStateful::class,    // ya lo tenías
            \App\Http\Middleware\ActivityLogger::class,
        ]);

        // Alias personalizados
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'auth.front' => \App\Http\Middleware\EnsureApiToken::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        // ⬇️  Tarea: purgar sesiones cada minuto
        $schedule->command('session:prune')->everyMinute();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
