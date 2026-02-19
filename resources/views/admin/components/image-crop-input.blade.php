<label class="block font-semibold mb-2">{{ $title }}</label>

<div id="image-crop-container-{{ $field }}" class="image-crop-container">
    <!-- Превью загруженного изображения -->
    <div id="preview-{{ $field }}" class="mb-4" style="display: none;">
        <img id="preview-img-{{ $field }}" src="" alt="Изображение" class="max-w-full max-h-[300px] border rounded">
        <div class="mt-2 flex gap-2">
            <label for="file-input-replace-{{ $field }}" class="py-1 px-3 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
                Заменить изображение
            </label>
            <button onclick="removeImage{{ $field }}()" class="py-1 px-3 bg-red-500 text-white rounded hover:bg-red-600">
                Удалить изображение
            </button>
        </div>
    </div>

    <!-- Кнопка загрузки -->
    <div id="upload-area-{{ $field }}">
        <label
            for="file-input-{{ $field }}"
            class="block w-full h-[220px] border-2 border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer hover:border-blue-400 transition"
        >
            <p>Перетащите изображение сюда <br>или нажмите для загрузки <br><span class="text-sm text-gray-500">(рекомендуемый размер: {{ $width ?? 1280 }}×{{ $height ?? 853 }})</span></p>
        </label>
        <input 
            type="file" 
            id="file-input-{{ $field }}"
            accept="image/*" 
            class="hidden">
        <input 
            type="file" 
            id="file-input-replace-{{ $field }}"
            accept="image/*" 
            class="hidden">
    </div>

    <!-- Скрытое поле для хранения base64 изображения с синхронизацией через Alpine.js -->
    <input type="hidden" id="hidden-image-{{ $field }}" name="{{ $field }}" x-model="form.{{ $field }}" value="">
</div>

<!-- Модальное окно для обрезки изображения -->
<div id="cropper-modal-{{ $field }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display: none; z-index: 9999;">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Обрезка изображения ({{ $width ?? 1280 }}×{{ $height ?? 853 }})</h3>
            <button onclick="closeCropper{{ $field }}()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="mb-4" style="max-height: 60vh; overflow: auto;">
            <img id="cropper-image-{{ $field }}" style="max-width: 100%; display: block;">
        </div>
        
        <div class="flex justify-end space-x-2">
            <button onclick="closeCropper{{ $field }}()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Отмена
            </button>
            <button onclick="cropAndSave{{ $field }}()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Сохранить
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    const field = '{{ $field }}';
    const targetWidth = {{ $width ?? 1280 }};
    const targetHeight = {{ $height ?? 853 }};
    let cropperInstance = null;
    
    // Функция для обновления Alpine.js формы
    function updateAlpineForm(fieldName, value) {
        console.log('Обновление формы для поля:', fieldName, 'значение:', value ? 'base64 данные (' + value.length + ' символов)' : 'пусто');
        
        // Обновляем напрямую через Alpine (приоритетный способ)
        if (window.Alpine) {
            const alpineComponent = document.querySelector('[x-data*="app()"]');
            if (alpineComponent) {
                try {
                    const data = Alpine.$data(alpineComponent);
                    if (data && data.form) {
                        data.form[fieldName] = value || null;
                        console.log('Форма обновлена через Alpine.$data');
                    }
                } catch (e) {
                    console.warn('Ошибка при обновлении через Alpine.$data:', e);
                    // Альтернативный способ через _x_dataStack
                    if (alpineComponent._x_dataStack && alpineComponent._x_dataStack.length > 0) {
                        const data = alpineComponent._x_dataStack[0];
                        if (data && data.form) {
                            data.form[fieldName] = value || null;
                            console.log('Форма обновлена через _x_dataStack');
                        }
                    }
                }
            }
        }
        
        // Обновляем скрытое поле, которое связано с x-model
        const hiddenInput = document.getElementById('hidden-image-' + fieldName);
        if (hiddenInput) {
            hiddenInput.value = value || '';
            // Триггерим событие input для Alpine.js
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }
    
    // Проверяем наличие Cropper.js
    if (typeof Cropper === 'undefined') {
        console.error('Cropper.js не загружен!');
        alert('Ошибка: библиотека Cropper.js не загружена. Пожалуйста, обновите страницу.');
        return;
    }
    
    function openCropper(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const modal = document.getElementById('cropper-modal-' + field);
            const img = document.getElementById('cropper-image-' + field);
            
            img.src = e.target.result;
            modal.style.display = 'flex';
            
            // Уничтожаем предыдущий cropper, если есть
            if (cropperInstance) {
                cropperInstance.destroy();
            }
            
            // Инициализируем новый cropper
            cropperInstance = new Cropper(img, {
                aspectRatio: targetWidth / targetHeight,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
            });
        };
        reader.readAsDataURL(file);
    }
    
    function closeCropper() {
        const modal = document.getElementById('cropper-modal-' + field);
        modal.style.display = 'none';
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
    }
    
    function cropAndSave() {
        if (!cropperInstance) {
            alert('Ошибка: редактор не инициализирован');
            return;
        }
        
        const canvas = cropperInstance.getCroppedCanvas({
            width: targetWidth,
            height: targetHeight,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        if (canvas) {
            const croppedImageUrl = canvas.toDataURL('image/jpeg', 0.9);
            
            // Обновляем Alpine.js форму ПЕРЕД обновлением скрытого поля
            updateAlpineForm(field, croppedImageUrl);
            
            // Сохраняем в скрытое поле (после обновления формы)
            const hiddenInput = document.getElementById('hidden-image-' + field);
            if (hiddenInput) {
                hiddenInput.value = croppedImageUrl;
                // Триггерим событие для Alpine.js
                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            
            // Показываем превью
            document.getElementById('preview-img-' + field).src = croppedImageUrl;
            document.getElementById('preview-' + field).style.display = 'block';
            document.getElementById('upload-area-' + field).style.display = 'none';
            
            closeCropper();
        }
    }
    
    function removeImage() {
        // Обновляем Alpine.js форму ПЕРЕД обновлением скрытого поля
        updateAlpineForm(field, null);
        
        // Очищаем скрытое поле
        const hiddenInput = document.getElementById('hidden-image-' + field);
        if (hiddenInput) {
            hiddenInput.value = '';
            // Триггерим событие для Alpine.js
            hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
        }
        
        document.getElementById('preview-' + field).style.display = 'none';
        document.getElementById('upload-area-' + field).style.display = 'block';
    }
    
    // Обработчики событий
    document.getElementById('file-input-' + field).addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            openCropper(file);
        }
    });
    
    document.getElementById('file-input-replace-' + field).addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            openCropper(file);
        }
    });
    
    // Экспортируем функции глобально для Alpine.js
    window['openCropper' + field] = openCropper;
    window['closeCropper' + field] = closeCropper;
    window['cropAndSave' + field] = cropAndSave;
    window['removeImage' + field] = removeImage;
    
    // Загружаем существующее изображение при редактировании
    function loadExistingImage() {
        const alpineComponent = document.querySelector('[x-data*="app()"]');
        if (alpineComponent) {
            let formData = null;
            try {
                formData = Alpine.$data(alpineComponent);
            } catch (e) {
                if (alpineComponent._x_dataStack && alpineComponent._x_dataStack.length > 0) {
                    formData = alpineComponent._x_dataStack[0];
                }
            }
            
            if (formData && formData.form && formData.form[field]) {
                const imageValue = formData.form[field];
                // Проверяем, что это не пустая строка и не null
                if (imageValue && imageValue !== '') {
                    document.getElementById('preview-img-' + field).src = imageValue;
                    document.getElementById('hidden-image-' + field).value = imageValue;
                    document.getElementById('preview-' + field).style.display = 'block';
                    document.getElementById('upload-area-' + field).style.display = 'none';
                }
            }
        }
    }
    
    // Загружаем изображение при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(loadExistingImage, 500);
        // Также проверяем после небольшой задержки на случай, если Alpine еще не инициализирован
        setTimeout(loadExistingImage, 1000);
    });
    
    // Слушаем изменения в Alpine форме через MutationObserver или события
    if (window.Alpine) {
        // Используем Alpine для отслеживания изменений формы
        document.addEventListener('alpine:init', function() {
            setTimeout(loadExistingImage, 100);
        });
    }
})();
</script>
