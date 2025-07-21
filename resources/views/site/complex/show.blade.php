@extends('site.layouts.base')

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
                        <div class="sache-image-element"><img src="{{ $resource->image_left }}" loading="lazy" alt="" class="sache-image"></div>
                    </a>
                    <a href="{{ route('site.complex.show', $resource->alias) }}#{{ $resource->anchor_right }}" class="{{ $resource->title_right }} w-inline-block">
                        @if($resource->id == 1)
                            <div class="bottle-image-element"><img src="{{ $resource->image_right }}" alt="" loading="lazy" class="bottle-image"></div>
                        @else
                            <div class="sache-image-element"><img src="{{ $resource->image_right }}" alt="" loading="lazy" class="sache-image"></div>
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
                                <div class="thumbs-slider thumbs-slider{{ $product->id }}">
                                    @foreach($product->images as $image)
                                        <div class="">
                                            <img src="{{ $image['url'] }}" alt="">
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
                                            <img src="{{ $complex->image_left }}" loading="lazy" alt="" class="sache-image"></div>
                                        <div class="step-product-shadow"></div>
                                    </a>
                                    <a href="{{ route('site.complex.show', $complex->alias) }}#second" class="step-product-right w-inline-block">
                                        <div class="sache-image-element">
                                            <img src="{{ $complex->image_right }}" loading="lazy" alt="" class="sache-image"></div>
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
    <script src="https://files.raketadesign.ru/files/sistema-repro/product.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.0.9/index.min.js" integrity="sha512-03Ucfdj4I8Afv+9P/c9zkF4sBBGlf68zzr/MV+ClrqVCBXWAsTEjIoGCMqxhUxv1DGivK7Bm1IQd8iC4v7X2bw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .product-options-tab-content { display: none; }
        .product-options-tab-content.active { display: block; }
        @media screen and (max-width:767px) {
            .product-table-cell:not(:first-child) { display: none; }
            .product-table-cell.active { display: block; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script>
    <style>
        .main-slider img {
            height: 280px;
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
        .thumbs-slider img {
            height: 80px;
        }
        .thumbs-slider div {
            opacity: .5;
            cursor: pointer;
        }
        .thumbs-slider .tns-nav-active {
            opacity: 1;
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
        }
        [data-controls="next"] {
            right: 0;
        }
        [data-controls="prev"]:after {
            content: "<";
            font-size: 40px;
        }
        [data-controls="next"]:after {
            content: ">";
            font-size: 40px;
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

        @endforeach

        @endif

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.product-head-image').forEach(el => {
                el.classList.add('visible');
            });
        });

    </script>

@endsection
