@extends('admin.layouts.base')

@section('content')
    @if(session('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.test-result-fields.index') }}" 
           class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
            ← Назад к списку
        </a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-4">Создать результат теста</h1>
    </div>

    <form action="{{ route('admin.test-result-fields.store') }}" method="POST" class="space-y-6" id="field-form">
        @csrf

        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Номер поля (1-9) *
                </label>
                <select name="field_number" 
                        id="field-number-input"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Выберите номер</option>
                    @for($i = 1; $i <= 9; $i++)
                        <option value="{{ $i }}" {{ old('field_number') == $i ? 'selected' : '' }}>Поле {{ $i }}</option>
                    @endfor
                </select>
                @error('field_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Описание рекомендации *
                </label>
                <textarea name="description" 
                          id="description-input"
                          rows="5" 
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Этот текст будет вставлен в &lt;p class="reprotest-p"&gt;</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Расширенное описание рекомендаций - email
                </label>
                <textarea name="email_description" 
                          id="email-description-input"
                          rows="8" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 editor">{{ old('email_description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Расширенное описание для отправки в email. Если не заполнено, будет использовано обычное описание.</p>
                @error('email_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Цвет блока
                </label>
                <select name="color" 
                        id="color-input"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">По умолчанию (фиолетовый)</option>
                    <option value="green" {{ old('color') == 'green' ? 'selected' : '' }}>Зеленый</option>
                    <option value="lavender" {{ old('color') == 'lavender' ? 'selected' : '' }}>Лавандовый</option>
                    <option value="orange" {{ old('color') == 'orange' ? 'selected' : '' }}>Оранжевый</option>
                </select>
                @error('color')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Продукт 1 -->
            <div class="mb-6 border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-700 mb-3">Продукт 1</h3>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Ссылка на продукт</label>
                    <input type="text" 
                           name="link1" 
                           value="{{ old('link1') }}"
                           placeholder="/product-protect#first" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    @error('link1')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Изображение продукта</label>
                    <div class="border-2 border-dashed border-gray-300 rounded p-4 text-center">
                        <input type="file" 
                               accept="image/*" 
                               class="hidden" 
                               id="image1-input"
                               onchange="handleImageUpload(this, 1)">
                        <div id="image1-preview">
                            <p class="text-xs text-gray-500 mb-2">Нажмите для загрузки изображения</p>
                            <button type="button" 
                                    onclick="document.getElementById('image1-input').click()"
                                    class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                                Выбрать изображение
                            </button>
                            <img src="" alt="Preview" class="hidden max-w-full max-h-32 mt-2 mx-auto rounded">
                        </div>
                        <input type="hidden" name="image1" id="image1-base64" value="">
                    </div>
                    @error('image1')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Продукт 2 -->
            <div class="mb-6 border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-700 mb-3">Продукт 2</h3>
                
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Ссылка на продукт</label>
                    <input type="text" 
                           name="link2" 
                           value="{{ old('link2') }}"
                           placeholder="/product-protect#second" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                    @error('link2')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Изображение продукта</label>
                    <div class="border-2 border-dashed border-gray-300 rounded p-4 text-center">
                        <input type="file" 
                               accept="image/*" 
                               class="hidden" 
                               id="image2-input"
                               onchange="handleImageUpload(this, 2)">
                        <div id="image2-preview">
                            <p class="text-xs text-gray-500 mb-2">Нажмите для загрузки изображения</p>
                            <button type="button" 
                                    onclick="document.getElementById('image2-input').click()"
                                    class="bg-blue-500 text-white px-4 py-2 rounded text-sm hover:bg-blue-600">
                                Выбрать изображение
                            </button>
                            <img src="" alt="Preview" class="hidden max-w-full max-h-32 mt-2 mx-auto rounded">
                        </div>
                        <input type="hidden" name="image2" id="image2-base64" value="">
                    </div>
                    @error('image2')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="active" 
                           value="1" 
                           {{ old('active', true) ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Активно</span>
                </label>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Порядок сортировки
                </label>
                <input type="number" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                Создать результат
            </button>
            <a href="{{ route('admin.test-result-fields.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Отмена
            </a>
        </div>
    </form>

    <script>
        function handleImageUpload(input, imageNumber) {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const base64 = e.target.result;
                const preview = document.querySelector(`#image${imageNumber}-preview img`);
                const hiddenInput = document.getElementById(`image${imageNumber}-base64`);
                
                if (preview) {
                    preview.src = base64;
                    preview.classList.remove('hidden');
                    const buttons = document.querySelector(`#image${imageNumber}-preview p, #image${imageNumber}-preview button`);
                    if (buttons) buttons.style.display = 'none';
                }
                
                if (hiddenInput) {
                    hiddenInput.value = base64;
                }
            };
            reader.readAsDataURL(file);
        }

        // Очистка формы после успешного сохранения
        @if(session('message'))
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('field-form').reset();
                document.getElementById('image1-base64').value = '';
                document.getElementById('image2-base64').value = '';
                const previews = document.querySelectorAll('#image1-preview img, #image2-preview img');
                previews.forEach(img => {
                    img.classList.add('hidden');
                    img.src = '';
                });
            });
        @endif

        // Инициализация TinyMCE для поля email_description
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof tinymce !== 'undefined') {
                tinymce.init({
                    selector: '#email-description-input',
                    license_key: 'gpl',
                    height: 300,
                    menubar: false,
                    language: 'ru',
                    language_url: '/js/ru.min.js',
                    plugins: 'advlist autolink lists link image charmap preview anchor code',
                    toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                    setup: (editor) => {
                        editor.on('change', () => {
                            // Синхронизация при изменении
                            document.getElementById('email-description-input').value = editor.getContent();
                        });
                    }
                });
            }
        });

        // Синхронизация TinyMCE перед отправкой формы
        document.getElementById('field-form').addEventListener('submit', function(e) {
            if (typeof tinymce !== 'undefined' && tinymce.get('email-description-input')) {
                tinymce.get('email-description-input').save();
            }
        });
    </script>
@endsection
