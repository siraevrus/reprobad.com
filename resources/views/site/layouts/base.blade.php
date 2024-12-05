<!DOCTYPE html>
<html data-wf-page="673718a9aa664236cdc0b634" data-wf-site="673718a9aa664236cdc0b633">
<head>
    <meta charset="utf-8">
    <title>{{ $resource->title ?? '' }}</title>
    <meta content="{{ $resource->description ?? '' }}" name="description">
    <meta content="{{ $resource->title ?? '' }}" property="og:title">
    <meta content="{{ $resource->description ?? '' }}" property="og:description">
    <meta content="{{ $resource->image ?? '' }}" property="og:image">
    <meta content="{{ $resource->title ?? '' }}" property="twitter:title">
    <meta content="{{ $resource->description ?? '' }}" property="twitter:description">
    <meta content="{{ $resource->image ?? '' }}" property="twitter:image">
    <meta property="og:type" content="website">
    <meta content="summary_large_image" name="twitter:card">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
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
    <style>
        :focus-visible { outline: var(--mandarin) auto 1px; }
        .bad-wrap { position: fixed; visibility: hidden; }
        .search-input:placeholder-shown ~ .search-button { display: none; }
        .cookies-banner { display: none; }
    </style>
    <script async="" src="https://files.raketadesign.ru/files/sistema-repro/head.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        .top-5-slider-dot { font-size: 0rem; width: 0.375rem; }
        .top-5-slider-dot.active { font-size: 0.875rem; min-width: 1.5rem }
        .top-5-slider-dot:has(+ .active ) { width: 0.75rem; }
        .top-5-slider-dot.active + .top-5-slider-dot { width: 0.75rem; }
        .questions-slider { overflow: visible; }
        .swiper-button-disabled { opacity: 0; pointer-events: none; }
        .swiper-3d .swiper-slide-shadow { background: rgba(244,187,174,0.25); }
    </style>
</head>
<body class="{{ isset($isHome) ? '' : 'lavender' }}">
<div class="w-embed">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
        html { font-size: 1.333125rem; }
        @media screen and (max-width:1920px) { html { font-size: calc(0.0009480702515177741rem + 1.1101474414570685vw); } }
        @media screen and (max-width:767px) { html { font-size: calc(-0.0026705287206266314rem + 4.27284595300261vw); } }
        html { overflow-y: scroll; overflow-x: hidden; height: -webkit-fill-available; }
        @supports (scrollbar-gutter: stable) { html { overflow-y: auto; scrollbar-gutter: stable; } }
        body { min-height: 100vh; min-height: -webkit-fill-available; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        @supports (font: -apple-system-body) and (-webkit-appearance: none) { img[loading="lazy"] { clip-path: inset(0.6px); } }
        .w-richtext > *:first-child { margin-top: 0; }
        .w-richtext > *:last-child { margin-bottom: 0; }
        .w-richtext figure img { border-radius: 1rem; }
        .w-richtext figure { --figure-width: 100%; width: var(--figure-width); max-width: var(--figure-width); }
        .w-richtext figure div, .w-richtext figure img { width: 100% !important; !important; max-width: 100% !important; }
        ul li::marker { color: var(--lavender); }
        .o-span{ visibility: hidden; }
        .o-span::after {
            position: absolute;
            display: inline;
            content: ' ';
            left: 0.05em;
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
        }
    </style>
</div>
<div data-animation="default" data-collapse="small" data-duration="400" data-easing="ease" data-easing2="ease" data-doc-height="1" role="banner" class="navbar w-nav">
    <div class="navbar-container w-container">
        <a href="index.html" aria-current="page" class="brand w-nav-brand w--current"><img src="images/lgog-gold.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
            <div>готовимся <br>к беременности <br>вместе</div>
        </a>
        <div class="nav-desktop-links">
            <a href="about.html" class="nav-quick-link">О системе РЕПРО</a>
            <a href="products.html" class="nav-quick-link">Продукты</a>
            <a href="useful-tips.html" class="nav-quick-link">Полезные советы</a>
            <a href="articles.html" class="nav-quick-link">Статьи</a>
            <a href="events.html" class="nav-quick-link">События</a>
        </div>
        @if(!isset($isHome))
            <a href="#" class="navbar-buy-button w-button">Купить</a>
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
                    <a href="products.html" class="nav-link hide-desktop">Продукты</a>
                    <a href="events.html" class="nav-link hide-desktop">События</a>
                    <a href="useful-tips.html" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="useful-tips.html" class="nav-link hide-desktop">Статьи</a>
                    <a href="map.html" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company.html" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts.html" class="nav-link">Контакты</a>
                </div>
            </nav>
        </div>
        <nav role="navigation" class="nav-menu w-nav-menu">
            <div class="nav-menu-wrap">
                <div class="nav-menu-links">
                    <a href="products.html" class="nav-link hide-desktop">Продукты</a>
                    <a href="events.html" class="nav-link hide-desktop">События</a>
                    <a href="useful-tips.html" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="useful-tips.html" class="nav-link hide-desktop">Статьи</a>
                    <a href="map.html" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company.html" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts.html" class="nav-link">Контакты</a>
                </div>
                <div class="nav-family-line"><img src="images/nav-family-line.svg" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
                <div class="nav-contacts">
                    <a href="tel:+74959567937" class="nav-contacts-phone">+7 495 956 79 37</a>
                    <a href="mailto:info@reproapotheka.ru" class="nav-contacts-email">info@reproapotheka.ru</a>
                    <a href="privacy.html" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
                </div>
            </div>
        </nav>
        <div class="menu-button w-nav-button">
            <div class="menu-button-icon w-icon-nav-menu"></div>
        </div>
    </div>
    @if(!isset($isHome))
        <div class="navbar-background"></div>
    @endif
</div>
<div class="heart-bg"><img src="images/heart_1.webp" loading="lazy" sizes="100vw" srcset="images/heart_1-p-500.webp 500w, images/heart_1-p-800.webp 800w, images/heart_1-p-1080.webp 1080w, images/heart_1-p-1600.webp 1600w, images/heart_1.webp 2000w" alt="" class="heart-bg-image"></div>

@yield('content')

<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=673718a9aa664236cdc0b633" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="js/webflow.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://files.raketadesign.ru/files/sistema-repro/home.js" type="text/javascript"></script>
</body>
</html>
