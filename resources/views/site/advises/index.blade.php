@extends('site.layouts.base')

@section('content')
    <div class="page-background mandarin"></div>
    <section class="section inner-section">
        <div class="container">
            <div class="items-head">
                @if(!request()->get('query'))
                    <h1 class="inner-h1"><strong>Советы</strong> о совместной подготовке к успешному зачатию, беременности и улучшении здоровья</h1>
                @else
                    <h1 class="inner-h1"><strong>Найдено</strong> {{ $resources->total() }} материал(ов)</h1>
                @endif

                <form action="{{ route('site.advises.index') }}" class="search w-form">
                    <input class="search-input w-input" value="{{ request()->get('query') }}" autocomplete="off" maxlength="256" name="query" placeholder="Искать совет…" type="search" id="search" required="">
                    <img src="images/Search.svg" loading="lazy" alt="" class="search-icon">
                    <input type="submit" class="search-button w-button" value="—&gt;">
                </form>

                @if(!request()->get('query'))
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
                @endif

                <a href="#" class="mobile-search-button w-inline-block"><img src="images/Search.svg" loading="lazy" alt="" class="mobile-search-button-icon"></a>
            </div>
            <div class="items-wrap">
                @if(!$resources->count())
                    <div class="empty">
                        По Вашему запросу ничего не найдено
                    </div>
                @endif
                @foreach($resources as $idx => $item)
                    @if(in_array($idx, [0,1,2,3,4,5]))
                        <div class="news-card">
                            <div class="news-card-head">
                                <img src="{{ $item->image }}" loading="lazy" alt="" sizes="(max-width: 479px) 92vw, (max-width: 767px) 91vw, 46vw" srcset="{{ $item->image }} 500w, {{ $item->image }} 800w, {{ $item->image }} 960w" class="news-card-image">
                                <img src="{{ $item->icon ?? '' }}" loading="lazy" alt="" class="news-card-icon">
                            </div>
                            <div class="news-card-body">
                                <a href="{{ route($item->route_name ?? 'site.advises.show', $item->alias) }}" class="news-card-title">{{ $item->title }}</a>
                                <div class="news-card-text">{!! $item->description ?? '' !!}</div>
                            </div>
                            <div class="news-card-footer">
                                <a href="{{ route($item->route_name ?? 'site.advises.show', $item->alias) }}" class="card-button w-button">Подробнее —&gt;</a>
                                <div class="card-date-time">
                                    <div class="card-date">{{ $item->published_at }}</div>
                                    <div class="card-read"><img src="images/clock.svg" loading="lazy" alt="" class="clock-icon">
                                        <div>{{ $item->time }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            @if(isset($item->icon))
                                <div class="card-head">
                                    <img src="{{ $item->icon }}" loading="lazy" alt="" class="card-icon">
                                </div>
                            @endif
                            <div class="card-body">
                                <a href="{{ route($item->route_name ?? 'site.advises.show', $item->alias) }}" class="card-title">{{ $item->title }}</a>
                                <div class="card-text">{!! $item->description !!}</div>
                            </div>
                            <div class="card-footer">
                                <div class="card-date">{{ $item->published_at }}</div>
                                <div class="card-read"><img src="images/sm-clock.svg" loading="lazy" alt="" class="clock-icon">
                                    <div>{{ $item->time }}</div>
                                </div>
                                <a href="{{ route($item->route_name ?? 'site.advises.show', $item->alias) }}" class="card-link w-inline-block">
                                    <div class="text-block">Читать</div>
                                    <div class="card-link-arrow">—&gt;</div>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
                @include('site.components.subscribe-block')
            </div>
            <div class="spacer desktop-3-rem"></div>
            <div class="pages-wrap">
                <div class="pages">
                    {{ $resources->links() }}
                </div>
            </div>
            
            @if(request()->get('query') && isset($similarByCategory) && $similarByCategory->count() > 0)
            <div class="similar-section" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #e5e5e5;">
                <h2 class="big-section-h" style="margin-bottom: 1.5rem;"><strong>Похожие статьи и советы</strong></h2>
                <div class="items-wrap">
                    @foreach($similarByCategory as $item)
                        <div class="news-card">
                            <div class="news-card-head">
                                <img src="{{ $item->image ?? 'images/placeholder.jpg' }}" loading="lazy" alt="" sizes="(max-width: 479px) 92vw, (max-width: 767px) 91vw, 46vw" srcset="{{ $item->image ?? 'images/placeholder.jpg' }} 500w, {{ $item->image ?? 'images/placeholder.jpg' }} 800w, {{ $item->image ?? 'images/placeholder.jpg' }} 960w" class="news-card-image">
                                <img src="{{ $item->icon ?? '' }}" loading="lazy" alt="" class="news-card-icon">
                            </div>
                            <div class="news-card-body">
                                <a href="{{ route($item->route_name, $item->alias) }}" class="news-card-title">{{ $item->title }}</a>
                                <div class="news-card-text">{!! $item->description ?? '' !!}</div>
                            </div>
                            <div class="news-card-footer">
                                <a href="{{ route($item->route_name, $item->alias) }}" class="card-button w-button">Подробнее —&gt;</a>
                                <div class="card-date-time">
                                    <div class="card-date">{{ $item->published_at }}</div>
                                    <div class="card-read"><img src="images/clock.svg" loading="lazy" alt="" class="clock-icon">
                                        <div>{{ $item->time ?? '' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection
