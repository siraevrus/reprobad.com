@extends('site.layouts.base')

@section('content')
    <section class="section product-hero-section product-section-clip">
        <div class="container product-hero-container {{ $resource->color }}">
            <div class="product-hero">
                <h1 class="product-h1 small">{!! $resource->title !!}</h1>
                <p class="product-descriptor">{{ $resource->subtitle }}</p>
                <p class="product-hero-p">{!! $resource->content !!}</p>
                <div class="product-buy-buttons">
                    <a href="{{ route('site.complex.show', $resource->alias) }}#first" class="button w-button">Подробнее —&gt;</a>
                </div>
                <div class="hero-products {{ $resource->color }}">
                    <a href="{{ route('site.complex.show', $resource->alias) }}#first" class="{{ $resource->title_left }} w-inline-block">
                        <div class="sache-image-element"><img src="{{ $resource->image_left }}" loading="lazy" alt="" class="sache-image"></div>
                        <div class="hero-product-shadow embrio"></div>
                    </a>
                    <a href="{{ route('site.complex.show', $resource->alias) }}#second" class="{{ $resource->title_right }} w-inline-block">
                        <div class="bottle-image-element"><img src="{{ $resource->image_right }}" alt="" loading="lazy" class="bottle-image"></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="product-hero-gradient"></div>
    </section>

    @if($resource->products)
        @php $idx = 1 @endphp
        @foreach($resource->products as $product)
            <section id="first" class="section product-section">
                <div class="container product-container">
                    <div class="product-head {{ $idx % 2 == 0 ? 'left-side' : '' }}">
                        <div class="product-head-logo"><img src="{{ $product->logo }}" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="repro-detoxi-logo"></div>
                        <p class="product-head-descriptor" style="color: {{ $product->color }}">{!! $product->description !!}</p>
                        <p class="product-head-text"> </p><img src="{{ $product->photo }}" loading="lazy" alt="" class="product-head-image {{ $idx % 2 == 0 ? 'right-side' : '' }}">
                        <div class="product-buy-buttons">
                            {{--
                            <a href="https://www.eapteka.ru" target="_blank" class="button w-button">Купить —&gt;</a>
                            --}}
                        </div>
                    </div>
                    <div class="product-body">
                        <div class="product-options">
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50"@endif>
                                <div>Описание</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->content !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50"@endif>
                                <div>Состав</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->includes !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50"@endif>
                                <div>Применение</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->usage !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block" @if($product->color)style="background-color: {{ $product->color }}50"@endif>
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
                <a href="{{ route('site.advises.index') }}" class="more-purple-button w-button">все <span class="only-mobile-text">советы и статьи </span>—&gt;</a>
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
@endsection
