@if ($paginator->hasPages())
    <div class="pages">
        <a href="{{ $paginator->previousPageUrl() }}" class="page-link-arrow @if($paginator->onFirstPage()) disabled @endif">&lt;-</a>

        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <div class="page-link-dots">•••</div>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="{{ $url }}" class="page-link active">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        <a href="{{ $paginator->nextPageUrl() }}" class="page-link-arrow @if(!$paginator->hasMorePages()) disabled @endif">-&gt;</a>
    </div>
@endif
