@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} статью</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf <!-- Добавляем CSRF-токен -->
            <!-- Поле для заголовка -->
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
                alert: {
                    show: false,
                    message: '',
                    type: ''
                },
                errors: {},
                form: {
                    title: '',
                    description: '',
                    alias: '',
                    image: '',
                    content: '',
                    category: '',
                    time: '',
                },
                async init() {
                    if (location.pathname.split('/')[3] !== undefined && location.pathname.split('/')[3] !== 'create') {
                        await this.get();
                    }

                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    await this.userIsNotActive();
                    this.initializeEditor();
                },
                async get() {
                    const response = await fetch('/admin/articles/' + location.pathname.split('/')[3]);
                    const data = await response.json()
                    this.form = data
                },
                uploadImage(event) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        this.form.image = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                    event.target.value = '';
                },
                removeImage() {
                    this.form.image = null;
                },
                async save() {
                    let method = 'POST';
                    if(location.pathname.split('/')[3] !== 'create') method = 'PUT';
                    let url = location.pathname.replace('create', '').replace('edit', '');
                    const response = await fetch(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.token
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();
                    if (data.success) {

                    } else {
                        this.errors = data.errors;
                    }
                },
                async userIsNotActive() {
                    let idleTime = 0;
                    const idleLimit = 10; // Время бездействия в секундах

                    const resetIdleTimer = () => {
                        idleTime = 0;
                    };

                    document.addEventListener('mousemove', resetIdleTimer);
                    document.addEventListener('keydown', resetIdleTimer);
                    document.addEventListener('mousedown', resetIdleTimer);
                    document.addEventListener('scroll', resetIdleTimer);

                    setInterval(async () => {
                        idleTime++;
                        if (idleTime >= idleLimit) {
                            console.log('Пользователь неактивен');
                            await this.save(true);
                        }
                    }, 1000);
                },
                initializeEditor() {
                    document.querySelectorAll('.editor').forEach((element, index) => {
                        if (!element.id) {
                            element.id = `editor-${index}`; // Назначаем уникальный ID
                        }

                        tinymce.init({
                            selector: `#${element.id}`, // Используем уникальный ID
                            height: 300,
                            menubar: false,
                            language: 'ru',
                            language_url: '/js/ru.min.js',
                            plugins: 'advlist autolink lists link image charmap preview anchor code',
                            toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                            setup: (editor) => {
                                editor.on('change', () => {
                                    this.form.content = editor.getContent();
                                });
                            }
                        });
                    });
                },
            }
        }
    </script>
@endsection
