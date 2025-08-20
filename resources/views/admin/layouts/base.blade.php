<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <!-- alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <base href="/">

    <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- tinymce -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.5.0/tinymce.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>

    <!-- cropper -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- alpine mixins -->
    <script src="/js/utils.js?v={{ md5_file(public_path('js/utils.js')) }}"></script>


    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 min-h-screen">
<!-- Контейнер -->
<div class="container mx-auto px-4 max-w-[1270px] py-8">
    <!-- Шапка с логотипом -->
    <header class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <img src="https://cdn.prod.website-files.com/67040316492967a9326aebb1/6720a9e362cc884eee5120df_lgog-gold.svg" alt="Лого" class="w-12 h-12 rounded-full">
            <h1 class="text-2xl font-semibold text-gray-800">Repro</h1>
        </div>
        <nav>
            <a href="/" class="text-blue-500 hover:underline">На сайт</a>
        </nav>
    </header>

    <!-- Основное содержимое -->
    <div class="flex flex-col md:flex-row gap-6" x-data="{ menuOpen: false }">
        <!-- Боковая панель -->
        <aside class="w-full md:w-1/6">
            <button
                @click="menuOpen = !menuOpen"
                class="block md:hidden text-white bg-blue-500 px-4 py-2 rounded mb-4">
                Меню
            </button>
            <nav :class="menuOpen ? 'block' : 'hidden'" class="sticky top-4 md:block">
                <ul class="space-y-4" x-data="nav()">
                    <template x-for="(item, index) in menuItems" :key="index">
                        <li>
                            <a :href="item.href"
                               :class="currentSegment === item.segment ? 'text-blue-500' : 'text-gray-700'"
                               class="hover:text-blue-500 font-medium flex items-center gap-2">
                                <span class="material-icons w-[30px]" x-text="item.icon"></span>
                                <span x-text="item.text"></span>
                            </a>
                        </li>
                    </template>
                </ul>
            </nav>
        </aside>

        <main class="w-full md:w-5/6">
            @if(Session::has('message'))
                <div class="shadow rounded-lg py-2 px-4 mb-4 bg-green-200 border text-green-700 border-green-300">
                    <p class="alert">{{ session()->get('message') }}</p>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                @yield('content')
            </div>

        </main>

    </div>
</div>

@yield('scripts')

<script>
    function nav() {
        return {
            currentSegment: '{{ request()->segment(2) }}',
            menuItems: [
                { href: '{{ route('admin.index') }}', segment: '', icon: 'home', text: 'Главная' },
                { href: '{{ route('admin.articles.index') }}', segment: 'articles', icon: 'article', text: 'Статьи' },
                { href: '{{ route('admin.events.index') }}', segment: 'events', icon: 'events', text: 'События' },
                { href: '{{ route('admin.advises.index') }}', segment: 'advises', icon: 'sms', text: 'Советы' },
                { href: '{{ route('admin.complex.index') }}', segment: 'complex', icon: 'view_stream', text: 'Комплексы' },
                { href: '{{ route('admin.products.index') }}', segment: 'products', icon: 'sell', text: 'Продукты' },
                { href: '{{ route('admin.questions.index') }}', segment: 'questions', icon: 'help', text: 'Вопросы' },
                { href: '{{ route('admin.points.index') }}', segment: 'points', icon: 'navigation', text: 'Точки' },
                { href: '{{ route('admin.steps.index') }}', segment: 'steps', icon: 'stairs_2', text: 'Этапы подготовки' },
                { href: '{{ route('admin.faq.index') }}', segment: 'faq', icon: 'help', text: 'Вопросы - ответы' },
                { href: '{{ route('admin.pages.index') }}', segment: 'pages', icon: 'pages', text: 'Страницы' },
                { href: '{{ route('admin.subscribers.index') }}', segment: 'subscribers', icon: 'mail', text: 'Подписчики' },
                { href: '#', segment: 'divider', icon: '', text: '' }, // Separator
                { href: '{{ route('admin.users.index') }}', segment: 'users', icon: 'person', text: 'Пользователи' },
                { href: '{{ route('admin.config.edit') }}', segment: 'config', icon: 'settings', text: 'Настройки' }
            ]
        };
    }
</script>
</body>
</html>
