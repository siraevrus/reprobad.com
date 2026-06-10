<?php

declare(strict_types=1);

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Product;
use App\Support\DietarySupplementJsonLd;
use App\Support\ProductImageUrl;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class YandexFeedController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('feeds.yandex_yml', 3600, fn () => $this->buildXml());

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    private function buildXml(): string
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $date = now()->format('Y-m-d H:i');

        $complexes = Complex::query()
            ->where('active', 1)
            ->orderBy('sort')
            ->get(['id', 'title', 'alias']);

        $products = Product::query()
            ->where('active', 1)
            ->whereHas('complex', fn ($q) => $q->where('active', 1))
            ->with('complex:id,alias,title')
            ->orderBy('sort')
            ->get();

        $lines = [];
        $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $lines[] = '<yml_catalog date="' . $this->esc($date) . '">';
        $lines[] = '  <shop>';
        $lines[] = '    <name>' . $this->esc('Система РЕПРО') . '</name>';
        $lines[] = '    <company>' . $this->esc('АО «Р-Фарм»') . '</company>';
        $lines[] = '    <url>' . $this->esc($baseUrl) . '</url>';
        $lines[] = '    <categories>';

        foreach ($complexes as $complex) {
            $lines[] = '      <category id="' . (int) $complex->id . '">' . $this->esc(strip_tags((string) $complex->title)) . '</category>';
        }

        $lines[] = '    </categories>';
        $lines[] = '    <offers>';

        foreach ($products as $product) {
            $complex = $product->complex;
            if (! $complex || ! $complex->alias || ! $product->alias) {
                continue;
            }

            $picture = ProductImageUrl::resolve($product);
            if ($picture === null) {
                continue;
            }

            $name = strip_tags((string) ($product->title ?? ''));
            if ($name === '') {
                continue;
            }

            $url = $baseUrl . '/complex/' . rawurlencode((string) $complex->alias) . '#' . rawurlencode((string) $product->alias);
            $description = DietarySupplementJsonLd::resolveDescription($product, $complex);

            $lines[] = '      <offer id="' . (int) $product->id . '" available="true">';
            $lines[] = '        <url>' . $this->esc($url) . '</url>';
            $lines[] = '        <categoryId>' . (int) $complex->id . '</categoryId>';
            $lines[] = '        <picture>' . $this->esc($picture) . '</picture>';
            $lines[] = '        <name>' . $this->esc($name) . '</name>';
            $lines[] = '        <description>' . $this->esc($description) . '</description>';
            $lines[] = '        <vendor>' . $this->esc('АО «Р-Фарм»') . '</vendor>';
            $lines[] = '        <sales_notes>' . $this->esc('Биологически активная добавка к питанию') . '</sales_notes>';
            $lines[] = '      </offer>';
        }

        $lines[] = '    </offers>';
        $lines[] = '  </shop>';
        $lines[] = '</yml_catalog>';

        return implode("\n", $lines) . "\n";
    }

    private function esc(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
