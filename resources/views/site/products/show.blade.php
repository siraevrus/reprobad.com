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
                            <div class="slider-container product-head-image {{ $idx % 2 == 0 ? 'right-side' : '' }}" x-data="slider{{ $product->id }}()">
                                <div class="slider-main">
                                    <img @click="currentImage = slides[currentIndex].url;open = true" x-show="!showVideo" :src="slides[currentIndex].url" alt="Main Image">
                                    <video :src="video" x-show="showVideo" controls></video>
                                </div>

                                <div class="modal" :class="{ 'active' : open }" @click="open = false">
                                    <div class="modal-close" @click="open = false">&times;</div>
                                    <div class="modal-content">
                                        <img :src="currentImage" alt="">
                                    </div>
                                </div>

                                <div class="slider-prev" @click="prevImage">
                                    <
                                </div>
                                <div class="slider-next" @click="nextImage">
                                    >
                                </div>

                                <div class="thumbnails">
                                    <template x-for="(image, index) in slides" :key="index">
                                        <img :src="image.url" :class="{'active': index === currentIndex}" @click="setCurrentIndex(index)">
                                    </template>

                                    <img @click="handleShowVideo" src="images/icons8-play-video-100.png" x-show="video" alt="">
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
    <style>
        .product-options-tab-content { display: none; }
        .product-options-tab-content.active { display: block; }
        @media screen and (max-width:767px) {
            .product-table-cell:not(:first-child) { display: none; }
            .product-table-cell.active { display: block; }
        }
    </style>
    <script>
        @if($resource->products)
        @foreach($resource->products as $product)
        function slider{{ $product->id }}() {
            return {
                slides: @json($product->images),
                currentIndex: 0,
                showVideo: false,
                video: @json($product->video),
                currentImage: '',
                open: false,

                handleShowVideo() {
                    this.showVideo = true;
                },
                setCurrentIndex(index) {
                    this.currentIndex = index;
                    this.showVideo = false;
                },
                prevImage() {
                    this.currentIndex = (this.currentIndex === 0) ? this.slides.length - 1 : this.currentIndex - 1;
                },
                nextImage() {
                    this.currentIndex = (this.currentIndex === this.slides.length - 1) ? 0 : this.currentIndex + 1;
                }
            };
        }
        @endforeach
        @endif
    </script>
    <style>
        .slider-container {
            margin: 0 auto;
            text-align: center;
        }
        .slider-prev,
        .slider-next {
            position: absolute;
            top: 0;
            bottom: 0;
            margin: auto;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            color: #000;
            cursor: pointer;
            line-height: 160%;
        }
        .slider-prev {
            left: 30px;
        }
        .slider-next {
            right: 30px;
        }
        .slider-main {
            position: relative;
            margin-bottom: 20px;
            height: 84%;
        }
        .slider-main img,
        .slider-main video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }
        .thumbnails {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .thumbnails img {
            width: 80px;
            height: 60px;
            object-fit: contain;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .thumbnails img:hover {
            transform: scale(1.1);
        }
        .thumbnails img.active {
            border: 2px solid #007bff;
        }
        .modal {
            position: fixed;
            z-index: -1;
            background: rgba(0,0,0,.4);
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            width: 700px;
            max-width: 100%;
            position: absolute;
            margin: auto;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
            height: max-content;
        }
        .modal-close {
            position: absolute;
            top: 20px;
            color: #fff;
            font-size: 60px;
            cursor: pointer;
            right: 20px;
            height: 40px;
            line-height: .55;
        }
        .modal.active {
            display: block;
            z-index: 100;
        }
    </style>

@endsection
