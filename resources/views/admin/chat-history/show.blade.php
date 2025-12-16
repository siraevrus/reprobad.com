@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Детали запроса</h1>
        <a href="{{ route('admin.chat-history.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 inline-flex items-center gap-1">
            <span class="material-icons">arrow_back</span>
            <span>Назад к списку</span>
        </a>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-6">
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">ID записи</h3>
            <p class="text-gray-900">{{ $resource->id }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">User ID</h3>
            <p class="text-gray-900">{{ $resource->user_id ?? '-' }}</p>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Источник</h3>
            <span class="px-3 py-1 text-sm rounded {{ $resource->source === 'web' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                {{ $resource->source }}
            </span>
        </div>

        @if($resource->chat_id)
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Chat ID</h3>
            <p class="text-gray-900">{{ $resource->chat_id }}</p>
        </div>
        @endif

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-2">Запрос пользователя</h3>
            <div class="bg-gray-50 border border-gray-200 rounded p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $resource->user_message }}</p>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-2">Ответ бота</h3>
            <div class="bg-gray-50 border border-gray-200 rounded p-4">
                <div class="text-gray-900 whitespace-pre-wrap">{!! nl2br(e($resource->bot_response)) !!}</div>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-1">Дата создания</h3>
            <p class="text-gray-900">{{ $resource->created_at->format('d.m.Y H:i:s') }}</p>
        </div>

        <div class="pt-4 border-t border-gray-200">
            <form method="post" action="{{ route('admin.chat-history.destroy', $resource->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить эту запись?');" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 inline-flex items-center gap-1">
                    <span class="material-icons">delete</span>
                    <span>Удалить запись</span>
                </button>
            </form>
        </div>
    </div>
@endsection

