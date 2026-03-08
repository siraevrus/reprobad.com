@php
    $iconSrc = $item->icon ?? 'images/bolt.svg';
    $iconAlt = match(true) {
        str_contains($iconSrc, 'brain.svg') => 'иконка мозг',
        str_contains($iconSrc, 'ic-heart.svg') => 'иконка сердце',
        str_contains($iconSrc, 'bolt.svg') => 'Иконка молния',
        default => 'Иконка',
    };
@endphp
<div class="card">
    <div class="card-head">
        <img src="{{ $iconSrc }}" loading="lazy" alt="{{ $iconAlt }}" class="card-icon">
    </div>
    <div class="card-body">
        <a href="{{ route($item->route_name ?? 'site.articles.show', $item->alias) }}" class="card-title {{ $resource->color ?? '' }}">{{ $item->title }}</a>
        <div class="card-text">{!! $item->description !!}</div>
    </div>
    <div class="card-footer">
        <div class="card-date">{{ $item->published_at }}</div>
        <div class="card-read"><img src="images/sm-clock.svg" loading="lazy" alt="часы" class="clock-icon">
            <div>{{ $item->time }}</div>
        </div>
        <a href="{{ route($item->route_name ?? 'site.articles.show', $item->alias) }}" class="card-link w-inline-block">
            <div class="text-block">Читать</div>
            <div class="card-link-arrow">—&gt;</div>
        </a>
    </div>
</div>
