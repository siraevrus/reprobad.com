@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between" >
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Список подписчиков</h1>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">E-mail</th>
                <th class="py-3 px-6 text-left">Создан</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">1</td>
                    <td class="py-3 px-6">{{ $resource->email }}</td>
                    <td class="py-3 px-6">{{ $resource->date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
