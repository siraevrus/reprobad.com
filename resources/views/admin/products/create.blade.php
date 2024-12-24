@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} продукт</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div class="grid grid-cols-2 gap-2">
                <div>@include('admin.components.image-input', ['title' => 'Обложка', 'field' => 'image'])</div>
                <div>@include('admin.components.image-input', ['title' => 'Фото', 'field' => 'photo'])</div>
            </div>

            <div>@include('admin.components.image-input', ['title' => 'Лого', 'field' => 'logo'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.color-input', ['title' => 'Цвет', 'field' => 'color'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Связанный комплекс (id)', 'field' => 'complex_id', 'options' => App\Models\Complex::pluck('alias', 'id')->toArray()])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание', 'field' => 'description', 'no_editor' => true])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Содержание', 'field' => 'content'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Состав', 'field' => 'includes'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Применение', 'field' => 'usage'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'О продукте', 'field' => 'about'])</div>

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
                    title_left: 'hero-product-1',
                    title_right: 'hero-product-2',
                },
            }
        }
    </script>
@endsection
