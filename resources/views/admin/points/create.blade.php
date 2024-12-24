@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} точку продаж</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.image-input', ['title' => 'Лого', 'field' => 'image'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => [1 => 'Да', 0 => 'Нет']])</div>

            <div class="grid grid-cols-2 gap-4">
                <div>@include('admin.components.text-input', ['title' => 'Адрес', 'field' => 'address'])</div>
                <div>@include('admin.components.text-input', ['title' => 'Метро', 'field' => 'metro'])</div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Адрес сайта', 'field' => 'site'])</div>

            <div class="grid grid-cols-3 gap-4">
                <div>@include('admin.components.text-input', ['title' => 'Телефон', 'field' => 'phone'])</div>
                <div>@include('admin.components.text-input', ['title' => 'Дни', 'field' => 'days'])</div>
                <div>@include('admin.components.text-input', ['title' => 'Время работы', 'field' => 'time'])</div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Координаты', 'field' => 'coords'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Текст', 'field' => 'text', 'no_editor' => 1])</div>

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
    </div>
@endsection

@section('scripts')
    <script>
        function app() {
            return {
                ...initializeEditor,
                ...userIsNotActive,
                ...imageUpload,
                ...variables,
                ...showAlert,
                ...get,
                ...save,
                ...init,
                form: {
                    active: 1,
                },
            }
        }
    </script>
@endsection
