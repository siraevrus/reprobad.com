@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
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
                    title: '',
                    text: '',
                    article_id: '',
                    active: 1,
                },
            }
        }
    </script>
@endsection
