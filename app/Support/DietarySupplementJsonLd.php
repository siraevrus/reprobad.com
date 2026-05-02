<?php

namespace App\Support;

use App\Models\Complex;
use App\Models\Product;
use Illuminate\Support\Str;

/**
 * Описания и URL предложений для JSON-LD Product / DietarySupplement (Система РЕПРО).
 */
final class DietarySupplementJsonLd
{
    public static function resolveDescription(Product $product, Complex $complex): string
    {
        $titleLc = self::normalizedTitle($product);

        $alias = mb_strtolower(trim((string) ($product->alias ?? '')), 'UTF-8');
        $byAlias = config('dietary_supplement_schema.descriptions_by_product_alias', []);
        if ($alias !== '' && isset($byAlias[$alias])) {
            $t = trim((string) $byAlias[$alias]);

            return $t !== '' ? $t : self::fallbackDescriptionFromContent($product, $complex);
        }

        $calias = trim((string) ($complex->alias ?? ''));
        if ($calias !== '' && $alias !== '') {
            $composite = $calias.'|'.$alias;
            $byComposite = config('dietary_supplement_schema.descriptions_by_complex_product_alias', []);
            if (isset($byComposite[$composite])) {
                $t = trim((string) $byComposite[$composite]);

                return $t !== '' ? $t : self::fallbackDescriptionFromContent($product, $complex);
            }
        }

        foreach (config('dietary_supplement_schema.product_descriptions', []) as $row) {
            if (empty($row['keywords']) || empty($row['description'])) {
                continue;
            }
            $ok = true;
            foreach ($row['keywords'] as $kw) {
                if (! str_contains($titleLc, mb_strtolower((string) $kw, 'UTF-8'))) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) {
                return trim((string) $row['description']);
            }
        }

        foreach (config('dietary_supplement_schema.unique_markers', []) as $row) {
            if (empty($row['markers']) || empty($row['description'])) {
                continue;
            }
            $markers = $row['markers'];
            usort($markers, static fn ($a, $b) => mb_strlen((string) $b, 'UTF-8') <=> mb_strlen((string) $a, 'UTF-8'));
            foreach ($markers as $m) {
                $ml = mb_strtolower(trim((string) $m), 'UTF-8');
                if ($ml !== '' && str_contains($titleLc, $ml)) {
                    return trim((string) $row['description']);
                }
            }
        }

        return self::fallbackDescriptionFromContent($product, $complex);
    }

    public static function resolveOfferUrl(Product $product): string
    {
        $titleLc = self::normalizedTitle($product);

        foreach (config('dietary_supplement_schema.unique_offer_markers', []) as $row) {
            if (empty($row['markers']) || empty($row['url'])) {
                continue;
            }
            $markers = $row['markers'];
            usort($markers, static fn ($a, $b) => mb_strlen((string) $b, 'UTF-8') <=> mb_strlen((string) $a, 'UTF-8'));
            foreach ($markers as $m) {
                $ml = mb_strtolower(trim((string) $m), 'UTF-8');
                if ($ml !== '' && str_contains($titleLc, $ml)) {
                    return trim((string) $row['url']);
                }
            }
        }

        foreach (config('dietary_supplement_schema.product_offer_urls', []) as $row) {
            if (empty($row['keywords']) || empty($row['url'])) {
                continue;
            }
            $ok = true;
            foreach ($row['keywords'] as $kw) {
                if (! str_contains($titleLc, mb_strtolower((string) $kw, 'UTF-8'))) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) {
                return trim((string) $row['url']);
            }
        }

        $link = trim((string) ($product->link ?? ''));
        if ($link !== '') {
            return $link;
        }

        return 'https://www.eapteka.ru/search/?q='.rawurlencode(strip_tags((string) $product->title));
    }

    private static function normalizedTitle(Product $product): string
    {
        $t = trim(preg_replace('/\s+/u', ' ', strip_tags((string) ($product->title ?? ''))));

        return mb_strtolower($t, 'UTF-8');
    }

    private static function plainText(?string $html): string
    {
        return trim(preg_replace('/\s+/u', ' ', strip_tags((string) $html)));
    }

    private static function takeSentencesRu(?string $text, int $maxSentences = 4): string
    {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $text)));
        if ($text === '') {
            return '';
        }
        $parts = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (count($parts) === 0) {
            return Str::limit($text, 520);
        }
        $count = count($parts);
        $n = min($maxSentences, $count);
        if ($count >= 2) {
            $n = max(2, min($n, $maxSentences));
        }

        return trim(implode(' ', array_slice($parts, 0, $n)));
    }

    private static function fallbackDescriptionFromContent(Product $product, Complex $complex): string
    {
        $descSource = self::plainText($product->seo_description ?? '');
        if ($descSource === '') {
            $descSource = self::plainText($product->description ?? '');
        }
        if ($descSource === '') {
            $descSource = self::plainText($product->content ?? '');
        }
        if ($descSource === '') {
            $descSource = self::plainText($product->about ?? '');
        }
        if ($descSource === '') {
            $descSource = self::plainText(($complex->subtitle ?? '').' '.($complex->content ?? ''));
        }
        if ($descSource === '') {
            $descSource = self::plainText($complex->seo_description ?? '');
        }

        $description = self::takeSentencesRu($descSource);
        if ($description === '' || mb_strlen($description) < 60) {
            $description = Str::limit($descSource, 520);
        }
        if (trim($description) === '') {
            $description = 'Биологически активная добавка к питанию «'
                .strip_tags((string) $product->title)
                .'» линейки Система РЕПРО для программы подготовки пары к беременности.';
        }

        return trim($description);
    }
}
