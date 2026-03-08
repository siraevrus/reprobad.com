<div class="short-event">
    <div class="short-event-date">{{ $item->dates }}</div>
    <a href="{{ route('site.events.show', $item->alias) }}" class="short-event-h">{{ $item->title }}</a>
    <div class="short-event-text">{!! $item->description !!}</div>
    <div class="short-event-footer">
        <a href="{{ route('site.events.show', $item->alias) }}" class="button short-event-button w-button" style="font-family: Inter, sans-serif;">Подробнее <span style="font-size: 2em; display: inline-block; line-height: 1; vertical-align: -0.15em;">→</span></a>
        {{--
        @if($item->logo)<img loading="lazy" src="{{ $item->logo }}" alt="{{ $item->logo_alt ?? strip_tags($item->title) }}" class="short-event-logo">@endif
        --}}
    </div>
</div>
