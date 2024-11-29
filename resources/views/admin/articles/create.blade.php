@extends('admin.layouts.base')

@section('content')
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Создать новость</h2>
    <form action="#" method="POST" class="space-y-6">
        <!-- Поле для заголовка -->
        <div>
            <label for="title" class="block text-gray-600 font-medium mb-2">Заголовок</label>
            <input
                type="text"
                id="title"
                name="title"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Введите заголовок"
                value="Текущий заголовок">
        </div>

        <!-- Поле для содержания -->
        <div>
            <label for="content" class="block text-gray-600 font-medium mb-2">Содержание</label>
            <textarea
                id="content"
                name="content"
                rows="6"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Введите текст новости">Текущее содержание</textarea>
        </div>

        <!-- Поле для даты -->
        <div>
            <label for="date" class="block text-gray-600 font-medium mb-2">Дата публикации</label>
            <input
                type="date"
                id="date"
                name="date"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="2024-11-29">
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
