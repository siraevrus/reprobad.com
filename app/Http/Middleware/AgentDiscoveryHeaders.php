<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgentDiscoveryHeaders
{
    /**
     * Link-заголовки для обнаружения ресурсов агентами (RFC 8288).
     * Применяются только к главной странице.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->routeIs('site.index')) {
            return $response;
        }

        $links = [
            '</sitemap.xml>; rel="sitemap"',
            '</robots.txt>; rel="robots.txt"',
            '</faq>; rel="help"',
            '</articles>; rel="collection"',
        ];

        $response->headers->set('Link', implode(', ', $links));

        return $response;
    }
}
