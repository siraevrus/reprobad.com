<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <!-- alpine -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- tinymce -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.5.0/tinymce.min.js"></script>

    <!-- cropper -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- alpine mixins -->
    <script src="/js/utils.js"></script>

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
    <div class="flex gap-6">
        <!-- Боковая панель -->
        <aside class="w-1/6">
            <nav class="sticky top-4">
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('admin.index') }}" class="{{ request()->segment(2) == '' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">home</span> Главная
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.articles.index') }}" class="{{ request()->segment(2) == 'articles' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">article</span> Статьи
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events.index') }}" class="{{ request()->segment(2) == 'events' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">events</span> События
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.advises.index') }}" class="{{ request()->segment(2) == 'advises' ? 'text-blue-500' : 'text-gray-700' }}  hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">sms</span> Советы
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.complex.index') }}" class="{{  request()->segment(2) == 'complex' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">view_stream</span> Комплексы
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="{{  request()->segment(2) == 'products' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">sell</span> Продукты
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.questions.index') }}" class="{{  request()->segment(2) == 'questions' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">help</span> Вопросы
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.points.index') }}" class="{{  request()->segment(2) == 'points' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">navigation</span> Точки
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.steps.index') }}" class="{{  request()->segment(2) == 'steps' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span style="width:24px" class="material-icons">stairs_2</span> Этапы подготовки
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pages.index') }}" class="{{ request()->segment(2) == 'pages' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">pages</span> Страницы
                        </a>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->segment(2) == 'users' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">person</span> Пользователи
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.config.edit') }}" class="{{ request()->segment(2) == 'config' ? 'text-blue-500' : 'text-gray-700' }} hover:text-blue-500 font-medium flex items-center gap-2">
                            <span class="material-icons">settings</span> Настройки
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="w-5/6">
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
</body>
</html>
