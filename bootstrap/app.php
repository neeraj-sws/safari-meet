<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\{AdminMiddleware, CheckUserStatus, EnsureCorrectGuard, RedirectIfAuthenticated, TravelAgentMiddleware};
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'agent' => TravelAgentMiddleware::class,
            'guest' => RedirectIfAuthenticated::class,
            'auth.guard' => EnsureCorrectGuard::class,
            'auth:sanctum' => EnsureFrontendRequestsAreStateful::class,
            'check.status' => CheckUserStatus::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if (!$request->is('api/*')) {
                return redirect()->route('error.landing');
            }

            return response()->json([
                'status' => 404,
                'message' => 'Resource not found',
                'data' => null,
                'code' => 404,
            ], 404);
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
//             Log::info('votesync POST Data:', $request->all());
// Log::info('votesync Request Headers:', $request->headers->all());

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Validation error',
                        'data' => $e->errors(),
                        'code' => 422,
                    ], 422);
                }

                if ($e instanceof AuthenticationException) {
                    // Log::error($e->getMessage(), ['exception' => $e]);

                    return response()->json([
                        'status' =>  401,
                        'message' => 'Unauthenticated',
                        'data' => null,
                        'code' => 401,
                    ], 401);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    'data' => null,
                    'code' => method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                ], method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500);
            }


            if ($e instanceof AuthenticationException) {
                return redirect()->route('login');
            }

            return response()->view('errors.500', [], 500);
        });
    })
    ->create();
