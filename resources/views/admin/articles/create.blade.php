@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Создать новость</h2>
        <form action="#" method="POST" class="space-y-6">
            @csrf <!-- Добавляем CSRF-токен -->
            <!-- Поле для заголовка -->
            <div>
                <label class="block font-semibold mb-2">Заголовок</label>
                <input type="text" x-model="title" class="w-full p-2 border rounded" placeholder="Введите подзаголовок">
            </div>

            <!-- Поле для содержания -->
            <div>
                <label class="block font-semibold mb-2">Содержание</label>
                <textarea id="content-editor" x-model="content" class="w-full p-2 border rounded editor"></textarea>
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
                title: '',
                content: '',
                async init() {
                    if (location.pathname.split('/')[3] !== undefined && location.pathname.split('/')[3] !== 'create') {
                        await this.get();
                    }

                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    await this.userIsNotActive();
                    this.initializeEditor();
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
                                    element.dataset.text = editor.getContent();
                                });
                            }
                        });
                    });
                },
            }
        }
    </script>
@endsection
