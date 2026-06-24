<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizeWwwHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());

        if (!str_starts_with($host, 'www.')) {
            return $next($request);
        }

        $canonicalBase = rtrim(config('app.url'), '/');
        $path = $request->getRequestUri();

        return redirect()->to($canonicalBase . $path, 301);
    }
}
