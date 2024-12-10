@extends('site.layouts.base')

@section('content')
    @foreach($resource->content as $block)
        @if($block['type'] == 'block13' && !$block['hide'])
            <section class="section about-page-hero">
                <div class="container about-page-container">
                    <h1 class="about-repro-h1"><span class="sistema-repro-semibold">{{ $block['data']['title'] }}</span><span class="o-span about-o"><strong>О</strong></span> <span class="about-repro-h1-descriptor">{{ $block['data']['subtitle'] }}</span></h1>
                </div><img src="{{ $block['data']['image'] }}" loading="lazy" alt="" class="about-hero-img">
            </section>
        @elseif($block['type'] == 'block14' && !$block['hide'])
            <section class="section">
                <div class="container about-flex-container">
                    <h2 class="about-h2">{{ $block['data']['title'] }}</h2>
                    <p class="about-p">{{ $block['data']['col1'] }}</p>
                    <p class="about-p">{{ $block['data']['col2'] }}</p>
                </div>
            </section>
        @elseif($block['type'] == 'block15' && !$block['hide'])
            <section class="section about-schema-section">
                <div class="container about-schema-container">
                    @if($block['data']['title'])<h2 class="about-schema-h2"><strong>{{ $block['data']['title'] }}</strong></h2>@endif
                    @if($block['data']['subtitle'])<p class="about-schema-p">{!! $block['data']['subtitle'] !!}</p>@endif
                    @if($block['data']['image'])<img src="{{ $block['data']['image'] }}" loading="lazy" alt="" class="about-schema">@endif
                    @if($block['data']['image'])<img src="{{ $block['data']['image'] }}" loading="lazy" alt="" class="about-schema mob">@endif
                    @if($block['data']['text'])<p class="about-schema-p">{!! $block['data']['text'] !!}</p>@endif
                </div>
            </section>
        @endif
    @endforeach


    <section class="section sistema-section">
        <div class="container">
            <div>
                <div class="_4-steps-wrap">
                    @foreach($products as $idx => $product)
                        <div class="step-item {{ $product->color }}"><img src="images/{{ $idx + 1 }}.svg" loading="lazy" alt="" class="step-item-number">
                            <div class="step-item-content">
                                <h2 class="step-h">{!! $product->title !!}</h2>
                                <p class="step-description">{{ $product->subtitle }}</p>
                                <div class="step-products">
                                    <a href="{{ route('site.complex.show', $product->alias) }}#first" class="step-product-left w-inline-block">
                                        <div class="sache-image-element">
                                            <img src="{{ $product->image_left }}" loading="lazy" alt="" class="sache-image"></div>
                                        <div class="step-product-shadow"></div>
                                    </a>
                                    <a href="{{ route('site.complex.show', $product->alias) }}#second" class="step-product-right w-inline-block">
                                        <div class="sache-image-element">
                                            <img src="{{ $product->image_right }}" loading="lazy" alt="" class="sache-image"></div>
                                        <div class="step-product-shadow gipokortizol"></div>
                                    </a>
                                </div>
                                <a href="{{ route('site.complex.show', $product->alias) }}" class="step-button {{ $product->color }} w-button">Подробнее —&gt;</a>
                            </div>
                            <div class="step-item-overlay {{ $product->color }}"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
