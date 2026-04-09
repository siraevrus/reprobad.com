@extends('site.layouts.base')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Система РЕПРО",
  "description": "Программа для нормализации дисбалансов при планировании беременности",
  "url": "{{ config('app.url') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": {
      "@type": "EntryPoint",
      "urlTemplate": "{{ config('app.url') }}/articles?query={search_term_string}"
    },
    "query-input": "required name=search_term_string"
  }
}
</script>
<style>
    .sistema-repro-semibold {
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="container">
        <div class="sistema-repro-heading">
            <p class="sistema-repro-p"><strong>Система РЕПРО</strong> - это программа, созданная для нормализации дисбалансов в организме человека, основанная на индивидуальных потребностях пары. Комбинации нутрицевтических ингредиентов подобраны с участием врача-репродуктолога на основе двадцатилетнего опыта работы с парами, планирующими беременность.</p>
            <h1 class="sistema-repro-h1"><span class="sistema-repro-semibold">СИСТЕМА РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span></h1>
            <p class="sistema-repro-steps-p">4 важных шага</p>
        </div>
        <div class="_4-steps-wrap">
            @foreach($complexes as $idx => $complex)
                @include('site.components.complex.item', ['item' => $complex])
            @endforeach
        </div>
        <div style="display:flex;justify-content:center;margin-top:20px">
            <a href="https://www.eapteka.ru/search/?q=репро" target="_blank">
                <img src="images/apteka.svg" style="width:30rem" alt="Купить в Eapteka">
            </a>
        </div>
    </div>
</section>

<section class="articles-section" style="margin-top:2rem">
    <div class="container articles-section-container">
        <div class="section-head-with-detali-button">
            <h2 class="big-section-h"><strong>Советы и статьи </strong>о совместной подготовке к успешному зачатию, беременности и улучшении здоровья</h2>
            <a href="{{ route('site.advises.index') }}" class="more-purple-button w-button">все <span class="only-mobile-text">советы и статьи </span>—&gt;</a>
        </div>
        <div class="items-wrap white-cards">
            @foreach($resources as $item)
                    @include('site.components.articles.item', ['item' => $item])
            @endforeach
            @include('site.components.subscribe-block')
        </div>
    </div>
</section>

<section class="widgets-section">
    <div class="container widgets-container">
        <div class="short-events"><img src="images/bg-cal.svg" loading="lazy" alt="иконка календарь" class="short-events-bg-image">
            <div class="section-head-with-detali-button short-events-section">
                <h2 class="big-section-h"><strong>События</strong> и&nbsp;мероприятия</h2>
                <a href="{{ route('site.events.index') }}" class="more-button w-button">все <span class="only-mobile-text">мероприятия </span>—&gt;</a>
            </div>
            @foreach($events as $item)
                @include('site.components.events.item', ['item' => $item])
            @endforeach
        </div>
        <div class="widgets-row widgets-row--repromenu-full">
            <div class="widgets-column widgets-column--full">
                <div data-w-id="8f4e031f-1a14-8225-f62f-dd5b11c6253e" class="widget widget-repro-menu widget-repro-menu--fullwidth">
                    <div class="widget-content">
                        <h2 class="widget-heading"><strong>РЕПРО</strong>меню</h2>
                        <p class="widget-p">Ваше репродуктивное здоровье начинается&nbsp;с тарелки: мы подготовили рецепты на всю&nbsp;неделю</p>
                        <div class="flex-spacer"></div>
                        <a href="{{ route('site.menus.index') }}" class="button w-button">Смотреть —&gt;</a>
                    </div>
                    <div class="repromenu-widget-images">
                        <img src="{{ asset('images/menu-2.webp') }}" loading="lazy" alt="" class="widget-image-3">
                        <img src="{{ asset('images/menu-3.webp') }}" loading="lazy" alt="" class="widget-image-2">
                        <img src="{{ asset('images/menu-4.webp') }}" loading="lazy" alt="" class="widget-image-1">
                    </div>
                </div>
            </div>
        </div>
        {{--
        <div class="widgets-column _2">
            <div class="questions-widget">
                <h2 class="widget-h"><strong>15 вопросов репродуктологу </strong><span class="inline-text-block">на первом приёме </span></h2>
                <div class="questions-slider">
                    <div class="questions-slider-wrap">
                        @foreach($questions as $item)
                        <div class="questions-slide">
                            <img src="{{ $item->icon }}" loading="lazy" alt="{{ $item->title }}" class="questions-slide-icon">
                            <div class="questions-slide-h">{{ $item->title }}</div>
                            <div class="questions-slide-text">
                                {{ $item->text }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="#" class="prev-slider-button w-inline-block"><img src="images/l-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                    <a href="/usefully-tips/etapy" class="button w-button">Узнать больше —&gt;</a>
                    <a href="#" class="next-slider-button w-inline-block"><img src="images/r-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                </div>
            </div>
            <div class="top-5-widget">
                <div class="top-5-overlay"></div>
                <div class="top-5-overlay right"></div>
                <h2 class="widget-h"><span class="inline-text-block"><strong>Этапы подготовки к ЭКО</strong></span></h2>
                <div class="top-5-slider">
                    <div class="top-5-slider-wrap">
                        @foreach($steps as $item)
                        <div class="top-5-slide">
                            <div>{{ $item->title }}</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="top-5-slider-pagination">
                        <div class="top-5-slider-dot active">1</div>
                        <div class="top-5-slider-dot">2</div>
                        <div class="top-5-slider-dot">3</div>
                        <div class="top-5-slider-dot">4</div>
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="#" class="prev-slider-button w-inline-block"><img src="images/l-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                    <a href="/usefully-tips/etapy" class="button w-button">Все способы —&gt;</a>
                    <a href="#" class="next-slider-button w-inline-block"><img src="images/r-arr.svg" loading="lazy" alt="" class="slider-arrow"></a>
                </div>
            </div>
        </div>
        --}}
    </div>
</section>


@endsection
