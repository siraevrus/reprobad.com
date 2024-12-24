<!-- Кнопки -->
<div class="flex justify-end gap-4">
    <button type="reset" class="px-6 py-2 bg-gray-200 text-gray-600 rounded-lg hover:bg-gray-300">
        Отмена
    </button>
    <button :disabled="loading" type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg disabled:bg-gray-400 hover:bg-blue-600">
        Сохранить
    </button>
</div>
