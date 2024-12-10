<label class="block font-semibold mb-2">{{ $title }}</label>
<label
    class="block w-full w-lg-half h-[220px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center mb-2 cursor-pointer"
>
    <p x-show="!form.{{ $field }}">Перетащите изображение сюда <br>или нажмите для загрузки</p>
    <input type="file" @change="uploadImage($event, '{{ $field }}')" class="hidden" x-ref="fileInput">
    <img :src="form.{{ $field }}" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="form.{{ $field }}">
    <button x-show="form.image_left" @click="removeImage('{{ $field }}')" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
</label>
