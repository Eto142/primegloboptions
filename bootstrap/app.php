<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
            // 👇 Add this line for admin routes
        then: function ($router) {
            require __DIR__.'/../routes/admin.php';
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        
          $middleware->alias([
            'user' => \App\Http\Middleware\UserMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |------------------------------------------------------------------
        | Custom Error Rendering
        |------------------------------------------------------------------
        | Render user-friendly error pages for web requests and clean JSON
        | responses for API/AJAX requests. Sensitive details (stack traces,
        | SQL queries, file paths) are NEVER exposed to the client — they
        | are logged server-side via Laravel's logging channels instead.
        |------------------------------------------------------------------
        */

        $exceptions->render(function (Throwable $e, Request $request) {

            // --- Determine the HTTP status code ---
            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : 500;

            // --- API / AJAX: return clean JSON ---
            if ($request->expectsJson() || $request->is('api/*')) {
                $messages = [
                    403 => 'Access denied.',
                    404 => 'The requested resource was not found.',
                    419 => 'Your session has expired. Please refresh and try again.',
                    429 => 'Too many requests. Please slow down.',
                    500 => 'An internal server error occurred.',
                    503 => 'Service temporarily unavailable. Please try again later.',
                ];

                return response()->json([
                    'error'   => true,
                    'message' => $messages[$status] ?? 'An unexpected error occurred.',
                    'status'  => $status,
                ], $status);
            }

            // --- Web: render the custom Blade error view ---
            $supported = [403, 404, 419, 429, 500, 503];

            if (in_array($status, $supported) && view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [
                    'exception' => $e,
                ], $status);
            }

            // For any other HTTP error that has a matching view, render it
            if ($e instanceof HttpExceptionInterface && view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [
                    'exception' => $e,
                ], $status);
            }

            // Fallback: for non-HTTP exceptions in production, show the 500 page
            if (! app()->hasDebugModeEnabled() && ! $e instanceof HttpExceptionInterface) {
                if (view()->exists('errors.500')) {
                    return response()->view('errors.500', [
                        'exception' => $e,
                    ], 500);
                }
            }
        });

        /*
        |------------------------------------------------------------------
        | Sensitive Data Protection
        |------------------------------------------------------------------
        | Never report certain internal details in any context. All
        | exceptions are still logged via the configured LOG_CHANNEL.
        |------------------------------------------------------------------
        */

        // Ensure internal exceptions are never shown to clients but stay logged
        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
        ]);

    })->create();
