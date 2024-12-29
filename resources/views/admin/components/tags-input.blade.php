<div class="mt-6">
    <label class="block font-semibold mb-2">{{$title}}</label>
    <div
        class="flex items-center flex-wrap gap-2 border border-gray-300 rounded-lg p-3">
        <template x-for="(tag, index) in form.{{$field}}" :key="index">
            <span
                class="bg-blue-500 text-white text-sm rounded-full px-3 py-1 flex items-center gap-2">
            <span x-text="tag"></span>
            <button
                class="text-white"
                @click.prevent="removeTag(index, '{{$field}}')">&times;</button>
            </span>
        </template>
        <input
            type="text"
            x-ref="tagInput"
            x-model="form.{{$field}}_input"
            @keydown.enter.prevent="addTag('{{$field}}')"
            placeholder="Введите тег..."
            class="flex-grow focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg px-3 py-1">
    </div>
</div>
