@props(['pageType', 'defaultTitle' => null, 'defaultDescription' => null, 'forceDynamic' => false])

@php
    $seoData = \App\Services\SeoService::getMetaTags($pageType);
    // При forceDynamic переопределяем только title и description динамическими значениями
    // keywords и og_image остаются из SEO таблицы
    if ($forceDynamic) {
        $seoData['title'] = null;
        $seoData['description'] = null;
        $seoData['og_title'] = null;
        $seoData['og_description'] = null;
    }
@endphp

@if($forceDynamic && $defaultTitle)
    <title>{{ $defaultTitle }}</title>
@elseif($seoData['title'])
    <title>{{ $seoData['title'] }}</title>
@elseif($defaultTitle)
    <title>{{ $defaultTitle }}</title>
@endif

@if($forceDynamic && $defaultDescription)
    <meta name="description" content="{{ $defaultDescription }}">
@elseif($seoData['description'])
    <meta name="description" content="{{ $seoData['description'] }}">
@elseif($defaultDescription)
    <meta name="description" content="{{ $defaultDescription }}">
@endif

@if($seoData['keywords'])
    <meta name="keywords" content="{{ $seoData['keywords'] }}">
@endif

@if($forceDynamic && $defaultTitle)
    <meta property="og:title" content="{{ $defaultTitle }}">
@elseif($seoData['og_title'])
    <meta property="og:title" content="{{ $seoData['og_title'] }}">
@elseif($seoData['title'])
    <meta property="og:title" content="{{ $seoData['title'] }}">
@elseif($defaultTitle)
    <meta property="og:title" content="{{ $defaultTitle }}">
@endif

@if($forceDynamic && $defaultDescription)
    <meta property="og:description" content="{{ $defaultDescription }}">
@elseif($seoData['og_description'])
    <meta property="og:description" content="{{ $seoData['og_description'] }}">
@elseif($seoData['description'])
    <meta property="og:description" content="{{ $seoData['description'] }}">
@elseif($defaultDescription)
    <meta property="og:description" content="{{ $defaultDescription }}">
@endif

@if($seoData['og_image'])
    <meta property="og:image" content="{{ $seoData['og_image'] }}">
@endif

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ config('app.name') }}"> 