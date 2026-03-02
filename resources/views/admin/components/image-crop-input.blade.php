<label class="block font-semibold mb-2">{{ $title }}</label>

<div id="image-crop-container-{{ $field }}" class="image-crop-container">
    <!-- Превью загруженного изображения -->
    <div id="preview-{{ $field }}" class="mb-4" style="display: none;">
        <img id="preview-img-{{ $field }}" src="" alt="Изображение" class="max-w-full max-h-[300px] border rounded">
        <div class="mt-2 flex gap-2">
            <label for="file-input-replace-{{ $field }}" class="py-1 px-3 bg-blue-500 text-white rounded hover:bg-blue-600 cursor-pointer">
                Заменить изображение
            </label>
            <button onclick="removeImage{{ $field }}()" type="button" class="py-1 px-3 bg-red-500 text-white rounded hover:bg-red-600">
                Удалить изображение
            </button>
        </div>
        <div id="upload-status-{{ $field }}" class="text-sm text-gray-500 mt-1" style="display: none;"></div>
    </div>

    <!-- Кнопка загрузки -->
    <div id="upload-area-{{ $field }}">
        <label
            for="file-input-{{ $field }}"
            class="block w-full h-[220px] border-2 border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer hover:border-blue-400 transition"
        >
            <p>Перетащите изображение сюда <br>или нажмите для загрузки <br><span class="text-sm text-gray-500">(рекомендуемый размер: {{ $width ?? 1280 }}×{{ $height ?? 853 }})</span></p>
        </label>
        <input type="file" id="file-input-{{ $field }}" accept="image/*" class="hidden">
        <input type="file" id="file-input-replace-{{ $field }}" accept="image/*" class="hidden">
    </div>
</div>

<!-- Модальное окно для обрезки изображения -->
<div id="cropper-modal-{{ $field }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" style="display: none; z-index: 9999;">
    <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Обрезка изображения ({{ $width ?? 1280 }}×{{ $height ?? 853 }})</h3>
            <button onclick="closeCropper{{ $field }}()" type="button" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="mb-4" style="max-height: 60vh; overflow: auto;">
            <img id="cropper-image-{{ $field }}" style="max-width: 100%; display: block;">
        </div>
        <div class="flex justify-end space-x-2">
            <button onclick="closeCropper{{ $field }}()" type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Отмена</button>
            <button onclick="cropAndSave{{ $field }}()" type="button" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Сохранить</button>
        </div>
    </div>
</div>

<script>
(function() {
    const field = '{{ $field }}';
    const targetWidth = {{ $width ?? 1280 }};
    const targetHeight = {{ $height ?? 853 }};
    let cropperInstance = null;
    let isUploading = false;

    if (typeof Cropper === 'undefined') {
        console.error('Cropper.js не загружен!');
        return;
    }

    function setAlpineFormField(fieldName, value) {
        const el = document.querySelector('[x-data*="app()"]');
        if (!el) return;
        try {
            const data = Alpine.$data(el);
            if (data && data.form) data.form[fieldName] = value;
        } catch (e) {
            if (el._x_dataStack && el._x_dataStack[0] && el._x_dataStack[0].form) {
                el._x_dataStack[0].form[fieldName] = value;
            }
        }
    }

    function showStatus(msg) {
        const el = document.getElementById('upload-status-' + field);
        if (el) { el.textContent = msg; el.style.display = msg ? 'block' : 'none'; }
    }

    function showPreview(url) {
        document.getElementById('preview-img-' + field).src = url;
        document.getElementById('preview-' + field).style.display = 'block';
        document.getElementById('upload-area-' + field).style.display = 'none';
    }

    function hidePreview() {
        document.getElementById('preview-' + field).style.display = 'none';
        document.getElementById('upload-area-' + field).style.display = 'block';
        showStatus('');
    }

    async function uploadBlob(blob) {
        isUploading = true;
        window.__adminUploadInProgress = true;
        showStatus('Загрузка...');
        const formData = new FormData();
        formData.append('file', blob, field + '.jpg');

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch('/admin/upload', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });
            const raw = await response.text();
            let data = {};
            try {
                data = JSON.parse(raw);
            } catch (e) {
                throw new Error('Некорректный ответ сервера: ' + raw.slice(0, 200));
            }

            if (data.success && data.url) {
                setAlpineFormField(field, data.url);
                showPreview(data.url);
                showStatus('');
                return data.url;
            } else {
                showStatus('Ошибка: ' + JSON.stringify(data.errors || data));
                setAlpineFormField(field, null);
                return null;
            }
        } catch (e) {
            showStatus('Ошибка сети: ' + e.message);
            setAlpineFormField(field, null);
            return null;
        } finally {
            isUploading = false;
            window.__adminUploadInProgress = false;
        }
    }

    function openCropper(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const modal = document.getElementById('cropper-modal-' + field);
            const img = document.getElementById('cropper-image-' + field);
            img.src = e.target.result;
            modal.style.display = 'flex';
            if (cropperInstance) cropperInstance.destroy();
            cropperInstance = new Cropper(img, {
                aspectRatio: targetWidth / targetHeight,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                background: false,
            });
        };
        reader.readAsDataURL(file);
    }

    function closeCropper() {
        document.getElementById('cropper-modal-' + field).style.display = 'none';
        if (cropperInstance) { cropperInstance.destroy(); cropperInstance = null; }
    }

    function cropAndSave() {
        if (!cropperInstance) return;
        const canvas = cropperInstance.getCroppedCanvas({
            width: targetWidth, height: targetHeight,
            imageSmoothingEnabled: true, imageSmoothingQuality: 'high',
        });
        if (!canvas) return;

        canvas.toBlob(async function(blob) {
            closeCropper();
            showPreview(URL.createObjectURL(blob));
            showStatus('Загрузка...');
            const uploadedUrl = await uploadBlob(blob);
            if (!uploadedUrl) {
                hidePreview();
            }
        }, 'image/jpeg', 0.9);
    }

    function removeImage() {
        setAlpineFormField(field, null);
        hidePreview();
    }

    // Обработчики
    document.getElementById('file-input-' + field).addEventListener('change', function(e) {
        if (e.target.files[0]) openCropper(e.target.files[0]);
        e.target.value = '';
    });
    document.getElementById('file-input-replace-' + field).addEventListener('change', function(e) {
        if (e.target.files[0]) openCropper(e.target.files[0]);
        e.target.value = '';
    });

    window['openCropper' + field] = openCropper;
    window['closeCropper' + field] = closeCropper;
    window['cropAndSave' + field] = cropAndSave;
    window['removeImage' + field] = removeImage;

    // При редактировании — показать существующее изображение
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const el = document.querySelector('[x-data*="app()"]');
            if (!el) return;
            let formData;
            try { formData = Alpine.$data(el); } catch(e) {
                formData = el._x_dataStack?.[0];
            }
            if (formData?.form?.[field]) {
                showPreview(formData.form[field]);
            }
        }, 600);
    });
})();
</script>
