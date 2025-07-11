@extends('site.layouts.base')

@section('content')

    <section class="section">
        <div class="container">
            <div class="sistema-repro-heading products-page-heading">
                <h1 class="sistema-repro-h1">
                    <span class="sistema-repro-semibold">СИСТЕМА РЕПР</span>
                    <span class="o-span"><strong>О</strong></span>
                    <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span>
                </h1>
                <p class="sistema-repro-p">
                    Современным трендом преконцептуальной подготовки к успешному зачатию и вынашиванию
                    беременности является совместная подготовка пары и гармонизация здоровья женщины и мужчины
                </p>
            </div>
            <div class="spacer desktop-2-rem"></div>
            <div class="products-grid">
                @php $idx = 1 @endphp
                @foreach($resources as $resource)
                    @if($resource->complex->alias)
                        <div class="product-item">
                            <div class="product-item-content">
                                <div class="product-item-logo big">
                                    <img src="{{ $resource->logo }}"
                                         loading="lazy" alt=""
                                         class="repro-relax-giper-logo">
                                </div>
                                <p class="product-item-text">
                                    {{ $resource->description }}
                                </p>
                                <a href="{{ route('site.complex.show', $resource->complex->alias) }}#{{ $resource->alias }}" class="product-item-link w-inline-block">
                                    <div class="sache-image-element">
                                        <img src="{{ $resource->image }}" loading="lazy" alt="" class="sache-image">
                                    </div>
                                </a>
                                <div class="product-item-button-wrap" style="display: block">
                                    <a href="{{ route('site.complex.show', $resource->complex->alias) }}#{{ $resource->alias }}" class="button w-button">
                                        Подробнее —&gt;
                                    </a>

                                    <div class="product-item-img" style="margin-top:20px">
                                        <a href="https://www.eapteka.ru/search/?q=репро" target="_blank">
                                            <img src="/images/apteka.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $idx++ @endphp
                    @endif
                @endforeach
            </div>
            <div class="spacer desktop-3-rem"></div>
            <div style="display:flex;justify-content:center;margin-top:20px">
                <img src="images/apteka.png" alt="">
            </div>
        </div>
    </section>
@endsection
