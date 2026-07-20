@extends('site.layouts.base')

@section('content')

    <section class="section">
        <div class="container">
            <div class="sistema-repro-heading products-page-heading">
                <h1 class="sistema-repro-h1">
                    <span class="sistema-repro-semibold">СИСТЕМА РЕПРО</span>
                    <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span>
                </h1>
                <p class="sistema-repro-p">
                    Современным трендом преконцепционной подготовки к успешному зачатию и вынашиванию
                    беременности является совместная подготовка пары и гармонизация здоровья женщины и мужчины
                </p>
            </div>
            <div class="spacer desktop-2-rem"></div>
            <div class="products-grid">
                @php $idx = 1 @endphp
                @foreach($resources as $product)
                    @if($product->complex->alias)
                        <div class="product-item">
                            <div class="product-item-content">
                                <div class="product-item-logo big">
                                    <img src="{{ $product->logo }}"
                                         loading="lazy" alt="{{ $product->logo_alt ?? $product->title }}"
                                         class="repro-relax-giper-logo">
                                </div>
                                <p class="product-item-text">
                                    {{ $product->description }}
                                </p>
                                <a href="{{ route('site.complex.show', $product->complex->alias) }}#{{ $product->alias }}" class="product-item-link w-inline-block">
                                    <div class="sache-image-element">
                                        <img src="{{ $product->image }}" loading="lazy" alt="{{ $product->image_alt ?? $product->title }}" class="sache-image">
                                    </div>
                                </a>
                                <div class="product-item-button-wrap" style="display: block">
                                    <a href="{{ route('site.complex.show', $product->complex->alias) }}#{{ $product->alias }}" class="button w-button">
                                        Подробнее —&gt;
                                    </a>

                                    @if($product->link)
                                    <div class="product-item-img" style="margin-top:20px">
                                        <a href="{{ $product->link }}" target="_blank">
                                            <img src="{{ asset('images/apteka.svg') }}" style="width:18rem;margin-top:1rem" alt="Купить в Eapteka">
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php $idx++ @endphp
                    @endif
                @endforeach
            </div>
            <div class="spacer desktop-3-rem"></div>
        </div>
    </section>
@endsection
