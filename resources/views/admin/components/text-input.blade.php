<label class="block font-semibold mb-2">{{ $title }}</label>
<input
    type="text"
    x-model="form.{{ $field }}"
    @if(($field ?? '') === 'title')
        @input="syncAliasFromTitle && syncAliasFromTitle()"
    @endif
    @if(($field ?? '') === 'alias')
        @input="markAliasManual && markAliasManual()"
    @endif
    class="w-full p-2 border rounded"
    placeholder="{{ $placeholder ?? '' }}"
>
@if(($field ?? '') === 'alias')
    <p class="text-gray-400 text-xs mt-1">Формируется автоматически из заголовка; можно изменить вручную.</p>
@endif
<div class="text-red-500 text-xs mt-1" x-text="errors.{{ $field }}"></div>
