<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Постобработка SEO-тегов в HTML-ответе.
 *
 * canonical генерируется в шаблоне через хелпер canonical_url(), но шаблон не знает
 * итоговый HTTP-код. Этот middleware гарантирует жёсткие правила на финальном ответе:
 *
 *  - canonical запрещён на ответах 3xx/4xx/5xx, на noindex-страницах и на
 *    исключённых путях (admin/api/_debugbar) → тег <link rel="canonical"> вырезается;
 *  - для тех же случаев добавляется <meta name="robots" content="noindex, nofollow">
 *    и заголовок X-Robots-Tag.
 */
class SeoMetaTags
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $shouldNoindex = $this->shouldNoindex($request, $response);

        if (! $shouldNoindex) {
            return $response;
        }

        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        if ($this->isHtmlResponse($response)) {
            $this->rewriteHtml($response);
        }

        return $response;
    }

    /**
     * Нужно ли закрывать страницу от индексации (и убирать canonical).
     */
    private function shouldNoindex(Request $request, Response $response): bool
    {
        if (seo_is_noindex() || seo_is_excluded_path($request->path())) {
            return true;
        }

        $status = $response->getStatusCode();

        // Редиректы (3xx) и ошибки (4xx/5xx): canonical/индексация запрещены.
        return $status >= 300;
    }

    private function isHtmlResponse(Response $response): bool
    {
        $contentType = (string) $response->headers->get('Content-Type', '');

        if ($contentType !== '' && ! str_contains(strtolower($contentType), 'text/html')) {
            return false;
        }

        return is_string($response->getContent()) && str_contains($response->getContent(), '</head>');
    }

    private function rewriteHtml(Response $response): void
    {
        $html = $response->getContent();

        if ($html === false || $html === '') {
            return;
        }

        // Убираем любой <link rel="canonical"> (в любом порядке атрибутов).
        $html = preg_replace(
            '#<link\b[^>]*\brel\s*=\s*["\']canonical["\'][^>]*>\s*#i',
            '',
            $html
        ) ?? $html;

        // Добавляем meta robots, если её ещё нет.
        if (! preg_match('#<meta\b[^>]*\bname\s*=\s*["\']robots["\']#i', $html)) {
            $html = preg_replace(
                '#</head>#i',
                '    <meta name="robots" content="noindex, nofollow">' . "\n</head>",
                $html,
                1
            ) ?? $html;
        }

        $response->setContent($html);
    }
}
