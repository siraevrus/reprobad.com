@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">История запросов пользователей</h1>
    </div>

    <!-- Фильтр по источнику -->
    <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4">
        <form method="GET" action="{{ route('admin.chat-history.index') }}" class="flex items-center gap-4">
            <label for="source" class="text-sm font-medium text-gray-700">Фильтр по источнику:</label>
            <select name="source" id="source" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Все источники</option>
                @foreach($sources as $sourceOption)
                    <option value="{{ $sourceOption }}" {{ $source === $sourceOption ? 'selected' : '' }}>
                        {{ $sourceOption }}
                    </option>
                @endforeach
            </select>
            @if($source)
                <a href="{{ route('admin.chat-history.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-flex items-center gap-1">
                    <span class="material-icons">clear</span>
                    <span>Сбросить</span>
                </a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">User ID</th>
                <th class="py-3 px-6 text-left">Источник</th>
                <th class="py-3 px-6 text-left">Запрос пользователя</th>
                <th class="py-3 px-6 text-left">Ответ бота</th>
                <th class="py-3 px-6 text-left">Дата создания</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @foreach($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $resource->id }}</td>
                    <td class="py-3 px-6">{{ $resource->user_id ?? '-' }}</td>
                    <td class="py-3 px-6">
                        <span class="px-2 py-1 text-xs rounded {{ $resource->source === 'web' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $resource->source }}
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        <div class="max-w-md truncate" title="{{ $resource->user_message }}">
                            {{ Str::limit($resource->user_message, 100) }}
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="max-w-2xl whitespace-pre-wrap break-words">
                            {{ $resource->bot_response }}
                        </div>
                    </td>
                    <td class="py-3 px-6">{{ $resource->created_at->format('d.m.Y H:i') }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.chat-history.show', $resource->id) }}" class="text-blue-500 hover:text-blue-700" title="Просмотр">
                                <span class="material-icons">visibility</span>
                            </a>
                            <form method="post" action="{{ route('admin.chat-history.destroy', $resource->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить?');" class="text-red-500 hover:text-red-700" title="Удалить">
                                    <span class="material-icons">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection

