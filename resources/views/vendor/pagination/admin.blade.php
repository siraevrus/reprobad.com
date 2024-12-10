@if ($paginator->hasPages())
    <div class="flex items-center justify-center space-x-2 mt-4">
        {{-- Кнопка "Назад" --}}
        <a
            href="{{ $paginator->previousPageUrl() }}"
            class="px-3 py-1 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring
                   @if($paginator->onFirstPage()) cursor-not-allowed opacity-50 @endif"
            @if($paginator->onFirstPage()) aria-disabled="true" @endif
        >
            <span class="material-icons text-base">arrow_back</span>
        </a>

        {{-- Пагинация --}}
        @foreach ($elements as $element)
            {{-- Троеточие --}}
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-600">•••</span>
            @endif

            {{-- Ссылки на страницы --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a
                            href="{{ $url }}"
                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring"
                            aria-current="page"
                        >
                            {{ $page }}
                        </a>
                    @else
                        <a
                            href="{{ $url }}"
                            class="px-3 py-1 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring"
                        >
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Кнопка "Вперед" --}}
        <a
            href="{{ $paginator->nextPageUrl() }}"
            class="px-3 py-1 text-gray-600 bg-gray-200 rounded hover:bg-gray-300 focus:outline-none focus:ring
                   @if(!$paginator->hasMorePages()) cursor-not-allowed opacity-50 @endif"
            @if(!$paginator->hasMorePages()) aria-disabled="true" @endif
        >
            <span class="material-icons text-base">arrow_forward</span>
        </a>
    </div>
@endif
