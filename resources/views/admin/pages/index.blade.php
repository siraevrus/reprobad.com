@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between" >
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Список страниц</h1>
        <a href="{{ route('admin.pages.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
            <span class="material-icons">add</span>
            <span>Создать</span>
        </a>
    </div>
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
                        <form method="post" action="{{ route('admin.pages.destroy', $resource->id) }}" class="flex items-center justify-center gap-2">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('admin.pages.edit', $resource->id) }}" class="text-blue-500 hover:text-blue-700">
                                <span class="material-icons">edit</span>
                            </a>
                            <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить?');" class="text-red-500 hover:text-red-700">
                                <span class="material-icons">delete</span>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <!-- Повторите строки для других элементов -->
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
