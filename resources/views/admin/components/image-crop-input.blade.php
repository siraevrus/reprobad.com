<style>
    .cropper-modal {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
    .cropper-view-box,
    .cropper-face {
        border-radius: 0 !important;
    }
</style>

<label class="block font-semibold mb-2">{{ $title }}</label>

<!-- Отладочная информация -->
<div class="text-xs text-gray-400 mb-2">
    <div x-data="{ test: 'Alpine работает!' }" x-text="test"></div>
    <div x-init="console.log('Проверка методов:', { hasOpenImageCropper: typeof openImageCropper !== 'undefined', hasCropperModal: typeof cropperModal !== 'undefined' });"></div>
</div>

<!-- Превью загруженного изображения -->
<div x-show="form.{{ $field }}" class="mb-4">
    <img :src="form.{{ $field }}" alt="Изображение" class="max-w-full max-h-[300px] border rounded">
    <div class="mt-2 flex gap-2">
        <label for="file-input-replace-{{ $field }}" class="py-1 px-3 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
            Заменить изображение
        </label>
        <input 
            type="file" 
            id="file-input-replace-{{ $field }}"
            @change="(e) => { 
                console.log('=== REPLACE FILE INPUT CHANGED ===');
                console.log('Event:', e);
                console.log('Files:', e.target.files);
                console.log('openImageCropper type:', typeof openImageCropper);
                if (typeof openImageCropper === 'function') {
                    console.log('Вызываю openImageCropper...');
                    openImageCropper(e, '{{ $field }}', {{ $width ?? 1280 }}, {{ $height ?? 853 }});
                } else {
                    console.error('openImageCropper не найден!');
                    alert('Ошибка: метод openImageCropper не найден. Проверьте консоль.');
                }
            }" 
            accept="image/*" 
            class="hidden">
        <button @click.prevent="removeImage('{{ $field }}')" class="py-1 px-3 bg-red-500 text-white rounded hover:bg-red-600">
            Удалить изображение
        </button>
    </div>
</div>

<!-- Кнопка загрузки -->
<div x-show="!form.{{ $field }}" class="mb-2">
    <label
        for="file-input-{{ $field }}"
        class="block w-full h-[220px] border-2 border-dashed border-gray-300 rounded flex items-center text-center justify-center cursor-pointer hover:border-blue-400 transition"
    >
        <p>Перетащите изображение сюда <br>или нажмите для загрузки <br><span class="text-sm text-gray-500">(рекомендуемый размер: {{ $width ?? 1280 }}×{{ $height ?? 853 }})</span></p>
    </label>
    <input 
        type="file" 
        id="file-input-{{ $field }}"
        @change="(e) => { 
            console.log('=== FILE INPUT CHANGED ===');
            console.log('Event:', e);
            console.log('Files:', e.target.files);
            console.log('openImageCropper type:', typeof openImageCropper);
            console.log('this:', this);
            if (typeof openImageCropper === 'function') {
                console.log('Вызываю openImageCropper...');
                openImageCropper(e, '{{ $field }}', {{ $width ?? 1280 }}, {{ $height ?? 853 }});
            } else {
                console.error('openImageCropper не найден!');
                alert('Ошибка: метод openImageCropper не найден. Проверьте консоль.');
            }
        }" 
        accept="image/*" 
        class="hidden">
</div>

<!-- Модальное окно для обрезки изображения -->
<div x-show="cropperModal && cropperModal.show && cropperModal.field === '{{ $field }}'" 
     x-cloak
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
     style="z-index: 9999; display: none;"
     @click.self="closeCropper()">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Обрезка изображения ({{ $width ?? 1280 }}×{{ $height ?? 853 }})</h3>
            <button @click="closeCropper()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="mb-4" style="max-height: 60vh; overflow: auto;">
            <img :src="cropperModal.imageUrl" id="cropper-image-{{ $field }}" style="max-width: 100%; display: block;">
        </div>
        
        <div class="flex justify-end space-x-2">
            <button @click="closeCropper()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                Отмена
            </button>
            <button @click="cropAndSaveImage('{{ $field }}')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Сохранить
            </button>
        </div>
    </div>
</div>
