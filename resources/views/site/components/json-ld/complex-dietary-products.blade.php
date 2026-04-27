@php
    /** @var \App\Models\Complex $resource */
    $baseUrl = rtrim(config('app.url'), '/');
    $companyUrl = $baseUrl . '/company';

    $plainText = static function (?string $html): string {
        return trim(preg_replace('/\s+/u', ' ', strip_tags((string) $html)));
    };

    $takeSentencesRu = static function (?string $text, int $maxSentences = 4): string {
        $text = trim(preg_replace('/\s+/u', ' ', strip_tags((string) $text)));
        if ($text === '') {
            return '';
        }
        $parts = preg_split('/(?<=[.!?])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (count($parts) === 0) {
            return \Illuminate\Support\Str::limit($text, 520);
        }
        $count = count($parts);
        $n = min($maxSentences, $count);
        if ($count >= 2) {
            $n = max(2, min($n, $maxSentences));
        }
        return trim(implode(' ', array_slice($parts, 0, $n)));
    };

    $graph = [];

    foreach ($resource->products ?? [] as $product) {
        $descSource = $plainText($product->seo_description ?? '');
        if ($descSource === '') {
            $descSource = $plainText($product->description ?? '');
        }
        if ($descSource === '') {
            $descSource = $plainText($product->content ?? '');
        }
        if ($descSource === '') {
            $descSource = $plainText($product->about ?? '');
        }
        if ($descSource === '') {
            $descSource = $plainText(($resource->subtitle ?? '') . ' ' . ($resource->content ?? ''));
        }
        if ($descSource === '') {
            $descSource = $plainText($resource->seo_description ?? '');
        }

        $description = $takeSentencesRu($descSource);
        if ($description === '' || mb_strlen($description) < 60) {
            $description = \Illuminate\Support\Str::limit($descSource, 520);
        }
        if ($description === '') {
            $description = 'Биологически активная добавка к питанию «'
                . strip_tags((string) $product->title)
                . '» линейки Система РЕПРО для программы подготовки пары к беременности.';
        }

        $offerUrl = $product->link;
        if (empty($offerUrl)) {
            $offerUrl = 'https://www.eapteka.ru/search/?q=' . rawurlencode(strip_tags((string) $product->title));
        }

        $offer = [
            '@type' => 'Offer',
            'url' => $offerUrl,
            'availability' => 'https://schema.org/InStock',
        ];
        if (str_contains((string) $offerUrl, 'eapteka.ru')) {
            $offer['seller'] = [
                '@type' => 'Organization',
                'name' => 'Еаптека',
            ];
        }

        $item = [
            '@type' => ['Product', 'DietarySupplement'],
            'name' => strip_tags((string) $product->title),
            'description' => $description,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Система РЕПРО',
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => 'АО «Р-Фарм»',
                'url' => $companyUrl,
            ],
            'offers' => [$offer],
        ];

        $img = null;
        if (! empty($product->images) && is_array($product->images)) {
            $first = reset($product->images);
            if (is_array($first) && ! empty($first['url'])) {
                $img = $first['url'];
            }
        }
        if (! $img && ! empty($product->photo)) {
            $img = $product->photo;
        }
        if ($img && ! str_starts_with((string) $img, 'http')) {
            $img = $baseUrl . '/' . ltrim((string) $img, '/');
        }
        if ($img) {
            $item['image'] = $img;
        }

        $includesPlain = $plainText($product->includes ?? '');
        if (mb_strlen($includesPlain) >= 20) {
            $ing = mb_strlen($includesPlain) > 380 ? preg_replace('/\s+\S*$/u', '', mb_substr($includesPlain, 0, 380)) . '…' : $includesPlain;
            $item['activeIngredient'] = $ing;
        }

        $targetPopulation = 'Пары, планирующие беременность.';
        if ($resource->alias === 'reprorelax') {
            $targetPopulation .= ' Уместно при остром или хроническом стрессе в период планирования беременности.';
        }
        $item['targetPopulation'] = $targetPopulation;

        $graph[] = $item;
    }

    $jsonLd = null;
    if (count($graph) > 0) {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    } else {
        $fallbackSource = $plainText($resource->seo_description ?? '');
        if ($fallbackSource === '') {
            $fallbackSource = $plainText($resource->description ?? '');
        }
        if ($fallbackSource === '') {
            $fallbackSource = $plainText(($resource->subtitle ?? '') . ' ' . ($resource->content ?? ''));
        }
        $fbDesc = $takeSentencesRu($fallbackSource);
        if ($fbDesc === '' || mb_strlen($fbDesc) < 40) {
            $fbDesc = \Illuminate\Support\Str::limit($fallbackSource, 520);
        }
        if ($fbDesc === '') {
            $fbDesc = 'Комплекс биологически активных добавок к питанию Система РЕПРО для подготовки пары к беременности.';
        }

        $offerUrlLegacy = 'https://www.eapteka.ru/search/?q=' . rawurlencode('репро система');
        $offerLegacy = [
            '@type' => 'Offer',
            'url' => $offerUrlLegacy,
            'availability' => 'https://schema.org/InStock',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'Еаптека',
            ],
        ];

        $legacy = [
            '@context' => 'https://schema.org',
            '@type' => ['Product', 'DietarySupplement'],
            'name' => strip_tags((string) $resource->title),
            'description' => $fbDesc,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Система РЕПРО',
            ],
            'manufacturer' => [
                '@type' => 'Organization',
                'name' => 'АО «Р-Фарм»',
                'url' => $companyUrl,
            ],
            'offers' => [$offerLegacy],
            'targetPopulation' => 'Пары, планирующие беременность.',
        ];

        if ($resource->image_left) {
            $il = $resource->image_left;
            $legacy['image'] = str_starts_with((string) $il, 'http')
                ? $il
                : ($baseUrl . '/' . ltrim((string) $il, '/'));
        }

        $jsonLd = $legacy;
    }
@endphp
@if($jsonLd)
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
