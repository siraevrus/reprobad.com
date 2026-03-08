@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} событие</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>
                @include('admin.components.image-input', ['title' => 'Лого', 'field' => 'logo'])
                @include('admin.components.text-input', ['title' => 'Alt текст для лого', 'field' => 'logo_alt'])
            </div>

            <div>
                @include('admin.components.image-input', ['title' => 'Фото', 'field' => 'image'])
                @include('admin.components.text-input', ['title' => 'Alt текст для фото', 'field' => 'image_alt'])
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>
            
            <div>@include('admin.components.text-input', ['title' => 'Seo заголовок', 'field' => 'seo_title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Seo описание', 'field' => 'seo_description'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Даты проведения', 'field' => 'dates'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Телефон', 'field' => 'phone'])</div>

            <div>@include('admin.components.text-input', ['title' => 'E-mail', 'field' => 'email'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Тег-месяц', 'field' => 'category'])</div>

            <div>@include('admin.components.file-input', ['title' => 'Программа мероприятия', 'field' => 'file'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Адрес', 'field' => 'address'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание', 'field' => 'description'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Содержание', 'field' => 'content'])</div>

            <div>@include('admin.components.dropzone-input', ['title' => 'Галерея', 'field' => 'images'])</div>

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
                ...fileUpload,
                ...variables,
                ...dropzone,
                ...showAlert,
                ...get,
                ...save,
                ...init,
                form: {
                    images: [],
                    logo: '',
                    image: '',
                    file: ''
                },
            }
        }
    </script>
@endsection
