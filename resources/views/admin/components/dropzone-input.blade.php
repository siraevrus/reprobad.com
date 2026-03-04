<div class="container mx-auto">
    <label class="block font-semibold mb-2">{{ $title }}</label>
    <label for="dropzone-{{$field}}"
        class="border-2 border-dashed block border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-gray-500"
        :class="{ 'border-green-500': isDragging }"
        @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false"
        @drop.prevent="handleDropzoneDrop($event, '{{$field}}')">
        <p class="text-gray-500">Перетащите файлы сюда или нажмите, чтобы выбрать</p>
        <input
            type="file"
            id="dropzone-{{$field}}"
            multiple accept="image/*"
            hidden
            @change="handleDropzoneFiles($event, '{{$field}}')">
    </label>
    <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        <template x-for="(image, index) in form.{{$field}}" :key="index">
            <div class="relative group cursor-move border rounded-lg p-2 bg-gray-50"
                 draggable="true"
                 @dragstart="dragDropzoneImageStart($event, index, '{{$field}}')"
                 @dragover.prevent="dragDropzoneImageOver($event, index, '{{$field}}')"
                 @drop.prevent="dropDropzoneImage($event, index, '{{$field}}')"
                 @dragend="dragDropzoneImageEnd($event, '{{$field}}')">
                <img :src="image.url" :alt="image.alt || image.name || ''" class="rounded-lg w-full h-auto"
                     :class="image.remove ? 'opacity-25' : ''"
                >
                <input type="text"
                       class="mt-2 w-full text-sm border border-gray-300 rounded px-2 py-1"
                       placeholder="Alt-подпись к изображению"
                       x-model="form.{{$field}}[index].alt"
                       @click.stop>
                <button
                    class="absolute top-2 right-2 bg-red-500 text-white p-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity"
                    @click.prevent="removeDropzoneImage(index, '{{$field}}')">&times;</button>
            </div>
        </template>
    </div>
</div>
