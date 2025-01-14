<div class="space-y-4">
    <label class="block text-lg font-semibold text-gray-700 mb-2">{{ $title }}</label>

    <div class="flex items-center space-x-4 border-2 border-gray-300 rounded-lg p-3 hover:border-blue-500 transition">
        <input type="hidden" x-model="form.{{$field}}">

        <input
            type="file"
            @change="fileUpload($event, '{{$field}}')"
            class="file:border file:border-gray-300 file:rounded-lg file:px-4 file:py-2 file:text-gray-700 file:bg-gray-100 hover:file:bg-gray-200 transition"
        >

        <a
            :href="form.{{$field}}"
            target="_blank"
            x-show="form.{{$field}}"
            class="text-blue-600 hover:text-blue-800 transition"
        >
            Открыть
        </a>
    </div>
</div>
