<label class="block font-semibold mb-2">{{ $title }}</label>
<textarea x-model="form.{{ $field }}" class="w-full p-2 border rounded editor"></textarea>
<div class="text-red-500 text-xs mt-1" x-text="errors.{{ $field }}"></div>
<div x-show="!errors.{{ $field }}" class="text-gray-400 text-xs mt-1"></div>
