<!DOCTYPE html>
<html data-wf-page="673718a9aa664236cdc0b634" data-wf-site="673718a9aa664236cdc0b633">
<head>
    <meta charset="utf-8">

    @if(isset($resource) && isset($pageType))
        <x-seo-meta
            :pageType="$pageType"
            :defaultTitle="$resource->seo_title ?? $resource->title ?? ''"
            :defaultDescription="$resource->seo_description ?? $resource->description ?? ''"
            :forceDynamic="$forceDynamic ?? false"
        />
    @elseif(isset($resource))
        <title>{{ isset($resource->title) ? strip_tags($resource->title) : '' }}</title>
        <meta content="{{ isset($resource->seo_description) ? strip_tags($resource->seo_description) : '' }}" name="description">
        <meta content="{{ isset($resource->title) ? strip_tags($resource->title) : '' }}" property="og:title">
        <meta content="{{ isset($resource->seo_description) ? strip_tags($resource->seo_description) : '' }}" property="og:description">
        <meta content="{{ $resource->image ?? '' }}" property="og:image">
        <meta content="{{ isset($resource->title) ? strip_tags($resource->title) : '' }}" property="twitter:title">
        <meta content="{{ isset($resource->seo_description) ? strip_tags($resource->seo_description) : '' }}" property="twitter:description">
        <meta content="{{ $resource->image ?? '' }}" property="twitter:image">
        <meta property="og:type" content="website">
    @else
        <title>РЕПРО АПОТЕКА • REPRO APOTHEKA</title>
        <meta content="Готовимся к беременности вместе" name="description">
        <meta content="РЕПРО АПОТЕКА • REPRO APOTHEKA" property="og:title">
        <meta content="Готовимся к беременности вместе" property="og:description">
        <meta property="og:type" content="website">
    @endif

    <base href="/">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @yield('head')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="css/normalize.css" rel="stylesheet" type="text/css">
    <link href="css/webflow.css" rel="stylesheet" type="text/css">
    <link href="css/sistema-repro-550d9e79d9699175495d854c7.webflow.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script type="text/javascript">WebFont.load({  google: {    families: ["Inter:regular,500,700:cyrillic,latin","Raleway:regular,500,600,700:cyrillic,latin"]  }});</script>
    <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="images/webclip.jpg" rel="apple-touch-icon">
    <!-- Preload Lottie banner files for faster loading -->
    <link rel="preload" href="images/weUkdnuK0x.lottie" as="fetch" crossorigin>
    <link rel="preload" href="images/qk8EQOxYwW.lottie" as="fetch" crossorigin>
    <link rel="preload" href="https://unpkg.com/@lottiefiles/dotlottie-wc@0.7.1/dist/dotlottie-wc.js" as="script">
    <style>
        :focus-visible { outline: var(--mandarin) auto 1px; }
        .bad-wrap { position: fixed; visibility: hidden; }
        .search-input:placeholder-shown ~ .search-button { display: none; }
        .cookies-banner { display: none; }
        .step-item.blue { background-image: radial-gradient(circle at 0 0, #4e8eaa, #5694ae 20%, #c4f2f5) }
        .step-item.purple { background-image: radial-gradient(circle at 0 0, #9f99de, #a6a0e1 27%, #dedbf6) }
        .step-item.green { background-image: radial-gradient(circle at 0 0, #839f6a, #8fab77 20%, #ddface) }
        .step-item.mandarin { background-image: radial-gradient(circle at 0 0, #ff967b, #ff9a7e 24%, #ffe3cb) }
        .top-5-slider-dot { font-size: 0rem; width: 0.375rem; }
        .top-5-slider-dot.active { font-size: 0.875rem; min-width: 1.5rem }
        .top-5-slider-dot:has(+ .active ) { width: 0.75rem; }
        .top-5-slider-dot.active + .top-5-slider-dot { width: 0.75rem; }
        .questions-slider { overflow: visible; }
        .swiper-button-disabled { opacity: 0; pointer-events: none; }
        .swiper-3d .swiper-slide-shadow { background: rgba(244,187,174,0.25); }
    </style>
    <script async="" src="https://files.raketadesign.ru/files/sistema-repro/head.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @isset($resource->color)
        <link rel="stylesheet" href="css/{{ $resource->color }}.css">
    @endisset
</head>
<body class="{{ isset($isHome) || request()->segment(1) == 'contacts' ? '' : 'lavender' }} {{ $bodyClass ?? '' }}">

@if(isset($resource->color) && in_array($resource->color, ['blue', 'purple', 'orange', 'green', 'mandarin']))
    @include('site.components.products.' . $resource->color)
@else
<div class="w-embed">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
        html { font-size: 1.333125rem; }
        @media screen and (max-width:1920px) { html { font-size: calc(0.0009480702515177741rem + 1.1101474414570685vw); } }
        @media screen and (max-width:767px) { html { font-size: calc(-0.0026705287206266314rem + 4.27284595300261vw); } }
        html { overflow-y: scroll; overflow-x: hidden; height: -webkit-fill-available; }
        @supports (scrollbar-gutter: stable) { html { overflow-y: auto; scrollbar-gutter: stable; } }
        body { min-height: 100vh; min-height: -webkit-fill-available; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        .w-richtext > *:first-child { margin-top: 0; }
        .w-richtext > *:last-child { margin-bottom: 0; }
        .w-richtext figure img { border-radius: 1rem; }
        .w-richtext figure { --figure-width: 100%; width: var(--figure-width); max-width: var(--figure-width); }
        .w-richtext figure div, .w-richtext figure img { width: 100% !important; !important; max-width: 100% !important; }
        .card-title { color: var(--p-first-color); }
        ul li::marker { color: var(--lavender); }
        .o-span{ visibility: hidden; }
        .o-span::after {
            position: absolute;
            display: inline;
            content: ' ';
            left: 0.03em;
            top: 0em;
            background-color: currentColor;
            visibility: visible;
            height: 0.765em;
            width: auto;
            aspect-ratio: 70 / 47;
            mask-image: url('https://cdn.prod.website-files.com/67040316492967a9326aebb1/6704221050c6b216a7dee2a7_O.svg');
            mask-size: 100% 100%;
        }
        .search-input:focus ~ .search-icon, .search-input:not(:placeholder-shown)  ~ .search-icon { opacity: 1; }
        .search-input:not(:placeholder-shown)  ~ .search-button { display: block; }
        .tags::-webkit-scrollbar { display: none; }
        .tags { -ms-overflow-style: none;   scrollbar-width: none; }
        .events-card:last-child { border-bottom: none; }
        .white-cards .card, .white-cards .socials-card { background-color: var(--white); }
        input[name="search"]::placeholder { color: rgba(78, 81, 92, 0.4); }
        .step-item:hover .step-item-overlay { opacity: 0 !important; }
        .desktop-hyphen::after { content: '-'; }
        .home-buy-button:hover .home-buy-eapteka-logo { transform: scale(1.1); }
        .product-options-list .product-options-list-item:first-child { padding-top: 0; }
        .product-options-list .product-options-list-item:last-child { padding-bottom: 0; border-bottom: none;}
        .product-options-content > *:first-child { margin-top: 0; }
        .product-options-content > *:last-child { margin-bottom: 0; }
        .product-table .product-table-row:last-child{ border-bottom: none;}
        @media screen and (max-width:767px) {
            .events-card-city::after { content: ', '; }
            .events-card-address-2::before { content: ', '; }
            .w-richtext figure { --figure-width: calc(100% + 2rem); }
            .desktop-hyphen::after { content: ''; }
            .mobile-hyphen::after { content: '-'; }
            .items-wrap .card,
            .items-wrap .news-card {
                width: 100% !important;
                max-width: 100% !important;
                flex-basis: 100% !important;
            }
        }
        .nav-quick-link.active {
            opacity: 1;
            color: var(--text);
            background-color: #8577b71a;
            text-decoration: none;
        }
    </style>
    @if(isset($resource->color) && $resource->color)
    <style>
        .product-options-tab-content {
            background: var(--p-bg-color) !important;
        }
    </style>
    @endif
</div>
@endif
<style>
    .custom-button-product {
        color: var(--p-first-color);
        text-align: center;
        text-transform: uppercase;
        border-radius: 10rem;
        padding: .75rem 1.5rem;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.5;
        transition: color .15s, background-color .15s, transform .15s cubic-bezier(.175, .885, .32, 1.275), opacity .15s cubic-bezier(.175, .885, .32, 1.275);
    }
</style>
<div data-animation="default" data-collapse="small" data-duration="400" data-easing="ease" data-easing2="ease" data-doc-height="1" role="banner" class="navbar w-nav">
    <div class="navbar-overlay"></div>
    <div class="navbar-container w-container">
        <a href="/" aria-current="page" class="brand w-nav-brand w--current"><img src="images/lgog-gold.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
            <div>готовимся <br>к беременности <br>вместе!</div>
        </a>
        <div class="nav-desktop-links">
            <a href="about" class="nav-quick-link {{ request()->is('about') ? 'active' : '' }}">Система РЕПРО</a>
            <a href="products" class="nav-quick-link {{ request()->is('products') ? 'active' : '' }}">Продукты</a>
            <a href="usefully-tips" class="nav-quick-link {{ request()->is('usefully-tips') ? 'active' : '' }}">Полезные советы</a>
            <a href="articles" class="nav-quick-link {{ request()->is('articles') ? 'active' : '' }}">Статьи</a>
            <a href="events" class="nav-quick-link  {{ request()->is('events') ? 'active' : '' }}">События</a>
        </div>
        @if(!isset($isHome))
            <a href="https://www.eapteka.ru/goods/brand/repro/?utm_source=products&utm_medium=direct_link&utm_content=menu_top_button&utm_campaign=eapteka" class="navbar-buy-button w-button">Купить</a>
        @endif
        <div data-hover="true" data-delay="200" class="nav-dropdown w-dropdown">
            <div class="nav-dropdown-toggle w-dropdown-toggle">
                <div class="menu-button-icon w-icon-nav-menu"></div>
            </div>
            <nav class="nav-dropdown-list w-dropdown-list">
                <div class="nav-arrow-up w-embed"><svg width="100%" height="100%" viewbox="0 0 16 7.17157288" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path d="M9.41421356,0.585786438 L16,7.17157288 L16,7.17157288 L0,7.17157288 L6.58578644,0.585786438 C7.36683502,-0.195262146 8.63316498,-0.195262146 9.41421356,0.585786438 Z" id="Rectangle" fill="#8577B7"></path>
                    </svg></div>
                <div class="nav-menu-links">
                    <a href="products" class="nav-link hide-desktop">Продукты</a>
                    <a href="events" class="nav-link hide-desktop">События</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="articles" class="nav-link hide-desktop">Статьи</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                    <div class="nav-link-divider"></div>
                    <a href="faq" class="nav-link">Вопрос-ответ</a>
                    <a href="map" class="nav-link">Карта</a>
                </div>
            </nav>
        </div>
        <nav role="navigation" class="nav-menu w-nav-menu">
            <div class="nav-menu-wrap">
                <div class="nav-menu-links">
                    <a href="about" class="nav-link hide-desktop">Система Репро</a>
                    <a href="products" class="nav-link hide-desktop">Продукты</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="articles" class="nav-link hide-desktop">Статьи</a>
                    <a href="events" class="nav-link hide-desktop">События</a>

                    <a href="map" class="nav-link">&nbsp;</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                    <div class="nav-link-divider"></div>
                    <a href="faq" class="nav-link">Вопрос-ответ</a>
                    <a href="map" class="nav-link">Карта</a>
                </div>
                <div class="nav-family-line"><img src="images/nav-family-line.svg" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
                <div class="nav-contacts">
                    <a href="tel:{{ str_replace([' ', ')', '(', '-'], '', config('phone')) }}" class="nav-contacts-phone">{{ config('phone') }}</a>
                    <a href="mailto:{{ config('email') }}" class="nav-contacts-email">{{ config('email') }}</a>
                    <a href="{{ route('site.text.privacy') }}" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
                </div>
            </div>
        </nav>
        <div class="menu-button w-nav-button">
            <div class="menu-button-icon w-icon-nav-menu"></div>
        </div>
    </div>
    @if(isset($isHome) || isset($bodyClass) && $bodyClass == 'products-page')
        <div class="navbar-background"></div>
    @endif
</div>

@if(isset($isHome) || isset($bodyClass) && $bodyClass == 'products-page')
    <div class="heart-bg">
        <img src="images/heart.webp" loading="lazy" sizes="100vw" srcset="images/heart-p-500.webp 500w, images/heart-p-800.webp 800w, images/heart-p-1080.webp 1080w, images/heart-p-1600.webp 1600w, images/heart.webp 2000w" alt="" class="heart-bg-image">
        <div class="heart-bg-mandarin-gradient"></div>
    </div>
@endif

@yield('content')

<section class="footer-section">
    <div class="footer-container">
        <a href="/" class="footer-logo-link w-inline-block"><img src="images/logo-black.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="footer-logo"></a>
        <div class="footer-contacts">
            <div>
                <a href="tel:{{ str_replace([' ', '-', ')', '('], '', config('phone')) }}" class="footer-phone">{{ config('phone') }}</a>
                <a href="mailto:{{ config('email') }}" class="footer-email">{{ config('email') }}</a>
            </div>
            <div class="social-icons">
                @if(config('rutube'))
                <a href="{{ config('rutube') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed">
                        <svg width="100%" height="100%" viewbox="0 0 33 33" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
                        </svg>
                    </div>
                </a>
                @endif
                @if(config('telegram'))
                <a href="{{ config('telegram') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed">
                        <svg width="100%" height="100%" viewbox="0 0 33 33" xmlns="http://www.w3.org/2000/svg">
                            <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </a>
                @endif
                @if(config('ok'))
                <a href="{{ config('ok') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed">
                        <svg width="48px" height="48px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M24,0 C37.2548,0 48,10.7452 48,24 C48,37.2548 37.2548,48 24,48 C10.7452,48 0,37.2548 0,24 C0,10.7452 10.7452,0 24,0 Z M28.3188288,24.8783576 C25.6907328,26.4736296 22.3071408,26.4732616 19.6805888,24.8783576 C18.8011008,24.3440064 17.6409888,24.5996944 17.0893408,25.449024 C16.5361576,26.29724 16.8000092,27.416712 17.6778416,27.951064 C18.8379536,28.6536504 20.0974896,29.153168 21.4034736,29.440352 L17.8164256,32.902888 C17.0831992,33.6114032 17.0831992,34.760144 17.8171934,35.468664 C18.1845742,35.8225512 18.6652014,35.99968 19.1458334,35.99968 C19.6272294,35.99968 20.1086254,35.8225512 20.4760094,35.468664 L23.9993374,32.06616 L27.5257374,35.468664 C28.2589638,36.1771792 29.4486334,36.1771792 30.1826254,35.468664 C30.9173878,34.7601488 30.9173878,33.610664 30.1826254,32.902888 L26.5959614,29.440352 C27.901928,29.1531664 29.161472,28.6543888 30.321576,27.951064 C31.199528,27.4167128 31.464024,26.296504 30.9108448,25.449024 C30.3580456,24.599696 29.1983168,24.344008 28.3188288,24.8783576 Z M23.98368,12.000048 C20.445384,12.000048 17.56776,14.778152 17.56776,18.193632 C17.56776,21.607992 20.445384,24.38536 23.98368,24.38536 C27.522744,24.38536 30.3996,21.607992 30.3996,18.193632 C30.3996,14.77816 27.522744,12.000048 23.98368,12.000048 Z M23.98368,15.62968 C25.4486,15.62968 26.640184,16.779536 26.640184,18.1936 C26.640184,19.606552 25.448592,20.757152 23.98368,20.757152 C22.519912,20.757152 21.327176,19.606552 21.327176,18.1936 C21.327176,16.779536 22.51992,15.62968 23.98368,15.62968 Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </a>
                @endif
                @if(config('vk'))
                <a href="{{ config('vk') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed">
                        <svg width="48px" height="48px" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M24,0 C37.2548,0 48,10.7452 48,24 C48,37.2548 37.2548,48 24,48 C10.7452,48 0,37.2548 0,24 C0,10.7452 10.7452,0 24,0 Z M20.31592,17.9238583 C19.8776864,18.1340263 19.53962,18.6035255 19.746216,18.6305647 C20.000392,18.6637492 20.57636,18.7829671 20.881864,19.1910135 C21.1763333,19.5846722 21.2432727,20.3434906 21.2582894,20.702774 L21.2860958,21.4162364 C21.3143854,22.3519105 21.3000646,24.2611675 20.7328648,24.5644375 C20.2312183,24.8332437 19.5489875,24.3112854 18.1199145,21.9280962 L17.9744968,21.6835335 C17.4301067,20.7601415 16.9784232,19.768941 16.753911,19.2511331 L16.6009448,18.8886615 C16.6009448,18.8886615 16.487004,18.6145823 16.282912,18.4670959 C16.0362488,18.2888831 15.6919224,18.2335759 15.6919224,18.2335759 L12.0345464,18.256928 C12.0345464,18.256928 11.484876,18.2716766 11.283288,18.5064256 C11.1400483,18.6725939 11.2171773,18.981922 11.2537585,19.0990066 L11.3156417,19.2497928 C11.6958253,20.1019574 14.3732764,25.967744 17.3759949,29.0369736 C19.8059555,31.5196366 22.5042924,31.8406578 23.4098628,31.8750476 L25.2554429,31.8760856 L25.3616276,31.858461 C25.5123704,31.8279256 25.7884579,31.7508393 25.9541104,31.5761904 C26.124693,31.3961648 26.1562827,31.0903749 26.1620054,30.9685435 L26.1639828,30.8216532 L26.170584,30.6483168 C26.2007398,30.0899449 26.3507589,28.8342391 27.0872584,28.60434 C28.0263304,28.3118248 29.2320984,30.552388 30.5117464,31.413956 C31.4783624,32.0653544 32.2120904,31.922784 32.2120904,31.922784 L35.6556317,31.8741549 C35.8578756,31.8558168 37.2520921,31.6860204 36.6503673,30.5259881 L36.4413492,30.1645397 C36.2131875,29.7978261 35.6386737,28.9935951 34.2361793,27.6902431 L33.5157504,27.0294479 C31.9926961,25.6101253 32.3821114,25.5646341 34.5863809,22.7047163 L34.7551024,22.4848799 C36.3277344,20.4274399 36.9562864,19.1713519 36.7597104,18.6342559 C36.573148,18.1205111 35.4162064,18.2569359 35.4162064,18.2569359 L31.5672624,18.2802879 L31.4657764,18.2747788 C31.3635422,18.2745267 31.2024325,18.2887376 31.07018,18.3663215 C30.863584,18.4879983 30.7296096,18.7719095 30.7296096,18.7719095 L30.5843451,19.1327284 C30.3572783,19.6801777 29.8840795,20.7585715 29.3084816,21.7179495 L29.0165466,22.1944087 C27.515185,24.5909194 26.8929672,24.7150347 26.6289936,24.5484615 C25.9766512,24.1342703 26.139424,22.8867815 26.139424,22.0006295 C26.139424,19.2315735 26.5676408,18.0774855 25.306776,17.7788295 L25.0445241,17.719765 C24.7509155,17.6598353 24.4181106,17.6196136 23.728065,17.606266 L23.510016,17.6030751 C22.136464,17.5895555 20.97452,17.6079914 20.31592,17.9238583 Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </a>
                @endif
                @if(config('dzen'))
                <a href="{{ config('dzen') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed">
                        <svg width="100%" height="100%" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M0.000489884797,24.7093682 L1.03450298,24.7245718 C10.1144857,24.8822392 15.3202462,25.6268077 18.8366324,29.1432324 C22.4843276,32.7909276 23.1493279,38.2564822 23.2705745,47.9788373 C10.5873826,47.6059299 0.373894927,37.3924422 0.000489884797,24.7093682 Z M24.7093682,47.979335 L24.7245719,46.945322 C24.8822419,37.865342 25.6268462,32.6596172 29.1432324,29.1431924 C32.7909276,25.4954973 38.2564821,24.8304969 47.9788373,24.7092503 C47.6059299,37.3924422 37.3924422,47.6059299 24.7093682,47.979335 Z M23.2704566,0.000489926248 L23.2552531,1.03450287 C23.0975857,10.1144828 22.3530186,15.3202063 18.8366324,18.8365924 C15.1887738,22.4844111 9.72297256,23.1493729 0,23.2705469 C0.373894927,10.5873827 10.5873826,0.373894968 23.2704566,0.000489926248 Z M47.9793349,23.2704566 L46.945322,23.2552131 C37.865342,23.0975458 32.6596171,22.3529786 29.1431924,18.8365924 C25.4953737,15.1887738 24.8304519,9.72293263 24.7092379,0 C37.3924422,0.373894968 47.6059299,10.5873827 47.9793349,23.2704566 Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </a>
                @endif
            </div>
            <div class="footer-slogan"><strong>Мы стараемся для вас, чтобы вы старались для них!</strong></div>
        </div>
        <div class="footer-menu">
            <div class="footer-menu-column">
                <a href="about" class="footer-menu-link">Система РЕПРО</a>
                <a href="products" class="footer-menu-link">Продукты</a>
                <a href="events" class="footer-menu-link">События</a>
                <a href="usefully-tips" class="footer-menu-link">Полезные советы</a>
                <a href="articles" class="footer-menu-link">Статьи</a>
            </div>
            <div class="footer-menu-column">
                {{-- <a href="map" class="footer-menu-link">Где купить</a> --}}
                <a href="company" aria-current="page" class="footer-menu-link w--current">О компании</a>
                <a href="faq" aria-current="page" class="footer-menu-link w--current">Вопросы-ответы</a>
                <a href="contacts" class="footer-menu-link">Контакты</a>
            </div>
            <a href="{{ route('site.text.privacy') }}" target="_blank" class="footer-terms-link">Политика конфиденциальности в отношении персональных данных</a>
        </div>
        <div class="r-farm-footer">
            <a href="https://www.r-pharm.com/ru" target="_blank" class="r-farm-footer-link w-inline-block"><img src="images/RFarm-footer.png" loading="lazy" alt="Р-Фарм" class="r-farm-image"></a>
            <div>{{ config('address') }}</div>
            <div>
                Владелец сайта: АО «Р-Фарм» 123154, Москва, ул. Берзарина, д. 19, корп. 1 <br>
                Организация, уполномоченная принимать претензии от потребителей: ООО «Р-Фарм Косметикс» <br>
                Тел: <a href="tel:+74951651075">+7 (495) 165 10 75</a> <br>
                Адрес электронной почты для направления заявления о нарушении авторских и (или) смежных прав (ч. 2 ст. 10, 149-ФЗ "Об информации, информационных технологиях и о защите информации")
                <a href="mailto:reproapotheka@rpharm.ru">reproapotheka@rpharm.ru</a>
            </div>
            <div>БАД. НЕ ЯВЛЯЕТСЯ ЛЕКАРСТВЕННЫМ СРЕДСТВОМ. ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. НЕОБХОДИМО ПРОКОНСУЛЬТИРОВАТЬСЯ СО СПЕЦИАЛИСТОМ.</div>
        </div>
    </div>
    <div class="bad-wrap">
        <div class="bad-container">
            <div class="bad-text"></div>
            <a href="#" class="bad-close w-inline-block">
                <img src="images/bad-close.svg" loading="lazy" alt="" class="bad-close-image">
            </a>
        </div>
    </div>
    <div class="cookies-banner">
        <div class="cookies-wrap">
            <div class="cookies">
                <div class="cookies-text">Этот веб-сайт использует файлы cookies, чтобы обеспечить удобную работу пользователей с ним и функциональные возможности сайта. Нажимая &quot;Я принимаю&quot; вы соглашаетесь с <a href="{{ route('site.text.privacy') }}" target="_blank" class="cookies-text-link">условиями использования файлов cookies</a>
                </div>
                <a href="#" class="accept-cookies w-button">Принимаю</a>
            </div>
        </div>
    </div>
</section>
<div class="products-popup">
    <div class="products-popup-head">
        <div class="product-popup-head-container">
            <a href="#" class="products-popup-close-button w-inline-block">
                <div>Закрыть</div><img src="images/wx.svg" loading="lazy" alt="" class="products-popup-close-cross">
            </a>
        </div>
    </div>
    <div class="products-popup-body">
        <div class="product-popup-container">
            <div class="products-grid">
                @foreach(App\Models\Product::query()->with('complex')->get() as $resource)
                    @if($resource->complex->alias)
                        <div class="product-item">
                            <div class="product-item-content">
                                <div class="product-item-logo big"><img src="{{ $resource->logo }}" loading="lazy" alt="" class="repro-relax-giper-logo"></div>
                                <p class="product-item-text">{{ $resource->description }}</p>
                                <a href="{{ route('site.complex.show', $resource->complex->alias) }}" class="product-item-link w-inline-block">
                                    <div class="sache-image-element"><img src="{{ $resource->image }}" loading="lazy" alt="" class="sache-image"></div>
                                    <div class="product-item-image-shadow"></div>
                                </a>
                                <div class="product-item-button-wrap">
                                    <a href="{{ route('site.complex.show', $resource->complex->alias) }}" class="button w-button">Подробнее —&gt;</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=673718a9aa664236cdc0b633" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://files.raketadesign.ru/files/sistema-repro/home.js" type="text/javascript"></script>
<script src="/js/webflow.js"></script>

@yield('scripts')

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(98482244, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/98482244" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

@include('site.components.select-city')
@include('site.components.lottie-banner')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Скрытие блока bad-wrap при клике на кнопку закрытия
    const badCloseBtn = document.querySelector('.bad-close');
    const badWrap = document.querySelector('.bad-wrap');
    
    if (badCloseBtn && badWrap) {
        badCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            badWrap.style.display = 'none';
        });
    }
});
</script>
</body>
</html>
