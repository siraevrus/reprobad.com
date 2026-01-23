@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} меню</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.text-input', ['title' => 'День (1-7)', 'field' => 'day'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание', 'field' => 'description', 'no_editor' => true])</div>

            <div>
                <label class="block font-semibold mb-2">Данные меню (JSON)</label>
                <textarea x-model="form.menu_data" class="w-full p-2 border rounded font-mono text-sm" rows="20" placeholder='{"breakfast": {...}, "snack": {...}, "dinner": {...}, "lunch": {...}}'></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.menu_data"></div>
                <div class="text-gray-400 text-xs mt-1">Введите данные меню в формате JSON. Структура: breakfast, snack, dinner, lunch - каждый с полями: image, title, name, kbju (калории, белки, жиры, углеводы), description, recipe, products (таблица продуктов)</div>
            </div>

            <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => ['1' => 'Да', '0' => 'Нет']])</div>

            @include('admin.components.buttons')
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function app() {
            return {
                ...userIsNotActive,
                ...variables,
                ...showAlert,
                ...save,
                ...init,
                form: {
                    day: '',
                    title: '',
                    alias: '',
                    description: '',
                    menu_data: '',
                    active: 1,
                },
                async get() {
                    this.loading = true;
                    try {
                        const response = await fetch('/admin/' + this.route + '/' + this.action);
                        const data = await response.json();
                        
                        // Преобразуем menu_data из массива в JSON строку
                        if (data.menu_data && typeof data.menu_data === 'object') {
                            data.menu_data = JSON.stringify(data.menu_data, null, 2);
                        }
                        
                        this.form = Object.assign(this.form, data);
                        this.loading = false;
                    }
                    catch (e) {
                        console.log(e)
                    }
                    finally {
                        this.loading = false;
                    }
                },
            }
        }
    </script>
@endsection
