<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyTelegramRelaySecret
{
    /**
     * Релей (VPS вне РФ) передаёт Bearer-токен, общий с .env на РЕПРО.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('services.telegram.relay_inbound_secret');
        if (! is_string($expected) || $expected === '') {
            abort(503, 'Relay inbound is not configured');
        }

        $auth = (string) $request->header('Authorization', '');
        $token = str_starts_with($auth, 'Bearer ') ? substr($auth, 7) : '';

        if ($token === '' || ! hash_equals($expected, $token)) {
            abort(403);
        }

        return $next($request);
    }
}
