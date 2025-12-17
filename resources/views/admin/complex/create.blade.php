@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} продукт</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 1', 'field' => 'image_left'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_left'])
                    @include('admin.components.text-input', ['title' => 'Якорь (алиас продукта)', 'field' => 'anchor_left'])
                </div>
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 2', 'field' => 'image_right'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_right'])
                    @include('admin.components.text-input', ['title' => 'Якорь (алиас продукта)', 'field' => 'anchor_right'])
                </div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Seo заголовок', 'field' => 'seo_title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Цвет', 'field' => 'color', 'options' => ['green' => 'Зеленый', 'purple' => 'Пурпурный', 'mandarin' => 'Оранжевый']])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.text-input', ['title' => 'SEO description', 'field' => 'seo_description'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание товара', 'field' => 'content'])</div>

            @include('admin.components.buttons')
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
