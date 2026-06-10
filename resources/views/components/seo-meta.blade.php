@props(['pageType', 'defaultTitle' => null, 'defaultDescription' => null, 'resource' => null, 'forceDynamic' => false, 'customKeywords' => null])

@php
    // Принудительно приводим forceDynamic к булевому типу
    $forceDynamic = (bool) $forceDynamic;
    
    $seoData = \App\Services\SeoService::getMetaTags($pageType);
    // При forceDynamic переопределяем только title и description динамическими значениями
    // keywords и og_image остаются из SEO таблицы
    if ($forceDynamic && !empty($defaultTitle)) {
        // Используем динамические значения вместо данных из таблицы
        $finalTitle = $defaultTitle;
        $finalDescription = $defaultDescription;
        $finalOgTitle = $defaultTitle;
        $finalOgDescription = $defaultDescription;
    } else {
        // Используем данные из таблицы или fallback на динамические
        $finalTitle = $seoData['title'] ?? $defaultTitle;
        $finalDescription = $seoData['description'] ?? $defaultDescription;
        $finalOgTitle = $seoData['og_title'] ?? $seoData['title'] ?? $defaultTitle;
        $finalOgDescription = $seoData['og_description'] ?? $seoData['description'] ?? $defaultDescription;
    }
    
    // Добавляем выбранный город в конец title и description, если город выбран
    $selectedCity = session()->get('city');
    if ($selectedCity && !empty($selectedCity) && $finalTitle) {
        $finalTitle = $finalTitle . ': ' . trim($selectedCity);
    }
    if ($selectedCity && !empty($selectedCity) && $finalOgTitle) {
        $finalOgTitle = $finalOgTitle . ': ' . trim($selectedCity);
    }
    if ($selectedCity && !empty($selectedCity) && $finalDescription) {
        $finalDescription = $finalDescription . ': ' . trim($selectedCity);
    }
    if ($selectedCity && !empty($selectedCity) && $finalOgDescription) {
        $finalOgDescription = $finalOgDescription . ': ' . trim($selectedCity);
    }

    $finalKeywords = filled($customKeywords) ? $customKeywords : ($seoData['keywords'] ?? null);
@endphp

@if($finalTitle)
    <title>{{ $finalTitle }}</title>
@endif

@if($finalDescription)
    <meta name="description" content="{{ $finalDescription }}">
@endif

@if($finalKeywords)
    <meta name="keywords" content="{{ $finalKeywords }}">
@endif

@if($finalOgTitle)
    <meta property="og:title" content="{{ $finalOgTitle }}">
@endif

@if($finalOgDescription)
    <meta property="og:description" content="{{ $finalOgDescription }}">
@endif

@php
    // Определяем изображение для og:image
    $ogImage = $seoData['og_image'] ?? null;

    if (! $ogImage && $resource) {
        $ogImage = \App\Support\SeoImageUrl::forResource($resource);
    }

    // Проверяем, является ли изображение base64 (data:image/...)
    if ($ogImage && str_starts_with($ogImage, 'data:image')) {
        $ogImage = null;
    }

    // SVG не подходит для сниппетов Яндекса — только растровые форматы
    if ($ogImage && ! \App\Support\ProductImageUrl::isSuitableForSnippet(
        str_starts_with($ogImage, 'http') ? $ogImage : (config('app.url') . '/' . ltrim($ogImage, '/'))
    )) {
        $ogImage = null;
    }

    if (! $ogImage) {
        $ogImage = config('app.url') . '/images/lgog-gold.svg';
    }

    $ogImageUrl = str_starts_with($ogImage, 'http') ? $ogImage : (config('app.url') . '/' . ltrim($ogImage, '/'));
@endphp
<meta property="og:image" content="{{ $ogImageUrl }}">

<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.name') }}"> 