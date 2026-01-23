@extends('site.layouts.base')

@section('head')
@php
    $productSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => strip_tags($resource->title),
        'description' => strip_tags($resource->description ?? ''),
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Система РЕПРО'
        ],
        'offers' => [
            '@type' => 'Offer',
            'url' => 'https://www.eapteka.ru/search/?q=репро',
            'availability' => 'https://schema.org/InStock'
        ]
    ];
    
    if ($resource->image_left) {
        $productSchema['image'] = str_starts_with($resource->image_left, 'http') 
            ? $resource->image_left 
            : (config('app.url') . '/' . ltrim($resource->image_left, '/'));
    }
@endphp
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <section class="section product-hero-section product-section-clip">
        <div class="container product-hero-container {{ $resource->color }}">
            <div class="product-hero">
                <h1 class="product-h1 small">{!! $resource->title !!}</h1>
                <p class="product-descriptor">{{ $resource->subtitle }}</p>
                <p class="product-hero-p">{!! $resource->content !!}</p>
                {{--
                <div class="product-buy-buttons">
                    <a href="{{ route('site.complex.show', $resource->alias) }}#first" class="button w-button">Подробнее —&gt;</a>
                </div>
                --}}
                <div class="hero-products">
                    <a href="{{ route('site.complex.show', $resource->alias) }}#{{ $resource->anchor_left }}" class="{{ $resource->title_left }} w-inline-block">
                        <div class="sache-image-element"><img src="{{ $resource->image_left }}" loading="lazy" alt="{{ $resource->alt_left ?? $resource->title }}" class="sache-image"></div>
                    </a>
                    <a href="{{ route('site.complex.show', $resource->alias) }}#{{ $resource->anchor_right }}" class="{{ $resource->title_right }} w-inline-block">
                        @if($resource->id == 1)
                            <div class="bottle-image-element"><img src="{{ $resource->image_right }}" alt="{{ $resource->alt_right ?? $resource->title }}" loading="lazy" class="bottle-image"></div>
                        @else
                            <div class="sache-image-element"><img src="{{ $resource->image_right }}" alt="{{ $resource->alt_right ?? $resource->title }}" loading="lazy" class="sache-image"></div>
                        @endif
                    </a>
                </div>
            </div>
        </div>
        <div class="product-hero-gradient"></div>
    </section>

    @if($resource->products)
        @php $idx = 1 @endphp
        @foreach($resource->products as $product)
            <section id="{{ $product->alias }}" class="section product-section {{ $idx % 2 == 0 ? 'second' : '' }}">
                <div class="container product-container">
                    <div class="product-head {{ $idx % 2 == 0 ? 'left-side' : '' }}">
                        <div class="product-head-logo"><img src="{{ $product->logo }}" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="repro-detoxi-logo"></div>
                        <p class="product-head-descriptor" style="color: {{ $product->color }}">{!! $product->description !!}</p>
                        <p class="product-head-text"> </p>

                        @if($product->images)
                            <div class="slider-block product-head-image {{ $idx % 2 == 0 ? 'right-side' : '' }}">
                                <div class="main-slider main-slider{{ $product->id }}">
                                    @foreach($product->images as $image)
                                        <div class="">
                                            <a href="{{ $image['url'] }}" data-fslightbox="gallery{{ $product->id }}">
                                                <img src="{{ $image['url'] }}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="thumbs-slider thumbs-slider{{ $product->id }}" data-thumbs-gallery="gallery{{ $product->id }}">
                                    @foreach($product->images as $imageIndex => $image)
                                        <div class="thumb-item" data-thumb-index="{{ $imageIndex }}">
                                            <a href="{{ $image['url'] }}" data-fslightbox="gallery{{ $product->id }}" class="thumb-link" onclick="event.stopPropagation(); return true;">
                                                <img src="{{ $image['url'] }}" alt="">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <img src="{{ $product->photo }}" loading="lazy" alt="" class="product-head-image {{ $idx % 2 == 0 ? 'right-side' : '' }}">
                        @endif

                        <div class="product-buy-buttons">
                            @if($product->link)
                                <a href="{{ $product->link }}" target="_blank" class="button w-button">Купить —&gt;</a>
                            @endif
                        </div>
                    </div>
                    <div class="product-body">
                        <div class="product-options">
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50;border-color: {{ $product->color }}"@endif>
                                <div>Описание</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->content !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50;border-color: {{ $product->color }}"@endif>
                                <div>Состав</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->includes !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50;border-color: {{ $product->color }}"@endif>
                                <div>Применение</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->usage !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50;border-color: {{ $product->color }}"@endif>
                                <div>О продукте</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->about !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @php $idx++ @endphp
        @endforeach
    @endif

    <section class="articles-section product-articles {{ $resource->color ? 'background-' . $resource->color : '' }}">
        <div class="container articles-section-container">
            <div class="section-head-with-detali-button">
                <h2 class="big-section-h product-articles-h"><strong>Полезные советы</strong> и статьи</h2>
                <a href="{{ route('site.advises.index') }}" class="more-{{ $resource->color }}-button custom-button-product w-button" style="background-color: #fff;">все <span class="only-mobile-text">советы и статьи </span>—&gt;</a>
            </div>
            <div class="items-wrap white-cards">
                @foreach($articles as $item)
                    @include('site.components.articles.item', ['item' => $item])
                @endforeach
                @include('site.components.subscribe-block')
            </div>
        </div>
    </section>

    <section class="section sistema-section">
        <div class="container">
            <div class="sistema-repro-heading">
                <h1 class="sistema-repro-h1"><span class="sistema-repro-semibold">СИСТЕМА РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span></h1>
                <p class="sistema-repro-steps-p">4 важных шага</p>
            </div>
            <div>
                <div class="_4-steps-wrap">
                    @foreach($resources as $idx => $complex)
                        <div class="step-item {{ $complex->color }}"><img src="images/{{ $idx + 1 }}.svg" loading="lazy" alt="" class="step-item-number">
                            <div class="step-item-content">
                                <h2 class="step-h">{!! $complex->title !!}</h2>
                                <p class="step-description">{{ $complex->subtitle }}</p>
                                <div class="step-products">
                                    <a href="{{ route('site.complex.show', $complex->alias) }}#first" class="step-product-left w-inline-block">
                                        <div class="sache-image-element">
                                            <img src="{{ $complex->image_left }}" loading="lazy" alt="{{ $complex->alt_left ?? $complex->title }}" class="sache-image"></div>
                                        <div class="step-product-shadow"></div>
                                    </a>
                                    <a href="{{ route('site.complex.show', $complex->alias) }}#second" class="step-product-right w-inline-block">
                                        <div class="sache-image-element">
                                            <img src="{{ $complex->image_right }}" loading="lazy" alt="{{ $complex->alt_right ?? $complex->title }}" class="sache-image"></div>
                                        <div class="step-product-shadow gipokortizol"></div>
                                    </a>
                                </div>
                                <a href="{{ route('site.complex.show', $complex->alias) }}" class="step-button {{ $complex->color }} w-button">Подробнее —&gt;</a>
                            </div>
                            <div class="step-item-overlay {{ $complex->color }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="heart-bg sistema-section"><img sizes="100vw" srcset="images/heart-p-500.webp 500w, images/heart-p-800.webp 800w, images/heart-p-1080.webp 1080w, images/heart-p-1600.webp 1600w, images/heart-p-2000.webp 2000w, images/heart-p-2600.webp 2600w, images/heart-p-3200.webp 3200w, images/heart.webp 3868w" alt="" src="images/heart.webp" loading="lazy" class="heart-bg-image hbgi-sistema"></div>
    </section>
@endsection

@section('scripts')
    {{-- Временно отключаем внешний скрипт, так как он конфликтует с нашим кодом --}}
    {{-- <script src="https://files.raketadesign.ru/files/sistema-repro/product.js" type="text/javascript"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js" integrity="sha512-03Ucfdj4I8Afv+9P/c9zkF4sBBGlf68zzr/MV+ClrqVCBXWAsTEjIoGCMqxhUxv1DGivK7Bm1IQd8iC4v7X2bw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .product-options-tab-content { display: none; }
        .product-options-tab-content.active { display: block; }
        @media screen and (max-width:767px) {
            .product-table-cell:not(:first-child) { display: none; }
            .product-table-cell.active { display: block; }
        }
        /* Исправление проблемы с кликабельностью кнопок */
        .product-body {
            position: relative;
            z-index: 10;
        }
        .product-options {
            position: relative;
            z-index: 10;
        }
        .product-options-tab {
            position: relative;
            z-index: 11;
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        .product-head-image {
            pointer-events: none;
        }
        .product-head-image .slider-block,
        .product-head-image .main-slider,
        .product-head-image [data-controls],
        .product-head-image .tns-controls {
            pointer-events: auto;
        }
        /* Опускаем изображения продуктов в верхнем блоке на 23px */
        .hero-products .sache-image-element,
        .hero-products .bottle-image-element {
            margin-top: 23px;
        }
        /* Опускаем правое изображение еще на 20px */
        .hero-products > a:nth-child(2) .sache-image-element,
        .hero-products > a:nth-child(2) .bottle-image-element {
            margin-top: 43px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <style>
        .main-slider img {
            max-height: 20rem;
            margin: auto;
            display: block;
        }
        .thumbs-slider {
            display: flex;
            justify-content: center;
        }
        .thumbs-slider div {
            padding: 10px;
        }
        .thumbs-slider a {
            display: block;
            cursor: pointer;
            opacity: .5;
            transition: opacity 0.2s ease;
            pointer-events: auto !important;
            position: relative;
            z-index: 10;
        }
        .thumbs-slider a:hover {
            opacity: .8;
        }
        .thumbs-slider img {
            height: 80px;
            display: block;
            pointer-events: none;
        }
        .thumbs-slider .tns-nav-active a {
            opacity: 1;
        }
        .thumbs-slider div {
            pointer-events: auto !important;
        }
        [data-controls="prev"],
        [data-controls="next"] {
            position: absolute;
            top: 0;
            bottom: 0;
            background: none;
            z-index: 99;
            font-size: 0;
            margin: auto;
            width: 100px;
            height: 50px;
            cursor: pointer;
            pointer-events: auto;
            transition: transform 0.15s ease-in-out;
        }
        /* Анимация уменьшения при нажатии */
        [data-controls="prev"]:active,
        [data-controls="next"]:active {
            transform: scale(0.85);
        }
        [data-controls="next"] {
            right: 0;
        }
        [data-controls="prev"]:after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            background-image: url('/images/left-arrow.svg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            pointer-events: none;
        }
        [data-controls="next"]:after {
            content: "";
            display: block;
            width: 100%;
            height: 100%;
            background-image: url('/images/right-arrow.svg');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            pointer-events: none;
        }
        @media (max-width: 600px) {
            [data-controls="prev"],
            [data-controls="next"] {
                width: 2rem;
                height: 3rem;
                line-height: .4;
                bottom: auto;
                top: 33%;
            }
        }
    </style>
    <script>
        @if($resource->products)

        @foreach($resource->products as $product)

        const mainSlider{{ $product->id }} = tns({
            container: '.main-slider{{ $product->id }}',
            items: 1,
            controls: true,
            navContainer: '.thumbs-slider{{ $product->id }}',
            navAsThumbnails: true,
            mouseDrag: true,
            autoplay: false,
            slideBy: 'page',
        });
        
        // Обработчик кликов на миниатюры для открытия галереи
        document.addEventListener('DOMContentLoaded', function() {
            const thumbs{{ $product->id }} = document.querySelectorAll('.thumbs-slider{{ $product->id }} .thumb-link');
            thumbs{{ $product->id }}.forEach(function(thumbLink, index) {
                thumbLink.addEventListener('click', function(e) {
                    // Предотвращаем переключение слайдера при клике на миниатюру
                    e.stopPropagation();
                    
                    // Находим соответствующую ссылку в main-slider и открываем галерею
                    const mainSliderLinks = document.querySelectorAll('.main-slider{{ $product->id }} a[data-fslightbox="gallery{{ $product->id }}"]');
                    if (mainSliderLinks[index]) {
                        // Программно кликаем на соответствующую ссылку в main-slider
                        mainSliderLinks[index].click();
                    }
                });
            });
        });

        @endforeach

        @endif

        // Добавляем анимацию уменьшения при клике на кнопки навигации слайдера
        document.addEventListener('DOMContentLoaded', function() {
            const navButtons = document.querySelectorAll('[data-controls="prev"], [data-controls="next"]');
            
            navButtons.forEach(function(button) {
                button.addEventListener('mousedown', function() {
                    this.style.transform = 'scale(0.85)';
                });
                
                button.addEventListener('mouseup', function() {
                    this.style.transform = 'scale(1)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
                
                // Для touch устройств
                button.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.85)';
                });
                
                button.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            });
            
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-head-image').forEach(el => {
                el.classList.add('visible');
            });

            // Обработчик для кнопок вкладок продукта
            function initProductTabs() {
                // Проверяем наличие элементов
                const tabs = document.querySelectorAll('.product-options-tab');
                if (tabs.length === 0) {
                    console.log('Кнопки вкладок не найдены, повторная попытка через 100мс');
                    setTimeout(initProductTabs, 100);
                    return;
                }
                
                if (typeof $ !== 'undefined') {
                    // Удаляем все старые обработчики
                    $('.product-options-tab').off('click tap');
                    
                    // Добавляем обработчики напрямую к элементам (не через делегирование)
                    $('.product-options-tab').each(function() {
                        const $tab = $(this);
                        
                        // Удаляем старые обработчики
                        $tab.off('click tap');
                        
                        // Добавляем новый обработчик
                        $tab.on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                            
                            const $clickedTab = $(this);
                            const needClose = $clickedTab.hasClass('active');
                            const $wrap = $clickedTab.closest('.product-body');
                            
                            if (!$wrap.length) {
                                console.log('Не найден .product-body');
                                return false;
                            }
                            
                            // Убираем активный класс со всех кнопок и контента
                            $wrap.find('.product-options-tab, .product-options-tab-content').removeClass('active');
                            
                            // Если кнопка уже была активна, просто закрываем
                            if (needClose) return false;
                            
                            // Находим следующий элемент контента после кнопки
                            const $nextContent = $clickedTab.next('.product-options-tab-content');
                            
                            if ($nextContent.length) {
                                $clickedTab.addClass('active');
                                $nextContent.addClass('active');
                            } else {
                                // Fallback: используем индекс
                                const $tabs = $wrap.find('.product-options-tab');
                                const $tabsContent = $wrap.find('.product-options-tab-content');
                                const index = $tabs.index($clickedTab);
                                
                                if (index >= 0 && index < $tabsContent.length) {
                                    $clickedTab.addClass('active');
                                    $tabsContent.eq(index).addClass('active');
                                }
                            }
                            
                            return false;
                        });
                    });
                    
                    // Активируем первую вкладку по умолчанию
                    $('.product-body').each(function() {
                        const $wrap = $(this);
                        const $firstTab = $wrap.find('.product-options-tab').first();
                        const $firstContent = $wrap.find('.product-options-tab-content').first();
                        if ($firstTab.length && $firstContent.length) {
                            $firstTab.addClass('active');
                            $firstContent.addClass('active');
                        }
                    });
                } else {
                    // Fallback на vanilla JS
                    document.querySelectorAll('.product-options-tab').forEach(function(tab) {
                        // Удаляем старые обработчики
                        const newTab = tab.cloneNode(true);
                        tab.parentNode.replaceChild(newTab, tab);
                        
                        newTab.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            const productBody = this.closest('.product-body');
                            if (!productBody) return;
                            
                            const needClose = this.classList.contains('active');
                            const tabs = Array.from(productBody.querySelectorAll('.product-options-tab'));
                            const tabsContent = Array.from(productBody.querySelectorAll('.product-options-tab-content'));
                            
                            tabs.forEach(function(t) { t.classList.remove('active'); });
                            tabsContent.forEach(function(c) { c.classList.remove('active'); });
                            
                            if (needClose) return;
                            
                            // Находим следующий элемент контента после кнопки
                            let nextElement = this.nextElementSibling;
                            while (nextElement && !nextElement.classList.contains('product-options-tab-content')) {
                                nextElement = nextElement.nextElementSibling;
                            }
                            
                            if (nextElement && nextElement.classList.contains('product-options-tab-content')) {
                                this.classList.add('active');
                                nextElement.classList.add('active');
                            } else {
                                // Fallback: используем индекс
                                const index = tabs.indexOf(this);
                                if (index >= 0 && index < tabsContent.length) {
                                    this.classList.add('active');
                                    tabsContent[index].classList.add('active');
                                }
                            }
                        });
                    });
                    
                    document.querySelectorAll('.product-body').forEach(function(productBody) {
                        const firstTab = productBody.querySelector('.product-options-tab');
                        const tabsContent = Array.from(productBody.querySelectorAll('.product-options-tab-content'));
                        if (firstTab && tabsContent.length > 0) {
                            firstTab.classList.add('active');
                            tabsContent[0].classList.add('active');
                        }
                    });
                }
            }
            
            // Выполняем после полной загрузки страницы
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(initProductTabs, 300);
                });
            } else {
                setTimeout(initProductTabs, 300);
            }
            
            // Также выполняем после загрузки Webflow, если он есть
            if (typeof Webflow !== 'undefined') {
                Webflow.push(function() {
                    setTimeout(initProductTabs, 100);
                });
            }
            
            // Дополнительная проверка после полной загрузки
            window.addEventListener('load', function() {
                setTimeout(initProductTabs, 500);
            });
        });

    </script>

@endsection
