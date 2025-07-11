@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Список событий', 'route' => 'events'])

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 hidden md:table">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Фото</th>
                <th class="py-3 px-6 text-left">Заголовок</th>
                <th class="py-3 px-6 text-left">Дата</th>
                <th class="py-3 px-6 text-left">Порядок</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $resource->id }}</td>
                    <td class="py-3 px-6">
                        <img class="w-[120px]" src="{{ $resource->image }}" alt="">
                    </td>
                    <td class="py-3 px-6">{{ $resource->title }}</td>
                    <td class="py-3 px-6">{{ $resource->created_at }}</td>
                    <td class="py-3 px-6">{{ $resource->sort }}</td>
                    <td class="py-3 px-6 text-center">
                        @include('admin.components.controls', ['route' => 'events', 'resource' => $resource])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="block md:hidden space-y-4">
            @foreach($resources as $resource)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <img class="w-[80px] h-[80px] object-cover rounded mr-4" src="{{ $resource->image }}" alt="">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $resource->title }}</h3>
                            <p class="text-gray-500 text-sm">Дата: {{ $resource->created_at }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">ID: {{ $resource->id }}</span>
                        @include('admin.components.controls', ['route' => 'events', 'resource' => $resource])
                    </div>
                </div>
            @endforeach
        </div>

        {{ $resources->links() }}
    </div>
@endsection
