@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} совет</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.image-input', ['title' => 'Фото', 'field' => 'image'])</div>
            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>
            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>
            <div>@include('admin.components.text-input', ['title' => 'SEO description', 'field' => 'seo_description'])</div>
            <div>@include('admin.components.text-input', ['title' => 'Время на чтение', 'field' => 'time'])</div>
            <div>@include('admin.components.text-input', ['title' => 'Категория', 'field' => 'category'])</div>
            <div>@include('admin.components.textarea-input', ['title' => 'Короткое описание', 'field' => 'description'])</div>
            <div>@include('admin.components.textarea-input', ['title' => 'Содержание', 'field' => 'content'])</div>

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
                    tags: [],
                    images: []
                },
            }
        }
    </script>
@endsection
