@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} продукт</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-2">Фото слева</label>
                    <label
                        class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                    >
                        <p x-show="!form.image_left">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                        <input type="file" @change="uploadImage($event, 'image_left')" class="hidden" x-ref="fileInput">
                        <img :src="form.image_left" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.image_left">
                        <button x-show="form.image_left" @click="removeImage('image_left')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                    </label>
                    <input type="text" x-model="form.title_left" class="w-full p-2 border rounded" placeholder="CSS класс для блока">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Фото справа</label>
                    <label
                        class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                    >
                        <p x-show="!form.image_right">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                        <input type="file" @change="uploadImage($event, 'image_right')" class="hidden" x-ref="fileInput">
                        <img :src="form.image_right" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.image_right">
                        <button x-show="form.image_right" @click="removeImage('image_right')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                    </label>
                    <input type="text" x-model="form.title_right" class="w-full p-2 border rounded" placeholder="CSS класс для блока">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Логотип</label>
                <label
                    class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                >
                    <p x-show="!form.logo">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                    <input type="file" @change="uploadImage($event, 'logo')" class="hidden" x-ref="fileInput">
                    <img :src="form.logo" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.logo">
                    <button x-show="form.logo" @click="removeImage('logo')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                </label>
            </div>

            <div>
                <label class="block font-semibold mb-2">Фото товара</label>
                <label
                    class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                >
                    <p x-show="!form.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                    <input type="file" @change="uploadImage($event, 'image')" class="hidden" x-ref="fileInput">
                    <img :src="form.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.image">
                    <button x-show="form.image" @click="removeImage('image')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                </label>
            </div>

            <div>
                <label class="block font-semibold mb-2">Заголовок</label>
                <input type="text" x-model="form.title" class="w-full p-2 border rounded" placeholder="Введите подзаголовок">
                <div class="text-red-500 text-xs mt-1" x-text="errors.title"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Подзаголовок</label>
                <input type="text" x-model="form.subtitle" class="w-full p-2 border rounded" placeholder="Введите подзаголовок">
                <div class="text-red-500 text-xs mt-1" x-text="errors.subtitle"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Цвет</label>
                <select type="text" x-model="form.color" class="w-full p-2 border rounded">
                    <option value="">По умолчанию</option>
                    <option value="green">Зеленый</option>
                    <option value="purple">Пурпурный</option>
                    <option value="mandarin">Оранжевый</option>
                </select>
                <div class="text-red-500 text-xs mt-1" x-text="errors.color"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Алиас</label>
                <input type="text" x-model="form.alias" class="w-full p-2 border rounded" placeholder="Введите алиас">
                <div class="text-red-500 text-xs mt-1" x-text="errors.alias"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Короткое описание</label>
                <textarea x-model="form.text" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.content"></div>
                <div x-show="!errors.text" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Описание</label>
                <textarea type="text" x-model="form.description" class="w-full p-2 border rounded" placeholder="Введите описание"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.description"></div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Фото</label>
                <label
                    class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
                >
                    <p x-show="!form.photo">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                    <input type="file" @change="uploadImage($event, 'photo')" class="hidden" x-ref="fileInput">
                    <img :src="form.photo" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.photo">
                    <button x-show="form.image" @click="removeImage('photo')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                </label>
            </div>

            <div>
                <label class="block font-semibold mb-2">Описание</label>
                <textarea x-model="form.content" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.content"></div>
                <div x-show="!errors.content" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Состав</label>
                <textarea x-model="form.includes" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.includes"></div>
                <div x-show="!errors.includes" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Применение</label>
                <textarea x-model="form.usage" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.usage"></div>
                <div x-show="!errors.usage" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div>
                <label class="block font-semibold mb-2">О продукте</label>
                <textarea x-model="form.about" class="w-full p-2 border rounded editor"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.about"></div>
                <div x-show="!errors.about" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div>
                <label class="block font-semibold mb-2">Связанные товары (id через запятую)</label>
                <input type="text" x-model="form.products" class="w-full p-2 border rounded" placeholder="Введите алиас">
                <div class="text-red-500 text-xs mt-1" x-text="errors.products"></div>
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
                    logo: '',
                    photo: '',
                    content: '',
                    subtitle: '',
                    includes: '',
                    usage: '',
                    text: '',
                    products: '',
                    about: '',
                    image_left: '',
                    image_right: '',
                    title_left: 'hero-product-1',
                    title_right: 'hero-product-2',
                    color: ''
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
                    const response = await fetch('/admin/products/' + location.pathname.split('/')[3]);
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
                            window.location.href = '/admin/products/';
                        }else {
                            alert('Данные сохранены');
                        }
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
