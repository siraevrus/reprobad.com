<label class="block font-semibold mb-2">{{ $title }}</label>
<select type="text" x-model="form.{{ $field }}" class="w-full p-2 border rounded">
    @if(isset($options))
        <option value=""> - </option>
        @foreach($options as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
        @endforeach
    @endif
</select>
<div class="text-red-500 text-xs mt-1" x-text="errors.{{ $field }}"></div>
