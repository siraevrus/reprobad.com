@extends('site.layouts.base')

@section('content')
    <div class="page-background mandarin"></div>
    <section class="section inner-section">
        <div class="container">
            <div class="items-head">
                <h1 class="inner-h1 events-h1"><strong>События</strong> и мероприятия</h1>
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
            </div>
            <div class="items-wrap gap-0">
                @foreach($resources as $resource)
                <div class="events-card">
                    <div class="events-card-head">
                        <div class="events-card-date">{{ $resource->dates }} </div>
                        <div class="events-card-place">
                            <div class="events-card-city">{{ $resource->address }}</div>
                        </div>
                        @if($resource->logo)
                        <img src="{{ $resource->logo }}" loading="lazy" alt="" class="events-card-logo">
                        @endif
                    </div>
                    <div class="events-card-body">
                        <a href="{{ route('site.events.show', $resource->alias) }}" class="events-card-title">{{ $resource->title }}</a>
                        <img src="{{ $resource->image }}" loading="lazy" alt="" sizes="(max-width: 479px) 92vw, (max-width: 767px) 91vw, 27vw" srcset="{{ $resource->image }} 500w, {{ $resource->image }} 800w, {{ $resource->image }} 1080w, {{ $resource->image }} 1440w" class="events-card-image">
                        <div class="events-card-text">{{ $resource->title }}</div>
                        <a href="{{ route('site.events.show', $resource->alias) }}" class="events-card-button w-button">Подробнее —&gt;</a>
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
