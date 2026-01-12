<label class="block font-semibold mb-2">{{ $title }}</label>

<!-- Превью загруженного изображения -->
<div x-show="form.{{ $field }}" class="mb-4">
    <img :src="form.{{ $field }}" alt="Изображение" class="max-w-full max-h-[300px] border rounded">
    <button @click.prevent="removeImage('{{ $field }}')" class="mt-2 py-1 px-3 bg-red-500 text-white rounded hover:bg-red-600">
        Удалить изображение
    </button>
</div>

<!-- Кнопка загрузки -->
<label
    x-show="!form.{{ $field }}"
    class="block w-full h-[220px] border-2 border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer hover:border-blue-400 transition"
>
    <p>Перетащите изображение сюда <br>или нажмите для загрузки <br><span class="text-sm text-gray-500">(рекомендуемый размер: {{ $width ?? 1280 }}×{{ $height ?? 853 }})</span></p>
    <input type="file" @change="openImageCropper($event, '{{ $field }}', {{ $width ?? 1280 }}, {{ $height ?? 853 }})" accept="image/*" class="hidden">
</label>

<!-- Модальное окно для обрезки изображения -->
<div x-show="cropperModal.show && cropperModal.field === '{{ $field }}'" 
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
     @click.self="closeCropper()">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Обрезка изображения ({{ $width ?? 1280 }}×{{ $height ?? 853 }})</h3>
            <button @click="closeCropper()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <div class="mb-4">
            <img :src="cropperModal.imageUrl" id="cropper-image-{{ $field }}" class="max-w-full">
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
