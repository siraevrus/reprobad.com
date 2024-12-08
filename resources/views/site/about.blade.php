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
                    <div class="step-item"><img src="images/1.svg" loading="lazy" alt="" class="step-item-number">
                        <div class="step-item-content">
                            <h2 class="step-h">Психо-эмоциональное равновесие</h2>
                            <p class="step-description">Защита от стресса и нормализация сна</p>
                            <div class="step-products">
                                <a href="/product-protect#first" class="step-product-left w-inline-block">
                                    <div class="sache-image-element"><img src="images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 500w, images/1-1_ReproRelaks_Giperkortizol_sashe_11-1_ReproRelaks_Giperkortizol_sashe.avif 800w, images/1-1_ReproRelaks_Giperkortizol_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow"></div>
                                </a>
                                <a href="/product-protect#second" class="step-product-right w-inline-block">
                                    <div class="sache-image-element"><img src="images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 500w, images/1-2_ReproRelaks_Gipokortizol_sashe_11-2_ReproRelaks_Gipokortizol_sashe.avif 800w, images/1-2_ReproRelaks_Gipokortizol_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow gipokortizol"></div>
                                </a>
                            </div>
                            <a href="product-protect.html" class="step-button w-button">Подробнее —&gt;</a>
                        </div>
                        <div class="step-item-overlay"></div>
                    </div>
                    <div class="step-item _2"><img src="images/2.svg" loading="lazy" alt="" class="step-item-number">
                        <div class="step-item-content">
                            <h2 class="step-h">Очищение <br>организма</h2>
                            <p class="step-description">Нормализация кишечной микрофлоры и поддержка печени</p>
                            <div class="step-products">
                                <a href="/product-detoxi#first" class="step-product-left w-inline-block">
                                    <div class="sache-image-element"><img src="images/2-1_ReproDetoksi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 500w, images/2-1_ReproDetoksi_sashe_12-1_ReproDetoksi_sashe.avif 800w, images/2-1_ReproDetoksi_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow detoxi"></div>
                                </a>
                                <a href="/product-detoxi#second" class="step-product-right w-inline-block">
                                    <div class="sache-image-element"><img src="images/2-2_ReproBiom_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 500w, images/2-2_ReproBiom_sashe_12-2_ReproBiom_sashe.avif 800w, images/2-2_ReproBiom_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow biom"></div>
                                </a>
                            </div>
                            <a href="product-detoxi.html" class="step-button _2 w-button">Подробнее —&gt;</a>
                        </div>
                        <div class="step-item-overlay _2"></div>
                    </div>
                    <div class="step-item _3"><img src="images/3.svg" loading="lazy" alt="" class="step-item-number">
                        <div class="step-item-content">
                            <h2 class="step-h">Общий метаболизм и углеводный обмен</h2>
                            <p class="step-description">Коррекция энергетического обмена и нормализация метаболизма</p>
                            <div class="step-products">
                                <a href="/product-energy#first" class="step-product-left w-inline-block">
                                    <div class="sache-image-element"><img src="images/3-2_ReproMetabo_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 500w, images/3-2_ReproMetabo_sashe_13-2_ReproMetabo_sashe.avif 800w, images/3-2_ReproMetabo_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow metabo"></div>
                                </a>
                                <a href="/product-energy#second" class="step-product-right w-inline-block">
                                    <div class="sache-image-element"><img src="images/3-1_ReproEnerdzhi_sashe_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 500w, images/3-1_ReproEnerdzhi_sashe_13-1_ReproEnerdzhi_sashe.avif 800w, images/3-1_ReproEnerdzhi_sashe_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow energy"></div>
                                </a>
                            </div>
                            <a href="product-energy.html" class="step-button _3 w-button">Подробнее —&gt;</a>
                        </div>
                        <div class="step-item-overlay _3"></div>
                    </div>
                    <div class="step-item _4"><img src="images/4.svg" loading="lazy" alt="" class="step-item-number">
                        <div class="step-item-content">
                            <h2 class="step-h">Здоровая наследственность</h2>
                            <p class="step-description">Поддержка репродуктивного здоровья</p>
                            <div class="step-products">
                                <a href="/product-embrio#first" class="step-product-left repro-embrio w-inline-block">
                                    <div class="sache-image-element"><img src="images/4-1_ReproEmbrio_sahe-1_1.avif" loading="lazy" alt="" sizes="100vw" srcset="images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 500w, images/4-1_ReproEmbrio_sahe-1_14-1_ReproEmbrio_sahe-1.avif 800w, images/4-1_ReproEmbrio_sahe-1_1.avif 866w" class="sache-image"></div>
                                    <div class="step-product-shadow embrio"></div>
                                </a>
                                <a href="/product-embrio#second" class="step-product-right repro-genom w-inline-block">
                                    <div class="bottle-image-element"><img sizes="(max-width: 479px) 34vw, (max-width: 767px) 35vw, 9vw" srcset="images/4-2_ReproGenom_banka_14-2_ReproGenom_banka.avif 500w, images/4-2_ReproGenom_banka_1.avif 1122w" alt="" loading="lazy" src="images/4-2_ReproGenom_banka_1.avif" class="bottle-image"></div>
                                </a>
                            </div>
                            <a href="product-embrio.html" class="step-button _4 w-button">Подробнее —&gt;</a>
                        </div>
                        <div class="step-item-overlay _4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
