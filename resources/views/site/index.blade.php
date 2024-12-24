@extends('site.layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <div class="sistema-repro-heading">
            <p class="sistema-repro-p"><strong>Система РЕПРО</strong> - это программа, созданная для нормализации дисбалансов в организме человека, основанная на индивидуальных потребностях пары. Комбинации нутрицевтических ингредиентов подобраны с участием врача-репродуктолога на основе 20-ти летнего опыта работы с парами, планирующими беременность. </p>
            <h1 class="sistema-repro-h1"><span class="sistema-repro-semibold">СИСТЕМА РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="sistema-repro-h1-descriptor">подготовка пары к беременности</span></h1>
            <p class="sistema-repro-steps-p">4 важных шага</p>
        </div>
        <div class="_4-steps-wrap">
            @foreach($complexes as $idx => $complex)
                @include('site.components.complex.item', ['item' => $complex])
            @endforeach
        </div>
    </div>
</section>

<section class="articles-section" style="margin-top:2rem">
    <div class="container articles-section-container">
        <div class="section-head-with-detali-button">
            <h2 class="big-section-h"><strong>Советы и статьи </strong>о совместной подготовке к успешному зачатию, беременности и улучшению здоровья</h2>
            <a href="{{ route('site.advises.index') }}" class="more-purple-button w-button">все <span class="only-mobile-text">советы и статьи </span>—&gt;</a>
        </div>
        <div class="items-wrap white-cards">
            @foreach($resources as $idx => $item)
                @if($idx == 3)
                    @include('site.components.subscribe-block')
                    @include('site.components.articles.item', ['item' => $item])
                @else
                    @include('site.components.articles.item', ['item' => $item])
                @endif
            @endforeach
        </div>
    </div>
</section>

<section class="widgets-section">
    <div class="container widgets-container">
        <div class="short-events"><img src="images/bg-cal.svg" loading="lazy" alt="" class="short-events-bg-image">
            <div class="section-head-with-detali-button short-events-section">
                <h2 class="big-section-h"><strong>Ближайшие</strong>&nbsp;мероприятия</h2>
                <a href="{{ route('site.events.index') }}" class="more-button w-button">все <span class="only-mobile-text">мероприятия </span>—&gt;</a>
            </div>
            @foreach($events as $item)
                @include('site.components.events.item', ['item' => $item])
            @endforeach
        </div>
        <div class="widgets-column">
            <form class="map-widget" action="{{ route('site.map') }}">
                <h2 class="widget-h"><strong>Купить СИСТЕМУ РЕПРО</strong> <span class="inline-text-block">в ближайшей к вам аптеке</span></h2><img src="images/widget-map.webp" loading="lazy" sizes="(max-width: 767px) 100vw, 33vw" srcset="images/widget-map-p-500.webp 500w, images/widget-map.webp 680w" alt="" class="map-widget-image">
                <div class="map-widget-input-wrap"><input type="text" name="search" placeholder="Ваш адрес" autocomplete="off" class="input">
                    <button type="submit" class="map-widget-button w-button"><span class="hide-on-mobile">Найти </span>—&gt;</button>
                </div>
            </form>
            <div class="shpargalka-widget">
                <h2 class="widget-h"><strong>Шпаргалка: каких врачей нужно пройти </strong>перед процедурой ЭКО</h2><img src="images/shpargalka.webp" loading="lazy" sizes="(max-width: 767px) 91vw, 49vw" srcset="images/shpargalka-p-500.webp 500w, images/shpargalka-p-800.webp 800w, images/shpargalka.webp 900w" alt="" class="shpargalka-image">
                <div class="shpargalka-docs">
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Терапевт</strong> анализы крови, ЭКГ</div>
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Эндокринолог </strong>анализ крови на гормоны и УЗИ щитовидной железы</div>
                    <div class="shpargalka-doc"><strong class="shpargalka-doc-title">Маммолог</strong> женщинам до 40 лет УЗИ молочных желез на 6-10 день цикла, после 40 маммография в 1 фазе цикла</div>
                </div>
                <div class="shpargalka-list">
                    <div class="shpargalka-list-item"><img src="images/man.svg" loading="lazy" alt="" class="shpargalka-list-icon">
                        <div><strong>Для мужа: </strong>консультация андролога является обязательной <br>при наличии мужского фактора бесплодия</div>
                    </div>
                    <div class="shpargalka-list-item"><img src="images/Plus-Circle.svg" loading="lazy" alt="" class="shpargalka-list-icon">
                        <div><strong>Консультации специалистов, </strong>которые могут быть рекомендованы: психолог, гематолог, генетик, онколог, иммунолог, кардиолог</div>
                    </div>
                </div>
                <div class="widget-footer">
                    <a href="{{ route('site.articles.index') }}" class="button w-button">Подробнее —&gt;</a>
                </div>
            </div>
        </div>
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
                    {{--
                    <a href="/usefully-tips/etapy" class="button w-button">Узнать больше —&gt;</a>
                    --}}
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
    </div>
</section>
@endsection
