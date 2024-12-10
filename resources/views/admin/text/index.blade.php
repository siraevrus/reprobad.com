@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Список текстовых страниц', 'route' => 'text'])

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Заголовок</th>
                <th class="py-3 px-6 text-left">Дата</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">1</td>
                    <td class="py-3 px-6">{{ $resource->title }}</td>
                    <td class="py-3 px-6">{{ $resource->created_at }}</td>
                    <td class="py-3 px-6 text-center">
                        @include('admin.components.controls', ['route' => 'text', 'resource' => $resource])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
