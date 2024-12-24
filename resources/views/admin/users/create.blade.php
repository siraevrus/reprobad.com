@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} пользователя</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.text-input', ['title' => 'Имя', 'field' => 'name'])</div>

            <div>@include('admin.components.text-input', ['title' => 'E-mail', 'field' => 'email'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Пароль', 'field' => 'password'])</div>

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
                    name: '',
                    email: '',
                    password: '',
                },
            }
        }
    </script>
@endsection
