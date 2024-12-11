@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} продукт</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 1', 'field' => 'image_left'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_left'])
                </div>
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 2', 'field' => 'image_right'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_right'])
                </div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>

            <div>@include('admin.components.select-input', ['title' => 'Цвет', 'field' => 'color', 'options' => ['green' => 'Зеленый', 'purple' => 'Пурпурный', 'mandarin' => 'Оранжевый']])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Описание товара', 'field' => 'content'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Связанные товары (id через запятую)', 'field' => 'products'])</div>

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
                    alias: '',
                    subtitle: '',
                    content: '',
                    image_left: '',
                    image_right: '',
                    description: '',
                    color: '',
                    products: '',
                    title_left: 'hero-product-1',
                    title_right: 'hero-product-2',
                    active: true
                },
                async init() {
                    if (location.pathname.split('/')[3] !== undefined && location.pathname.split('/')[3] !== 'create') {
                        await this.get();
                    }

                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    //await this.userIsNotActive();
                    this.initializeEditor();
                },
                async get() {
                    const response = await fetch('/admin/complex/' + location.pathname.split('/')[3]);
                    const data = await response.json()
                    this.form = data
                },
                uploadImage(event, field) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        this.form[field] = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                    event.target.value = '';
                },
                removeImage(field) {
                    this.form[field] = null;
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
                        if(method === 'POST') {
                            window.location.href = '/admin/complex/';
                        }else {
                            this.form = data.resource;
                            this.showAlert('Сохранено');
                        }
                    } else {
                        this.errors = data.errors;
                    }
                },
                showAlert(message) {
                    this.alert.show = false;
                    this.$nextTick(() => {
                        this.alert.show = true;
                        this.alert.message = message;
                        setTimeout(() => this.alert.show = false, 1000);
                    });
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
                            content_css: '/css/admin.css',
                            language_url: '/js/ru.min.js',
                            plugins: 'advlist autolink lists link image charmap preview anchor code',
                            toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                            setup: (editor) => {
                                editor.on('change', () => {
                                    let field = element.getAttribute('x-model').split('.')[1];
                                    this.form[field] = editor.getContent();
                                });
                            }
                        });
                    });
                },
            }
        }
    </script>
@endsection
