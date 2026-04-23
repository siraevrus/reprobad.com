<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(Authenticate::class);
        $middleware->append(\App\Http\Middleware\StaticCacheHeaders::class);
        $middleware->append(\App\Http\Middleware\DisableCacheForCheckupPage::class);
        $middleware->append(\App\Http\Middleware\AgentDiscoveryHeaders::class);
        $middleware->append(\App\Http\Middleware\MarkdownNegotiation::class);
        $middleware->validateCsrfTokens(except: [
            '/bot/ask',
            '/bot/clear-history',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
