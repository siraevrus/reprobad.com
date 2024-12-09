<!DOCTYPE html>
<html data-wf-page="673718a9aa664236cdc0b634" data-wf-site="673718a9aa664236cdc0b633">
<head>
    <meta charset="utf-8">
    <title>{{ isset($resource->title) ? strip_tags($resource->title) : '' }}</title>
    <meta content="{{ $resource->description ?? '' }}" name="description">
    <meta content="{{ isset($resource->title) ? strip_tags($resource->title) : '' }}" property="og:title">
    <meta content="{{ $resource->description ?? '' }}" property="og:description">
    <meta content="{{ $resource->image ?? '' }}" property="og:image">
    <meta content="{{ isset($resource->title) ? strip_tags($resource->title) : '' }}" property="twitter:title">
    <meta content="{{ $resource->description ?? '' }}" property="twitter:description">
    <meta content="{{ $resource->image ?? '' }}" property="twitter:image">
    <meta property="og:type" content="website">
    <base href="/">
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
<body class="{{ isset($isHome) ? '' : 'lavender' }} {{ $bodyClass ?? '' }}">
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
    <div class="navbar-overlay"></div>
    <div class="navbar-container w-container">
        <a href="/" aria-current="page" class="brand w-nav-brand w--current"><img src="images/lgog-gold.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
            <div>готовимся <br>к беременности <br>вместе</div>
        </a>
        <div class="nav-desktop-links">
            <a href="about" class="nav-quick-link">О системе РЕПРО</a>
            <a href="products" class="nav-quick-link">Продукты</a>
            <a href="usefully-tips" class="nav-quick-link">Полезные советы</a>
            <a href="articles" class="nav-quick-link">Статьи</a>
            <a href="events" class="nav-quick-link">События</a>
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
                    <a href="products" class="nav-link hide-desktop">Продукты</a>
                    <a href="events" class="nav-link hide-desktop">События</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="articles" class="nav-link hide-desktop">Статьи</a>
                    <a href="map" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                </div>
            </nav>
        </div>
        <nav role="navigation" class="nav-menu w-nav-menu">
            <div class="nav-menu-wrap">
                <div class="nav-menu-links">
                    <a href="products" class="nav-link hide-desktop">Продукты</a>
                    <a href="events" class="nav-link hide-desktop">События</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Статьи</a>
                    <a href="map" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                </div>
                <div class="nav-family-line"><img src="images/nav-family-line.svg" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
                <div class="nav-contacts">
                    <a href="tel:{{ str_replace([' ', ')', '(', '-'], '', config('phone')) }}" class="nav-contacts-phone">{{ config('phone') }}</a>
                    <a href="mailto:{{ config('email') }}" class="nav-contacts-email">{{ config('email') }}</a>
                    <a href="privacy" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
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
@if(isset($isHome) || isset($$bodyClass) && $bodyClass == 'products-page')
<div class="heart-bg">
    <img src="images/heart_1.webp" loading="lazy" sizes="100vw" srcset="images/heart_1-p-500.webp 500w, images/heart_1-p-800.webp 800w, images/heart_1-p-1080.webp 1080w, images/heart_1-p-1600.webp 1600w, images/heart_1.webp 2000w" alt="" class="heart-bg-image">
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
                <a href="{{ config('whatsapp') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
                        </svg></div>
                </a>
                <a href="{{ config('telegram') }}" class="social-link w-inline-block">
                    <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                            <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg></div>
                </a>
            </div>
            <div class="footer-slogan"><strong>Мы стараемся для вас, чтобы вы старались для них!</strong></div>
        </div>
        <div class="footer-menu">
            <div class="footer-menu-column">
                <a href="about" class="footer-menu-link">О системе РЕПРО</a>
                <a href="products" class="footer-menu-link">Продукты</a>
                <a href="events" class="footer-menu-link">События</a>
                <a href="usefully-tips" class="footer-menu-link">Полезные советы</a>
                <a href="articles" class="footer-menu-link">Статьи</a>
            </div>
            <div class="footer-menu-column">
                <a href="map.html" class="footer-menu-link">Где купить</a>
                <a href="company" aria-current="page" class="footer-menu-link w--current">О компании</a>
                <a href="faq" aria-current="page" class="footer-menu-link w--current">Вопросы-ответы</a>
                <a href="contacts" class="footer-menu-link">Контакты</a>
            </div>
            <a href="privacy" target="_blank" class="footer-terms-link">Политика конфиденциальности в отношении персональных данных</a>
        </div>
        <div class="r-farm-footer">
            <a href="https://www.r-pharm.com/ru" target="_blank" class="r-farm-footer-link w-inline-block"><img src="images/RFarm-footer.png" loading="lazy" alt="Р-Фарм" class="r-farm-image"></a>
            <div>{{ config('address') }}</div>
            <div>БАД. НЕ ЯВЛЯЕТСЯ ЛЕКАРСТВЕННЫМ СРЕДСТВОМ. ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. НЕОБХОДИМО ПРОКОНСУЛЬТИРОВАТЬСЯ СО СПЕЦИАЛИСТОМ.</div>
        </div>
    </div>
    <div class="bad-wrap">
        <div class="bad-container">
            <div class="bad-text"></div>
            <a href="#" class="bad-close w-inline-block"><img src="images/bad-close.svg" loading="lazy" alt="" class="bad-close-image"></a>
        </div>
    </div>
    <div class="cookies-banner">
        <div class="cookies-wrap">
            <div class="cookies">
                <div class="cookies-text">Этот веб-сайт использует файлы cookies, чтобы обеспечить удобную работу пользователей с ним и функциональные возможности сайта. Нажимая &quot;Я принимаю&quot; вы соглашаетесь с <a href="privacy.html" target="_blank" class="cookies-text-link">условиями использования файлов cookies</a>
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
                @foreach(App\Models\Product::all() as $resource)
                    <div class="product-item">
                        <div class="product-item-content">
                            <div class="product-item-logo big"><img src="{{ $resource->logo }}" loading="lazy" alt="" class="repro-relax-giper-logo"></div>
                            <p class="product-item-text">{{ $resource->description }}</p>
                            <a href="{{ route('site.products.show', $resource->alias) }}" class="product-item-link w-inline-block">
                                <div class="sache-image-element"><img src="{{ $resource->image }}" loading="lazy" alt="" class="sache-image"></div>
                                <div class="product-item-image-shadow"></div>
                            </a>
                            <div class="product-item-button-wrap">
                                <a href="{{ route('site.products.show', $resource->alias) }}" class="button w-button">Подробнее —&gt;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div data-animation="default" data-collapse="small" data-duration="400" data-easing="ease" data-easing2="ease" data-doc-height="1" role="banner" class="navbar w-nav">
    <div class="navbar-container w-container">
        <a href="/" class="brand w-nav-brand"><img src="images/lgog-gold.svg" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
            <div>готовимся <br>к беременности <br>вместе</div>
        </a>
        <div class="nav-desktop-links">
            <a href="about" class="nav-quick-link">О системе РЕПРО</a>
            <a href="products" class="nav-quick-link">Продукты</a>
            <a href="usefully-tips" class="nav-quick-link">Полезные советы</a>
            <a href="articles" class="nav-quick-link">Статьи</a>
            <a href="events" aria-current="page" class="nav-quick-link w--current">События</a>
        </div>
        <a href="#" class="navbar-buy-button w-button">Купить</a>
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
                    <a href="events" aria-current="page" class="nav-link hide-desktop w--current">События</a>
                    <a href="usefulyl-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Статьи</a>
                    <a href="map" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                </div>
            </nav>
        </div>
        <nav role="navigation" class="nav-menu w-nav-menu">
            <div class="nav-menu-wrap">
                <div class="nav-menu-links">
                    <a href="products" class="nav-link hide-desktop">Продукты</a>
                    <a href="events" aria-current="page" class="nav-link hide-desktop w--current">События</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Полезные советы</a>
                    <a href="usefully-tips" class="nav-link hide-desktop">Статьи</a>
                    <a href="map" class="nav-link">Где купить</a>
                    <div class="nav-link-divider"></div>
                    <a href="company" class="nav-link">О компании</a>
                    <div class="nav-link-divider"></div>
                    <a href="contacts" class="nav-link">Контакты</a>
                </div>
                <div class="nav-family-line"><img src="images/nav-family-line.svg" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
                <div class="nav-contacts">
                    <a href="tel:+74959567937" class="nav-contacts-phone">{{ config('phone') }}</a>
                    <a href="mailto:{{ config('email') }}" class="nav-contacts-email">{{ config('email') }}</a>
                    <a href="privacy" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
                </div>
            </div>
        </nav>
        <div class="menu-button w-nav-button">
            <div class="menu-button-icon w-icon-nav-menu"></div>
        </div>
    </div>
    <div class="navbar-background"></div>
</div>

<script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=673718a9aa664236cdc0b633" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="js/webflow.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://files.raketadesign.ru/files/sistema-repro/home.js" type="text/javascript"></script>

@yield('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Находим все формы
        const forms = document.querySelectorAll('form');

        forms.forEach((form) => {
            const formBlock = form.closest('div'); // Блок формы
            const successMessage = formBlock.querySelector('.success-message'); // Сообщение об успехе
            const errorMessage = formBlock.querySelector('.error-message'); // Сообщение об ошибке
            const closeButtons = formBlock.querySelectorAll('.close-popup-button'); // Кнопки закрытия

            // Закрытие формы и сообщений
            closeButtons.forEach((button) => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    form.reset(); // Сбрасываем данные формы
                    successMessage.style.display = 'none'; // Скрываем сообщение об успехе
                    errorMessage.style.display = 'none'; // Скрываем сообщение об ошибке
                    form.style.display = 'block'; // Показываем форму обратно
                });
            });

            // Обработка отправки формы
            form.addEventListener('submit', async (event) => {
                event.preventDefault(); // Отключаем стандартное поведение

                const formData = new FormData(form); // Собираем данные формы

                // Скрываем старые сообщения
                successMessage.style.display = 'none';
                errorMessage.style.display = 'none';

                try {
                    const response = await fetch(form.action, {
                        method: form.method || 'POST',
                        body: formData,
                    });

                    if (!response.ok) {
                        throw new Error(`Ошибка: ${response.statusText}`);
                    }

                    const result = await response.json();

                    if (result.success) {
                        form.style.display = 'none'; // Скрываем форму
                        successMessage.style.display = 'block'; // Показываем сообщение об успехе
                    } else {
                        throw new Error(result.message || 'Неизвестная ошибка');
                    }
                } catch (error) {
                    console.log(error);
                    errorMessage.style.display = 'block'; // Показываем сообщение об ошибке
                }
            });
        });
    });

</script>
<style>
    .step-item-overlay.green {
        background-color: #93b27866;
    }
    .step-item-overlay.mandarin {
        background-color: #ff967b66;
    }
    .step-item-overlay.purple {
        background-color: #9f99de66;
    }

    .step-item.mandarin {
        background-image: radial-gradient(circle at 0 0, #ff967b, #ff9a7e 24%, #ffe3cb);
    }

    .step-item.purple {
        background-image: radial-gradient(circle at 0 0, #9f99de, #a6a0e1 27%, #dedbf6);
    }

    .step-item.green {
        background-image: radial-gradient(circle at 0 0, #839f6a, #8fab77 20%, #ddface);
    }
</style>
</body>
</html>
