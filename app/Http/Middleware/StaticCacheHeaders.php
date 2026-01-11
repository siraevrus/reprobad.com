<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        $uri = $request->getRequestUri();
        
        // Изображения - кэш на 1 год
        if (preg_match('/\.(jpg|jpeg|png|gif|webp|avif|svg|ico)$/i', $uri)) {
            return $response->header('Cache-Control', 'public, max-age=31536000, immutable');
        }
        
        // CSS и JavaScript - кэш на 1 месяц
        if (preg_match('/\.(css|js)$/i', $uri)) {
            return $response->header('Cache-Control', 'public, max-age=2592000');
        }
        
        // Шрифты - кэш на 1 год
        if (preg_match('/\.(ttf|otf|woff|woff2|eot)$/i', $uri)) {
            return $response->header('Cache-Control', 'public, max-age=31536000, immutable');
        }
        
        // Lottie файлы - кэш на 1 месяц
        if (preg_match('/\.(lottie|json)$/i', $uri)) {
            return $response->header('Cache-Control', 'public, max-age=2592000');
        }
        
        return $response;
    }
}
