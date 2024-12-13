<label class="block font-semibold mb-2">{{ $title }}</label>
<input type="color" x-model="form.{{ $field }}" class="w-full border rounded" placeholder="">
<div class="text-red-500 text-xs mt-1" x-text="errors.{{ $field }}"></div>
