<div class="flex gap-4">
    <label class="block font-semibold mb-2">{{ $title }}</label>
    <input type="color" x-model="form.{{ $field }}" class="p-0 w-[30px] rounded">
    <div class="text-red-500 text-xs mt-1" x-text="errors.{{ $field }}"></div>
</div>
