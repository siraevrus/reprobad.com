@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">История запросов пользователей</h1>
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
                        <div class="max-w-md truncate" title="{{ $resource->bot_response }}">
                            {{ Str::limit($resource->bot_response, 100) }}
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

