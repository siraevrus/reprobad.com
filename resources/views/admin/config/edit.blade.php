@extends('admin.layouts.base')

@section('content')
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Настройки</h2>

    <form action="{{ route('admin.config.update') }}" method="POST" class="space-y-6">
        @csrf <!-- Добавляем CSRF-токен -->

        <div>
            <label class="block font-semibold mb-2">Телефон</label>
            <input type="text" value="{{ $config->phone ?? '' }}" name="phone" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('phone'))
            <div class="text-red-500 text-xs mt-1">{{ $errors->first('phone') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Телефон горячей линии</label>
            <input type="text" value="{{ $config->phone2 ?? '' }}" name="phone2" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('phone2'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('phone2') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">E-mail</label>
            <input type="text" value="{{ $config->email ?? '' }}" name="email" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('email'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Контакты для средств массовой информации</label>
            <input type="text" value="{{ $config->email2 ?? '' }}" name="email2" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('email2'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('email2') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Адрес</label>
            <input type="text" value="{{ $config->address ?? '' }}" name="address" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('address'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('address') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Telegram</label>
            <input type="text" value="{{ $config->telegram ?? '' }}" name="telegram" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('telegram'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('telegram') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Rutube</label>
            <input type="text" value="{{ $config->rutube ?? '' }}" name="rutube" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('rutube'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('rutube') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">OK</label>
            <input type="text" value="{{ $config->ok ?? '' }}" name="ok" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('ok'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('ok') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">VK</label>
            <input type="text" value="{{ $config->vk ?? '' }}" name="vk" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('vk'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('vk') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Дзен</label>
            <input type="text" value="{{ $config->dzen ?? '' }}" name="dzen" class="w-full p-2 border rounded" placeholder="">
            @if($errors->has('dzen'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('dzen') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Системный промпт</label>
            <textarea name="system_prompt" rows="20" class="w-full p-2 border rounded">{{ $config->system_prompt ?? '' }}</textarea>
            @if($errors->has('system_prompt'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('system_prompt') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Сообщение приветствия</label>
            <textarea name="bot_welcome_message" rows="10" class="w-full p-2 border rounded">{{ $config->bot_welcome_message ?? '' }}</textarea>
            @if($errors->has('bot_welcome_message'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('bot_welcome_message') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">RAG версия</label>
            <input name="ai_model" class="w-full p-2 border rounded" value="{{ $config->rag_version ?? '' }}">
            @if($errors->has('rag_version'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('rag_version') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">AI модель</label>
            <input name="ai_model" class="w-full p-2 border rounded" value="{{ $config->ai_model ?? '' }}">
            @if($errors->has('ai_model'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('ai_model') }}</div>
            @endif
        </div>

        <!-- Кнопки -->
        <div class="flex justify-end gap-4">
            <button type="reset" class="px-6 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">
                Отмена
            </button>
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Сохранить
            </button>
        </div>
    </form>
@endsection
