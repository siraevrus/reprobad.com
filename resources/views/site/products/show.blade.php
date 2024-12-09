@extends('site.layouts.base')

@section('content')
    <section class="section product-hero-section product-section-clip">
        <div class="container product-hero-container {{ $resource->color }}">
            <div class="product-hero">
                <h1 class="product-h1 small">{!! $resource->title !!}</h1>
                <p class="product-descriptor">{{ $resource->subtitle }}</p>
                <p class="product-hero-p">{!! $resource->text !!}</p>
                <div class="product-buy-buttons">
                    <a href="#first" class="button w-button">Подробнее —&gt;</a>
                </div>
                <div class="hero-products {{ $resource->color }}">
                    <a href="#first" class="{{ $resource->title_left }} w-inline-block">
                        <div class="sache-image-element"><img src="{{ $resource->image_left }}" loading="lazy" alt="" class="sache-image"></div>
                        <div class="hero-product-shadow embrio"></div>
                    </a>
                    <a href="#second" class="{{ $resource->title_right }} w-inline-block">
                        <div class="bottle-image-element"><img src="{{ $resource->image_right }}" alt="" loading="lazy" class="bottle-image"></div>
                    </a>
                </div>
            </div>
        </div>
        <div class="product-hero-gradient"></div>
    </section>
    <section id="first" class="section product-section">
        <div class="container product-container">
            <div class="product-head">
                <div class="product-head-logo"><img src="{{ $resource->logo }}" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="repro-detoxi-logo"></div>
                <p class="product-head-descriptor">{{ $resource->description }}</p>
                <p class="product-head-text"> </p><img src="{{ $resource->photo }}" loading="lazy" alt="" class="product-head-image">
                <div class="product-buy-buttons">
                    <a href="https://www.eapteka.ru" target="_blank" class="button w-button">Купить —&gt;</a>
                </div>
            </div>
            <div class="product-body">
                <div class="product-options">
                    <a href="#" class="product-options-tab w-inline-block">
                        <div>Описание</div>
                    </a>
                    <div class="product-options-tab-content">
                        <div class="product-options-content-wrap">
                            <div class="product-options-content">
                                {!! $resource->content !!}
                            </div>
                        </div>
                    </div>
                    <a href="#" class="product-options-tab w-inline-block">
                        <div>Состав</div>
                    </a>
                    <div class="product-options-tab-content">
                        <div class="product-options-content-wrap">
                            <div class="product-options-content">
                                {!! $resource->includes !!}
                            </div>
                        </div>
                    </div>
                    <a href="#" class="product-options-tab w-inline-block">
                        <div>Применение</div>
                    </a>
                    <div class="product-options-tab-content">
                        <div class="product-options-content-wrap">
                            <div class="product-options-content">
                                {!! $resource->usage !!}
                            </div>
                        </div>
                    </div>
                    <a href="#" class="product-options-tab w-inline-block">
                        <div>О продукте</div>
                    </a>
                    <div class="product-options-tab-content">
                        <div class="product-options-content-wrap">
                            <div class="product-options-content">
                                {!! $resource->about !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($resource->products)
        @foreach($products as $product)
            <section id="first" class="section product-section">
                <div class="container product-container">
                    <div class="product-head">
                        <div class="product-head-logo"><img src="{{ $product->logo }}" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="repro-detoxi-logo"></div>
                        <p class="product-head-descriptor">{{ $product->description }}</p>
                        <p class="product-head-text"> </p><img src="{{ $product->photo }}" loading="lazy" alt="" class="product-head-image">
                        <div class="product-buy-buttons">
                            <a href="https://www.eapteka.ru" target="_blank" class="button w-button">Купить —&gt;</a>
                        </div>
                    </div>
                    <div class="product-body">
                        <div class="product-options">
                            <a href="#" class="product-options-tab w-inline-block">
                                <div>Описание</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->content !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block">
                                <div>Состав</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->includes !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block">
                                <div>Применение</div>
                            </a>
                            <div class="product-options-tab-content">
                                <div class="product-options-content-wrap">
                                    <div class="product-options-content">
                                        {!! $product->usage !!}
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="product-options-tab w-inline-block">
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
        @endforeach
    @endif

    <section class="articles-section product-articles">
        <div class="container articles-section-container">
            <div class="section-head-with-detali-button">
                <h2 class="big-section-h product-articles-h"><strong>Полезные советы</strong> и статьи</h2>
                <a href="useful-tips.html" class="more-purple-button w-button">все <span class="only-mobile-text">советы и статьи </span>—&gt;</a>
            </div>
            <div class="items-wrap white-cards">
                @foreach($articles as $item)
                    <div class="card">
                            <div class="card-head">
                                <img src="{{ $item->ico->image ?? 'images/bolt.svg' }}" loading="lazy" alt="" class="card-icon">
                            </div>
                        <div class="card-body">
                            <a href="{{ route('site.articles.show', $item->alias) }}" class="card-title">{{ $item->title }}</a>
                            <div class="card-text">{{ Str::limit($item->description, 100) }}</div>
                        </div>
                        <div class="card-footer">
                            <div class="card-date">{{ $item->published_at }}</div>
                            <div class="card-read"><img src="images/sm-clock.svg" loading="lazy" alt="" class="clock-icon">
                                <div>{{ $item->time }}</div>
                            </div>
                            <a href="{{ route('site.articles.show', $item->alias) }}" class="card-link w-inline-block">
                                <div class="text-block">Читать</div>
                                <div class="card-link-arrow">—&gt;</div>
                            </a>
                        </div>
                    </div>
                @endforeach
                    <div class="socials-card">
                        <div class="socials-card-links">
                            <a href="{{ config('rutube') }}" target="_blank" class="card-social-link w-inline-block">
                                <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
                                    </svg></div>
                            </a>
                            <a href="{{ config('telegram') }}" class="card-social-link w-inline-block">
                                <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                                    </svg></div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="card-socials-title">Подпишитесь на нас в соцсетях</div>
                            <div class="card-text">Получайте быстрее статьи от наших редакторов, полезную информацию о событиях и мероприятиях в области репродуктологии</div>
                        </div>
                    </div>
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
                            <a href="product-detoxi.html" aria-current="page" class="step-button _2 w-button w--current">Подробнее —&gt;</a>
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
