<?php

use App\Support\UploadLimits;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
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
        $middleware->alias([ 'auth' => \App\Http\Middleware\AuthMiddleware::class, 'guest' => \App\Http\Middleware\GuestMiddleware::class, 'admin' => \App\Http\Middleware\AdminMiddleware::class, ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            $serverMaxKb = UploadLimits::phpMaxKb();
            $serverMaxMb = $serverMaxKb > 0
                ? UploadLimits::formatMbFromKb($serverMaxKb)
                : 'desconocido';

            $message = 'El archivo o formulario excede el limite permitido por el servidor';
            $message .= $serverMaxMb !== 'desconocido' ? " ({$serverMaxMb} MB)." : '.';
            $message .= ' Reduce el tamano del archivo e intenta nuevamente.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                ], 413);
            }

            return back()->withErrors(['upload' => $message])->withInput();
        });
    })->create();

    