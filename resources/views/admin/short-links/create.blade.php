@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Создать короткую ссылку</h1>
        <a href="{{ route('admin.short-links.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Назад</a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.short-links.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="long_url" class="block text-sm font-medium text-gray-700 mb-2">Длинная ссылка <span class="text-red-500">*</span></label>
                <input type="url" name="long_url" id="long_url" value="{{ old('long_url') }}" required
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="https://reprobad.com/page?utm_source=...">
                @error('long_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Название (для удобства в админке)</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Например: Рассылка февраль">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="short_code" class="block text-sm font-medium text-gray-700 mb-2">Свой код (необязательно)</label>
                <input type="text" name="short_code" id="short_code" value="{{ old('short_code') }}" maxlength="20"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Оставьте пустым для автогенерации">
                <p class="mt-1 text-sm text-gray-500">Только латинские буквы и цифры. Если пусто — код будет сгенерирован автоматически.</p>
                @error('short_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.short-links.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Отмена</a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
