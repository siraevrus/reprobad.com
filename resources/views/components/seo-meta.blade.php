@props(['pageType', 'pageId', 'defaultTitle' => null, 'defaultDescription' => null])

@php
    // Если pageId = 0, это список страниц, для него SEO данные не ищем
    if ($pageId == 0) {
        $seoData = [
            'title' => null,
            'description' => null,
            'keywords' => null,
            'og_title' => null,
            'og_description' => null,
            'og_image' => null,
        ];
    } else {
        $seoData = \App\Services\SeoService::getMetaTags($pageType, $pageId);
    }
@endphp

@if($seoData['title'])
    <title>{{ $seoData['title'] }}</title>
@elseif($defaultTitle)
    <title>{{ $defaultTitle }}</title>
@endif

@if($seoData['description'])
    <meta name="description" content="{{ $seoData['description'] }}">
@elseif($defaultDescription)
    <meta name="description" content="{{ $defaultDescription }}">
@endif

@if($seoData['keywords'])
    <meta name="keywords" content="{{ $seoData['keywords'] }}">
@endif

@if($seoData['og_title'])
    <meta property="og:title" content="{{ $seoData['og_title'] }}">
@elseif($seoData['title'])
    <meta property="og:title" content="{{ $seoData['title'] }}">
@elseif($defaultTitle)
    <meta property="og:title" content="{{ $defaultTitle }}">
@endif

@if($seoData['og_description'])
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