@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} этап подготовки</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf <!-- Добавляем CSRF-токен -->
            <!-- Поле для заголовка -->

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Текст', 'field' => 'text'])</div>

            {{--
            <div>@include('admin.components.select-input', ['title' => 'Статья', 'field' => 'article_id', 'options' => $options])</div>
            --}}

            <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => [1 => 'Да', 0 => 'Нет']])</div>

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
                    active: 1,
                },
            }
        }
    </script>
@endsection
