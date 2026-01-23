@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Список меню', 'route' => 'menus'])

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">День</th>
                <th class="py-3 px-6 text-left">Заголовок</th>
                <th class="py-3 px-6 text-left">Дата</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-3 px-6">{{ $resource->id }}</td>
                <td class="py-3 px-6">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full">День {{ $resource->day }}</span>
                </td>
                <td class="py-3 px-6">{{ $resource->title }}</td>
                <td class="py-3 px-6">{{ $resource->created_at->format('d.m.Y') }}</td>
                <td class="py-3 px-6 text-center">
                    @include('admin.components.controls', ['route' => 'menus', 'resource' => $resource])
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links('vendor.pagination.admin') }}
    </div>
@endsection
