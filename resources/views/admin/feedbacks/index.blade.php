@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Вопросы с сайта</h1>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">ФИО</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Телефон</th>
                <th class="py-3 px-6 text-left">Дата</th>
                <th class="py-3 px-6 text-left">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $resource->id }}</td>
                    <td class="py-3 px-6">{{ $resource->name }}</td>
                    <td class="py-3 px-6">{{ $resource->email }}</td>
                    <td class="py-3 px-6">{{ $resource->phone ?? '-' }}</td>
                    <td class="py-3 px-6">{{ $resource->date }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ route('admin.feedbacks.show', $resource->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">Просмотр</a>
                        <form action="{{ route('admin.feedbacks.destroy', $resource->id) }}" method="POST" class="inline" onsubmit="return confirm('Вы уверены, что хотите удалить этот вопрос?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection

