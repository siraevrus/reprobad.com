@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Список статей', 'route' => 'articles'])

    <form method="GET" action="{{ route('admin.articles.index') }}" class="mb-4 flex gap-2">
        <input
            type="text"
            name="search"
            value="{{ $search ?? '' }}"
            placeholder="Поиск по заголовку или алиасу"
            class="w-full rounded border border-gray-300 px-3 py-2"
        >
        <button type="submit" class="rounded bg-blue-500 px-4 py-2 text-white">Найти</button>
        @if(!empty($search))
            <a href="{{ route('admin.articles.index') }}" class="rounded border border-gray-300 px-4 py-2 text-gray-700">Сбросить</a>
        @endif
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Фото</th>
                <th class="py-3 px-6 text-left">Заголовок</th>
                <th class="py-3 px-6 text-left">Алиас</th>
                <th class="py-3 px-6 text-left">Дата</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
            @php
                $highlightedTitle = e($resource->title ?? '');
                $highlightedAlias = e($resource->alias ?? '');
                if (!empty($search ?? '')) {
                    $pattern = '/' . preg_quote($search, '/') . '/iu';
                    $highlightedTitle = preg_replace($pattern, '<mark>$0</mark>', $highlightedTitle) ?? $highlightedTitle;
                    $highlightedAlias = preg_replace($pattern, '<mark>$0</mark>', $highlightedAlias) ?? $highlightedAlias;
                }
            @endphp
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-3 px-6">{{ $resource->id }}</td>
                <td class="py-3 px-6">
                    <img class="w-[120px]" src="{{ $resource->image }}" alt="">
                </td>
                <td class="py-3 px-6">{!! $highlightedTitle !!}</td>
                <td class="py-3 px-6 font-mono text-xs">{!! $highlightedAlias !!}</td>
                <td class="py-3 px-6">{{ $resource->published_at }}</td>
                <td class="py-3 px-6 text-center">
                    @include('admin.components.controls', ['route' => 'articles', 'resource' => $resource])
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links('vendor.pagination.admin') }}
    </div>
@endsection
