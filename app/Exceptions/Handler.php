<?php
// app/Exceptions/Handler.php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Log errors in production
            if (config('app.env') === 'production') {
                \Log::error('Production Error: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }

    public function render($request, Throwable $exception)
    {
        // Handle 404 errors gracefully in production
        if ($exception instanceof NotFoundHttpException && config('app.env') === 'production') {
            return response()->view('errors.404', [], 404);
        }

        return parent::render($request, $exception);
    }
}
