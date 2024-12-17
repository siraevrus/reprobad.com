@extends('site.layouts.base')

@section('content')
    <div class="page-background mandarin"></div>
    <section class="section inner-section">
        <div class="container">
            <div class="items-head">
                @if(!request()->get('query'))
                    <h1 class="inner-h1"><strong>Советы и статьи</strong> о совместной подготовке к успешному зачатию, беременности и улучшении здоровья</h1>
                @else
                    <h1 class="inner-h1"><strong>Найдено</strong> {{ $resources->count() }} материал(ов)</h1>
                @endif

                <form action="{{ route('site.advises.index') }}" class="search w-form">
                    <input class="search-input w-input" value="{{ request()->get('query') }}" autocomplete="off" maxlength="256" name="query" placeholder="Искать совет…" type="search" id="search" required="">
                    <img src="images/Search.svg" loading="lazy" alt="" class="search-icon">
                    <input type="submit" class="search-button w-button" value="—&gt;">
                </form>

                <div class="tags">
                    <a href="{{ route('site.articles.index') }}" class="tag {{ !request()->get('category') ? 'active' : '' }} w-inline-block">
                        <div class="tag-label">Все</div>
                        <div class="tag-number">{{ App\Models\Advise::query()->where('active', 1)->count() }}</div>
                    </a>
                    @foreach($categories as $item)
                        <a href="{{ route('site.advises.index', ['category' => $item['name']]) }}" class="tag {{ $item['name'] == request()->get('category') ? 'active' : '' }} w-inline-block">
                            <div class="tag-label">{{ $item['name'] }}</div>
                            <div class="tag-number">{{ $item['count'] }}</div>
                        </a>
                    @endforeach
                </div>
                <a href="#" class="mobile-search-button w-inline-block"><img src="images/Search.svg" loading="lazy" alt="" class="mobile-search-button-icon"></a>
            </div>
            <div class="items-wrap">
                @if(!$resources->count())
                    <div class="empty">
                        По Вашему запросу ничего не найдено
                    </div>
                @endif
                @foreach($resources as $idx => $item)
                    @if(in_array($idx, [0,1]))
                        <div class="news-card">
                            <div class="news-card-head">
                                <img src="{{ $item->image }}" loading="lazy" alt="" sizes="(max-width: 479px) 92vw, (max-width: 767px) 91vw, 46vw" srcset="{{ $item->image }} 500w, {{ $item->image }} 800w, {{ $item->image }} 960w" class="news-card-image">
                                <img src="{{ $item->ico->image ?? '' }}" loading="lazy" alt="" class="news-card-icon">
                            </div>
                            <div class="news-card-body">
                                <a href="{{ route('site.advises.show', $item->alias) }}" class="news-card-title">{{ $item->title }}</a>
                                <div class="news-card-text">{{ $item->description }}</div>
                            </div>
                            <div class="news-card-footer">
                                <a href="{{ route('site.advises.show', $item->alias) }}" class="card-button w-button">Подробнее —&gt;</a>
                                <div class="card-date-time">
                                    <div class="card-date">{{ $item->published_at }}</div>
                                    <div class="card-read"><img src="images/clock.svg" loading="lazy" alt="" class="clock-icon">
                                        <div>{{ $item->time }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @if($idx == 5)
                            <div class="socials-card">
                                <div class="socials-card-links">
                                    <a href="https://rutube.ru/channel/48557140/" target="_blank" class="card-social-link w-inline-block">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
                                            </svg></div>
                                    </a>
                                    <a href="https://t.me/reprobad" class="card-social-link w-inline-block">
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
                        @endif
                        <div class="card">
                            @if(isset($item->icon))
                                <div class="card-head">
                                    <img src="{{ $item->icon }}" loading="lazy" alt="" class="card-icon">
                                </div>
                            @endif
                            <div class="card-body">
                                <a href="{{ route('site.advises.show', $item->alias) }}" class="card-title">{{ $item->title }}</a>
                                <div class="card-text">{{ Str::limit($item->description, 150) }}</div>
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
                    @endif
                @endforeach
            </div>
            <div class="spacer desktop-3-rem"></div>
            <div class="pages-wrap">
                <div class="pages">
                    {{ $resources->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
