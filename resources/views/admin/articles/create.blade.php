@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        <div class="fixed bg-green-400 border text-white border-green-500 text-green-800 top-[20px] px-4 py-2 rounded z-50"
             x-show="alert.show"
             x-text="alert.message"
        ></div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} статью</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.image-input', ['title' => 'Фото', 'field' => 'image'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.text-input', ['title' => 'SEO description', 'field' => 'seo_description'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => ['1' => 'Да', '0' => 'Нет']])</div>

            <div>
                <label class="block font-semibold mb-2">Иконка</label>
                <div class="flex space-x-2">
                    @foreach($icons as $icon)
                        <label for="icon_{{ $icon }}">
                            <input id="icon_{{ $icon }}" type="radio" name="icon" value="{{ $icon }}" x-model="form.icon" class="mr-2">
                            <img src="{{ $icon }}" alt="">
                        </label>
                    @endforeach
                </div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Время на чтение', 'field' => 'time'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Категория', 'field' => 'category'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Короткий текст', 'field' => 'description'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Содержание', 'field' => 'content'])</div>

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
