@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} пользователя</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.text-input', ['title' => 'Имя', 'field' => 'name'])</div>

            <div>@include('admin.components.text-input', ['title' => 'E-mail', 'field' => 'email'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Пароль', 'field' => 'password'])</div>

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
                form: {},
            }
        }
    </script>
@endsection
