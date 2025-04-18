<div class="short-event">
    <div class="short-event-date">{{ $item->dates }}</div>
    <a href="{{ route('site.events.show', $item->alias) }}" class="short-event-h">{{ $item->title }}</a>
    <div class="short-event-text">{!! $item->description !!}</div>
    <div class="short-event-footer">
        <a href="{{ route('site.events.show', $item->alias) }}" class="button short-event-button w-button">Подробнее —&gt;</a>
        {{--
        @if($item->logo)<img loading="lazy" src="{{ $item->logo }}" alt="" class="short-event-logo">@endif
        --}}
    </div>
</div>
