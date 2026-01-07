@props(['pageType', 'defaultTitle' => null, 'defaultDescription' => null, 'forceDynamic' => false])

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
@endphp

@if($finalTitle)
    <title>{{ $finalTitle }}</title>
@endif

@if($finalDescription)
    <meta name="description" content="{{ $finalDescription }}">
@endif

@if($seoData['keywords'])
    <meta name="keywords" content="{{ $seoData['keywords'] }}">
@endif

@if($finalOgTitle)
    <meta property="og:title" content="{{ $finalOgTitle }}">
@endif

@if($finalOgDescription)
    <meta property="og:description" content="{{ $finalOgDescription }}">
@endif

@if($seoData['og_image'])
    <meta property="og:image" content="{{ $seoData['og_image'] }}">
@endif

<meta property="og:type" content="website">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:site_name" content="{{ config('app.name') }}"> 