@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} текстовую страницу</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>
                <label
                    class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                >
                    <p x-show="!form.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                    <input type="file" @change="uploadImage($event)" class="hidden" x-ref="fileInput">
                    <img :src="form.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.image">
                    <button x-show="form.image" @click="removeImage()" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                </label>
            </div>
            <div>
                <label class="block font-semibold mb-2">Заголовок</label>
                <input type="text" x-model="form.title" class="w-full p-2 border rounded" placeholder="Введите подзаголовок">
                <div class="text-red-500 text-xs mt-1" x-text="errors.title"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Алиас</label>
                <input type="text" x-model="form.alias" class="w-full p-2 border rounded" placeholder="Введите алиас">
                <div class="text-red-500 text-xs mt-1" x-text="errors.alias"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Время на чтение</label>
                <input type="text" x-model="form.time" class="w-full p-2 border rounded" placeholder="">
                <div class="text-red-500 text-xs mt-1" x-text="errors.time"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Категория</label>
                <input type="text" x-model="form.category" class="w-full p-2 border rounded" placeholder="">
                <div class="text-red-500 text-xs mt-1" x-text="errors.category"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Описание</label>
                <textarea type="text" x-model="form.description" class="w-full p-2 border rounded" placeholder="Введите описание"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.description"></div>
            </div>

            <!-- Поле для содержания -->
            <div>
                <label class="block font-semibold mb-2">Содержание</label>
                <textarea x-model="form.content" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.content"></div>
                <div x-show="!errors.content" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

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
