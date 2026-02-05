@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Результаты теста</h1>
    </div>

    <div class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <p class="text-sm">Всего результатов: <strong>{{ $resources->total() }}</strong></p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Количество рекомендаций</th>
                <th class="py-3 px-6 text-left">Дата прохождения</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @forelse($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $resource->id }}</td>
                    <td class="py-3 px-6">
                        @if($resource->email)
                            {{ $resource->email }}
                        @else
                            <span class="text-gray-400">Не указан</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @if(isset($resource->results['results']) && is_array($resource->results['results']))
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                {{ count($resource->results['results']) }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">{{ $resource->date }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.test-results.show', $resource->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Просмотр
                            </a>
                            <form action="{{ route('admin.test-results.destroy', $resource->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить этот результат?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        Результатов теста пока нет
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
