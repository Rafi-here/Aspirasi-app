<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsSiswa;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'is_admin' => IsAdmin::class,
            'is_siswa' => IsSiswa::class,
        ]);

        // Middleware groups (opsional, untuk grouping)
        //$middleware->group('web', [
        //    \App\Http\Middleware\EncryptCookies::class,
        //    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        //    \Illuminate\Session\Middleware\StartSession::class,
        //    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //    \App\Http\Middleware\VerifyCsrfToken::class,
        //    \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //]);

        //$middleware->group('api', [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        //    \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
        //    \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
