@extends('site.layouts.base')

@section('head')
@php
    $paginationCurrentPage = $resources->currentPage();
    $paginationLastPage = $resources->lastPage();
    $paginationQuery = request()->query();
@endphp
@if($paginationLastPage > 1)
    @if($paginationCurrentPage > 1)
        <link rel="prev" href="{{ route('site.events.index', array_merge($paginationQuery, ['page' => $paginationCurrentPage - 1])) }}">
    @endif
    @if($paginationCurrentPage < $paginationLastPage)
        <link rel="next" href="{{ route('site.events.index', array_merge($paginationQuery, ['page' => $paginationCurrentPage + 1])) }}">
    @endif
@endif
<style>
    .items-wrap.gap-0 .events-card {
        min-height: 12.675rem;
        padding-top: 1.95rem;
        padding-bottom: 1.95rem;
        grid-row-gap: 0.65rem;
        grid-column-gap: 0.65rem;
    }

    .items-wrap.gap-0 .events-card-head {
        grid-row-gap: 0.325rem;
        grid-column-gap: 0.325rem;
    }

    .items-wrap.gap-0 .events-card-body {
        grid-row-gap: 0.65rem;
        grid-column-gap: 0.65rem;
    }

    @media screen and (max-width: 767px) {
        .items-wrap.gap-0 .events-card {
            min-height: 0;
            padding: 0.65rem 0.65rem 0;
            grid-row-gap: 0.325rem;
            grid-column-gap: 0.325rem;
        }
    }
</style>
@endsection

@section('content')
    <div class="page-background mandarin"></div>
    <section class="section inner-section">
        <div class="container">
            <div class="items-head">
                @if(!request()->get('query'))
                    <h1 class="inner-h1 events-h1"><strong>События</strong> и мероприятия</h1>
                @else
                    <h1 class="inner-h1 events-h1"><strong>Найдено</strong> {{ $resources->total() }} событий</h1>
                @endif
                <form action="{{ route('site.events.index') }}" class="search w-form">
                    <input class="search-input w-input" value="{{ request()->get('query') }}" autocomplete="off" maxlength="256" name="query" placeholder="Искать событие…" type="search" id="search" required="">
                    <img src="{{ asset('images/Search.svg') }}" loading="lazy" alt="Поиск" class="search-icon">
                    <input type="submit" class="search-button w-button" value="—&gt;">
                </form>
                @if(!request()->get('query'))
                <div class="tags">
                    <a href="{{ route('site.events.index') }}" aria-current="page" class="tag {{ !request()->get('category') ? 'active' : '' }} w-inline-block w--current">
                        <div class="tag-label">Все</div>
                        <div class="tag-number">{{ App\Models\Event::query()->where('active', 1)->count() }}</div>
                    </a>
                    @foreach($categories as $item)
                        <a href="{{ route('site.events.index', ['category' => $item['name']]) }}" class="tag {{ $item['name'] == request()->get('category') ? 'active' : '' }} w-inline-block">
                            <div class="tag-label">{{ $item['name'] }}</div>
                            <div class="tag-number">{{ $item['count'] }}</div>
                        </a>
                    @endforeach
                </div>
                @endif
                <a href="#" class="mobile-search-button w-inline-block" role="button" aria-label="Открыть поиск"><img src="{{ asset('images/Search.svg') }}" loading="lazy" alt="" class="mobile-search-button-icon"></a>
            </div>
            <div class="items-wrap gap-0">
                @foreach($resources as $event)
                <div class="events-card">
                    <div class="events-card-head">
                        <div class="events-card-date">{{ $event->dates }} </div>
                        <div class="events-card-place">
                            <div class="events-card-city">{!! $event->address !!}</div>
                        </div>
                    </div>
                    <div class="events-card-body">
                        <a href="{{ route('site.events.show', $event->alias) }}" class="events-card-title">{{ $event->title }}</a>
                        {{-- Изображения исключены из запроса для оптимизации памяти (содержат base64 до 9.6 МБ) --}}
                        {{-- Изображения загружаются только на странице детального просмотра --}}
                        <div class="events-card-text">{!! $event->description !!}</div>
                        {{-- <a href="{{ route('site.events.show', $event->alias) }}" class="events-card-button w-button">Подробнее —&gt;</a> --}}
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pages-wrap">
                <div class="pages">
                    {{ $resources->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection