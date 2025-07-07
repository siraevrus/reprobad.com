@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Редактировать SEO данные</h1>
        <a href="{{ route('admin.seo.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
            Назад
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.seo.update', $seo->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Тип страницы</label>
                    <input type="text" value="{{ $seo->page_type }}" disabled
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50">
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Основные SEO поля</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Title <span class="text-gray-500">(до 60 символов)</span>
                        </label>
                        <input type="text" name="title" id="title" maxlength="60" value="{{ $seo->title }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="title-count">{{ strlen($seo->title) }}</span>/60 символов
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Description <span class="text-gray-500">(до 160 символов)</span>
                        </label>
                        <textarea name="description" id="description" rows="3" maxlength="160"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ $seo->description }}</textarea>
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="description-count">{{ strlen($seo->description) }}</span>/160 символов
                        </div>
                    </div>

                    <div>
                        <label for="keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <textarea name="keywords" id="keywords" rows="2"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="ключевое слово 1, ключевое слово 2, ключевое слово 3">{{ $seo->keywords }}</textarea>
                    </div>
                </div>
            </div>

            <div class="border-t pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Open Graph поля</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="og_title" class="block text-sm font-medium text-gray-700 mb-2">
                            OG Title <span class="text-gray-500">(до 60 символов)</span>
                        </label>
                        <input type="text" name="og_title" id="og_title" maxlength="60" value="{{ $seo->og_title }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="og-title-count">{{ strlen($seo->og_title) }}</span>/60 символов
                        </div>
                    </div>

                    <div>
                        <label for="og_description" class="block text-sm font-medium text-gray-700 mb-2">
                            OG Description <span class="text-gray-500">(до 160 символов)</span>
                        </label>
                        <textarea name="og_description" id="og_description" rows="3" maxlength="160"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ $seo->og_description }}</textarea>
                        <div class="mt-1 text-sm text-gray-500">
                            <span id="og-description-count">{{ strlen($seo->og_description) }}</span>/160 символов
                        </div>
                    </div>

                    <div>
                        <label for="og_image" class="block text-sm font-medium text-gray-700 mb-2">OG Image URL</label>
                        <input type="url" name="og_image" id="og_image" value="{{ $seo->og_image }}"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://example.com/image.jpg">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.seo.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Отмена
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600">
                    Обновить
                </button>
            </div>
        </form>
    </div>

    <script>
        // Счетчики символов
        function updateCounter(inputId, counterId) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            
            input.addEventListener('input', function() {
                counter.textContent = this.value.length;
            });
        }

        updateCounter('title', 'title-count');
        updateCounter('description', 'description-count');
        updateCounter('og_title', 'og-title-count');
        updateCounter('og_description', 'og-description-count');
    </script>
@endsection 