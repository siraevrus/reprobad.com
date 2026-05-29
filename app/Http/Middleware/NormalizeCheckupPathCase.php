<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NormalizeCheckupPathCase
{
    /**
     * Канонический URL теста — /checkup (нижний регистр). Варианты вроде /Checkup → 301/308.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->getPathInfo();

        if (! preg_match('#^/checkup(?:/|$)#i', $path)) {
            return $next($request);
        }

        $canonicalPath = strtolower($path);

        if ($path === $canonicalPath) {
            return $next($request);
        }

        $url = $canonicalPath;
        if ($query = $request->getQueryString()) {
            $url .= '?'.$query;
        }

        $status = in_array($request->method(), ['GET', 'HEAD'], true) ? 301 : 308;

        return redirect()->to($url, $status);
    }
}
