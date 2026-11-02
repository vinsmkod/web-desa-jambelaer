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
    ->withMiddleware(function (Middleware $middleware): void {
        // Tambahkan Security Headers ke setiap response HTTP
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);

        // Daftarkan route middleware alias
        $middleware->alias([
            'admin.auth'      => \App\Http\Middleware\AdminAuth::class,
            'masyarakat.auth' => \App\Http\Middleware\MasyarakatAuth::class,
            'role'            => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
