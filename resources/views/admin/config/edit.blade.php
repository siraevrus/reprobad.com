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
            <label class="block font-semibold mb-2">AI модель</label>
            <input name="ai_model" class="w-full p-2 border rounded" value="{{ $config->ai_model ?? '' }}" placeholder="deepseek-v3.2">
            @if($errors->has('ai_model'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('ai_model') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Max Tokens (максимум токенов в ответе)</label>
            <input type="number" name="max_tokens" class="w-full p-2 border rounded" value="{{ $config->max_tokens ?? '1000' }}" min="1" max="4000">
            @if($errors->has('max_tokens'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('max_tokens') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Temperature (креативность: 0-2, рекомендуемое 0.6-0.8)</label>
            <input type="number" step="0.1" name="temperature" class="w-full p-2 border rounded" value="{{ $config->temperature ?? '0.8' }}" min="0" max="2">
            @if($errors->has('temperature'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('temperature') }}</div>
            @endif
        </div>
        <div>
            <label class="block font-semibold mb-2">Top P (разнообразие: 0-1, рекомендуемое 0.9)</label>
            <input type="number" step="0.1" name="top_p" class="w-full p-2 border rounded" value="{{ $config->top_p ?? '0.9' }}" min="0" max="1">
            @if($errors->has('top_p'))
                <div class="text-red-500 text-xs mt-1">{{ $errors->first('top_p') }}</div>
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
