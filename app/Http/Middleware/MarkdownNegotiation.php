<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\HttpFoundation\Response;

class MarkdownNegotiation
{
    /**
     * Конвертирует HTML-ответ в Markdown, когда клиент запрашивает Accept: text/markdown (RFC 7231 + llmstxt.org).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->wantsMarkdown($request)) {
            $response->headers->set('Vary', 'Accept', false);
            return $response;
        }

        $contentType = $response->headers->get('Content-Type', '');
        if (! str_contains($contentType, 'text/html')) {
            return $response;
        }

        $html = $response->getContent();
        if (empty($html)) {
            return $response;
        }

        $markdown = $this->convertToMarkdown($html);

        $tokenCount = (int) ceil(mb_strlen($markdown) / 4);

        $response->setContent($markdown);
        $response->headers->set('Content-Type', 'text/markdown; charset=utf-8');
        $response->headers->set('x-markdown-tokens', (string) $tokenCount);
        $response->headers->set('Vary', 'Accept', false);

        return $response;
    }

    private function wantsMarkdown(Request $request): bool
    {
        $accept = $request->header('Accept', '');

        return str_contains($accept, 'text/markdown');
    }

    private function convertToMarkdown(string $html): string
    {
        $converter = new HtmlConverter([
            'strip_tags'           => true,
            'remove_nodes'         => 'script style nav footer header noscript',
            'header_style'         => 'atx',
            'bold_style'           => '**',
            'italic_style'         => '_',
            'list_item_style'      => '-',
            'hard_break'           => true,
            'preserve_comments'    => false,
        ]);

        return $converter->convert($html);
    }
}
