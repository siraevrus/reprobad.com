@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} продукт</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 1', 'field' => 'image_left'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_left'])
                </div>
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 2', 'field' => 'image_right'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_right'])
                </div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Цвет', 'field' => 'color', 'options' => ['green' => 'Зеленый', 'purple' => 'Пурпурный', 'mandarin' => 'Оранжевый']])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.text-input', ['title' => 'SEO description', 'field' => 'seo_description'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание товара', 'field' => 'content'])</div>

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
                    active: 1,
                },
            }
        }
    </script>
@endsection
