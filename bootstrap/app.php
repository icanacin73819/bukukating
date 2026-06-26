<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. Daftarkan semua alias middleware Anda
        $middleware->alias([
            'admin'       => \App\Http\Middleware\IsAdmin::class,
            'not-admin'   => \App\Http\Middleware\EnsureNotAdmin::class,
            'user-active' => \App\Http\Middleware\EnsureUserActive::class,
        ]);

        // 2. Jalankan otomatis di grup web (Opsional, baca catatan di bawah)
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureUserActive::class);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();