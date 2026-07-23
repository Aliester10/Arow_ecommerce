<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        Laravel\Sanctum\SanctumServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\SetLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, \Illuminate\Http\Request $request) {
            return redirect()->back()->with('error', 'Ukuran total file (gambar) yang Anda unggah terlalu besar (lebih dari batas maksimal server 8MB). Silakan perkecil ukuran gambar Anda, atau kurangi jumlah gambar yang diunggah sekaligus.');
        });
    })->create();
