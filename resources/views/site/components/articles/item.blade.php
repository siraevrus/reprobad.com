<div class="card">
    <div class="card-head">
        <img src="{{ $item->icon ?? 'images/bolt.svg' }}" loading="lazy" alt="" class="card-icon">
    </div>
    <div class="card-body">
        <a href="{{ route('site.articles.show', $item->alias) }}" class="card-title {{ $resource->color ?? '' }}">{{ $item->title }}</a>
        <div class="card-text">{!! $item->description !!}</div>
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
