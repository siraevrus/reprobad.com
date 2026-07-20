<?php

declare(strict_types=1);

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Advise;
use App\Models\Article;
use App\Support\DataUriImageMaterializer;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class RssFeedController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('feeds.rss', 3600, fn () => $this->buildXml());

        return response($xml, 200, [
            'Content-Type' => 'application/rss+xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function buildXml(): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $feedUrl = $baseUrl . '/feeds/rss.xml';
        $channelTitle = 'Система РЕПРО';
        $channelDescription = 'Статьи и полезные советы о совместной подготовке к беременности и репродуктивному здоровью';
        $items = $this->collectItems($baseUrl);

        $lastBuild = $items->isNotEmpty()
            ? $items->first()['pubDateCarbon']->copy()->utc()
            : now()->utc();

        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<rss version="2.0"';
        $lines[] = '	xmlns:content="http://purl.org/rss/1.0/modules/content/"';
        $lines[] = '	xmlns:dc="http://purl.org/dc/elements/1.1/"';
        $lines[] = '	xmlns:atom="http://www.w3.org/2005/Atom"';
        $lines[] = '	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"';
        $lines[] = '	>';
        $lines[] = '';
        $lines[] = '<channel>';
        $lines[] = '	<title>' . $this->esc($channelTitle) . '</title>';
        $lines[] = '	<atom:link href="' . $this->esc($feedUrl) . '" rel="self" type="application/rss+xml" />';
        $lines[] = '	<link>' . $this->esc($baseUrl) . '</link>';
        $lines[] = '	<description>' . $this->esc($channelDescription) . '</description>';
        $lines[] = '	<lastBuildDate>' . $this->esc($lastBuild->format(DATE_RSS)) . '</lastBuildDate>';
        $lines[] = '	<language>ru-RU</language>';
        $lines[] = '	<sy:updatePeriod>hourly</sy:updatePeriod>';
        $lines[] = '	<sy:updateFrequency>1</sy:updateFrequency>';
        $lines[] = '	<generator>Laravel</generator>';
        $lines[] = '';
        $lines[] = '<image>';
        $lines[] = '	<url>' . $this->esc($baseUrl . '/images/lgog-gold.svg') . '</url>';
        $lines[] = '	<title>' . $this->esc($channelTitle) . '</title>';
        $lines[] = '	<link>' . $this->esc($baseUrl) . '</link>';
        $lines[] = '</image>';

        foreach ($items as $item) {
            $lines[] = '	<item>';
            $lines[] = '		<title>' . $this->esc($item['title']) . '</title>';
            $lines[] = '		<link>' . $this->esc($item['link']) . '</link>';
            $lines[] = '		';
            $lines[] = '		<dc:creator><![CDATA[' . $this->cdata($item['creator']) . ']]></dc:creator>';
            $lines[] = '		<pubDate>' . $this->esc($item['pubDate']) . '</pubDate>';

            foreach ($item['categories'] as $category) {
                $lines[] = '				<category><![CDATA[' . $this->cdata($category) . ']]></category>';
            }

            $lines[] = '		<guid isPermaLink="false">' . $this->esc($item['guid']) . '</guid>';
            if ($item['image'] !== null && $item['image'] !== '') {
                $lines[] = '		<image><![CDATA[' . $this->cdata($item['image']) . ']]></image>';
            }
            $lines[] = '';
            $lines[] = '					<description><![CDATA[' . $item['description'] . ']]></description>';
            $lines[] = '		<content:encoded><![CDATA[' . $item['content'] . ']]></content:encoded>';
            $lines[] = '		';
            $lines[] = '		';
            $lines[] = '			</item>';
        }

        $lines[] = '	</channel>';
        $lines[] = '</rss>';

        return implode("\n", $lines) . "\n";
    }

    /**
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     creator: string,
     *     pubDate: string,
     *     pubDateCarbon: Carbon,
     *     categories: list<string>,
     *     guid: string,
     *     description: string,
     *     content: string,
     *     image: string|null
     * }>
     */
    private function collectItems(string $baseUrl): Collection
    {
        $articles = Article::query()
            ->active()
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'alias', 'description', 'content', 'category', 'image', 'created_at'])
            ->map(function (Article $article) use ($baseUrl) {
                $link = $baseUrl . '/articles/' . rawurlencode((string) $article->alias);
                $title = $this->plainText((string) $article->title);
                $body = (string) ($article->content ?: $article->description);
                $excerpt = $this->excerptHtml(
                    (string) ($article->description ?: $article->content),
                    $title,
                    $link,
                    'Система РЕПРО'
                );

                return [
                    'title' => $title,
                    'link' => $link,
                    'creator' => 'Система РЕПРО',
                    'pubDateCarbon' => $article->created_at ?? now(),
                    'pubDate' => ($article->created_at ?? now())->copy()->utc()->format(DATE_RSS),
                    'categories' => $this->categories('Статьи', $article->category),
                    'guid' => $baseUrl . '/?article=' . (int) $article->id,
                    'description' => $excerpt,
                    'content' => $this->cdataSafe($body),
                    'image' => $this->resolveImageUrl($baseUrl, $article->image, 'articles', (int) $article->id),
                ];
            });

        $advises = Advise::query()
            ->active()
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'alias', 'description', 'content', 'category', 'image', 'created_at'])
            ->map(function (Advise $advise) use ($baseUrl) {
                $link = $baseUrl . '/usefully-tips/' . rawurlencode((string) $advise->alias);
                $title = $this->plainText((string) $advise->title);
                $body = (string) ($advise->content ?: $advise->description);
                $excerpt = $this->excerptHtml(
                    (string) ($advise->description ?: $advise->content),
                    $title,
                    $link,
                    'Система РЕПРО'
                );

                return [
                    'title' => $title,
                    'link' => $link,
                    'creator' => 'Система РЕПРО',
                    'pubDateCarbon' => $advise->created_at ?? now(),
                    'pubDate' => ($advise->created_at ?? now())->copy()->utc()->format(DATE_RSS),
                    'categories' => $this->categories('Советы', $advise->category),
                    'guid' => $baseUrl . '/?advise=' . (int) $advise->id,
                    'description' => $excerpt,
                    'content' => $this->cdataSafe($body),
                    'image' => $this->resolveImageUrl($baseUrl, $advise->image, 'advises', (int) $advise->id),
                ];
            });

        return $articles
            ->concat($advises)
            ->sortByDesc(fn (array $item) => $item['pubDateCarbon']->timestamp)
            ->values();
    }

    /**
     * @return list<string>
     */
    private function categories(string $type, ?string $category): array
    {
        $categories = [$type];
        $category = trim((string) $category);

        if ($category !== '') {
            $categories[] = $this->plainText($category);
        }

        return $categories;
    }

    private function excerptHtml(string $html, string $title, string $link, string $siteName): string
    {
        $plain = $this->plainText($html);
        $plain = Str::limit($plain, 280, ' […]');

        $body = $plain !== ''
            ? '<p>' . $this->esc($plain) . '</p>'
            : '';

        $footer = '<p>The post <a href="' . $this->esc($link) . '">' . $this->esc($title)
            . '</a> first appeared on <a href="' . $this->esc(rtrim((string) config('app.url'), '/')) . '">'
            . $this->esc($siteName) . '</a>.</p>';

        return $this->cdataSafe($body . $footer);
    }

    private function resolveImageUrl(string $baseUrl, mixed $image, string $folder, int $id): ?string
    {
        $image = trim((string) $image);
        if ($image === '') {
            return null;
        }

        if (str_starts_with($image, 'data:')) {
            $path = app(DataUriImageMaterializer::class)->materialize($image, $folder, $id);
            if ($path === null) {
                return null;
            }
            $image = $path;
        }

        if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
            return $image;
        }

        if (str_starts_with($image, '//')) {
            return 'https:' . $image;
        }

        return $baseUrl . '/' . ltrim($image, '/');
    }

    private function plainText(string $value): string
    {
        $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $value = preg_replace('/\s+/u', ' ', $value) ?? $value;

        return trim($value);
    }

    private function cdataSafe(string $value): string
    {
        return str_replace(']]>', ']]]]><![CDATA[>', $value);
    }

    private function cdata(string $value): string
    {
        return $this->cdataSafe($value);
    }

    private function esc(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
