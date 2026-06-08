@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} комплекс</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            {{-- Изображения --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 1', 'field' => 'image_left'])
                    @include('admin.components.text-input', ['title' => 'Alt текст для фото 1', 'field' => 'alt_left'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_left'])
                    @include('admin.components.text-input', ['title' => 'Якорь (алиас продукта)', 'field' => 'anchor_left'])
                </div>
                <div>
                    @include('admin.components.image-input', ['title' => 'Фото товара 2', 'field' => 'image_right'])
                    @include('admin.components.text-input', ['title' => 'Alt текст для фото 2', 'field' => 'alt_right'])
                    @include('admin.components.text-input', ['title' => 'CSS класс для блока', 'field' => 'title_right'])
                    @include('admin.components.text-input', ['title' => 'Якорь (алиас продукта)', 'field' => 'anchor_right'])
                </div>
            </div>

            {{-- Основная информация --}}
            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>
            <div>@include('admin.components.text-input', ['title' => 'Подзаголовок', 'field' => 'subtitle'])</div>
            <div>@include('admin.components.select-input', ['title' => 'Цвет', 'field' => 'color', 'options' => ['green' => 'Зеленый', 'purple' => 'Пурпурный', 'mandarin' => 'Оранжевый']])</div>
            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>
            <div>@include('admin.components.textarea-input', ['title' => 'Описание товара', 'field' => 'content'])</div>

            {{-- SEO настройки --}}
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    SEO настройки
                </h3>
                <p class="text-sm text-gray-500 mb-4">Эти поля заменяют автоматически сгенерированные мета-теги на странице комплекса. Если поле пустое — используется значение по умолчанию.</p>

                <div class="bg-gray-50 rounded-lg p-4 space-y-4">
                    <div>
                        @include('admin.components.text-input', [
                            'title' => 'SEO заголовок (title)',
                            'field' => 'seo_title',
                            'placeholder' => 'Например: РепроРелакс — Комплекс для снятия стресса | Система РЕПРО',
                        ])
                        <p class="text-xs text-gray-400 mt-1">Рекомендуемая длина: 50–60 символов. Если пусто — формируется из названия комплекса автоматически.</p>
                    </div>

                    <div>
                        @include('admin.components.text-input', [
                            'title' => 'SEO описание (meta description)',
                            'field' => 'seo_description',
                            'placeholder' => 'Краткое описание страницы для поисковых систем и соцсетей (OG)',
                        ])
                        <p class="text-xs text-gray-400 mt-1">Рекомендуемая длина: 120–160 символов. Используется также как og:description.</p>
                    </div>

                    <div>
                        @include('admin.components.textarea-input', [
                            'title' => 'Ключевые слова (meta keywords)',
                            'field' => 'seo_keywords',
                            'rows' => 2,
                            'no_editor' => true,
                            'placeholder' => 'репро, релакс, витамины, стресс',
                        ])
                        <p class="text-xs text-gray-400 mt-1">Перечислите через запятую. Не влияет на ранжирование в Google, но может учитываться в Яндексе.</p>
                    </div>
                </div>
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
                form: {
                    title_left: 'hero-product-1',
                    title_right: 'hero-product-2',
                    active: 1,
                },
            }
        }
    </script>
@endsection
