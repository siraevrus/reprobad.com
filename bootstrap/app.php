<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'telegram.relay' => \App\Http\Middleware\VerifyTelegramRelaySecret::class,
        ]);
        $middleware->trustProxies(at: '*');
        // $middleware->append(Authenticate::class);
        $middleware->prepend(\App\Http\Middleware\NormalizeCheckupPathCase::class);
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\StaticCacheHeaders::class);
        $middleware->append(\App\Http\Middleware\DisableCacheForCheckupPage::class);
        $middleware->append(\App\Http\Middleware\AgentDiscoveryHeaders::class);
        $middleware->append(\App\Http\Middleware\MarkdownNegotiation::class);
        $middleware->append(\App\Http\Middleware\SeoMetaTags::class);
        $middleware->validateCsrfTokens();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            $message = 'Сессия истекла. Обновите страницу и войдите снова.';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 419);
            }

            if ($request->is('login') || $request->routeIs('login', 'login.auth')) {
                return redirect()->route('login')->with('error', $message);
            }

            if ($request->is('admin*')) {
                return redirect()->back()->withInput()->with('error', $message);
            }

            return redirect()->route('login')->with('error', $message);
        });
    })->create();
