@extends('site.layouts.base')

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
                    <img src="images/Search.svg" loading="lazy" alt="" class="search-icon">
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
                <a href="#" class="mobile-search-button w-inline-block" onclick="event.preventDefault(); toggleMobileSearch(); return false;"><img src="images/Search.svg" loading="lazy" alt="" class="mobile-search-button-icon"></a>
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

@section('scripts')
<script>
    function toggleMobileSearch() {
        const searchForm = document.querySelector('.items-head .search');
        const mobileButton = document.querySelector('.mobile-search-button');
        
        if (searchForm) {
            if (searchForm.style.display === 'block' || searchForm.classList.contains('mobile-search-active')) {
                searchForm.style.display = 'none';
                searchForm.classList.remove('mobile-search-active');
            } else {
                searchForm.style.display = 'block';
                searchForm.classList.add('mobile-search-active');
                // Фокусируемся на поле ввода
                const searchInput = searchForm.querySelector('.search-input');
                if (searchInput) {
                    setTimeout(() => {
                        searchInput.focus();
                    }, 100);
                }
            }
        }
    }
</script>
@endsection
