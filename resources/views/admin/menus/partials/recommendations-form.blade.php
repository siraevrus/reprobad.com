<div>
    <h3 class="text-lg font-semibold mb-4">Рекомендации</h3>
    
    <!-- Заголовок рекомендаций -->
    <div class="mb-6">
        <label class="block font-semibold mb-2">Заголовок</label>
        <input type="text" x-model="menuData.recommendations.title" class="w-full p-2 border rounded" placeholder="Рекомендации по заготовкам продуктов на следующий день">
    </div>

    <!-- Список рекомендаций -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold">Рекомендации (список)</h4>
            <button type="button" @click="addRecommendationContent()" class="px-4 py-2 bg-green-500 text-white rounded text-sm">+ Добавить</button>
        </div>
        <template x-for="(item, index) in (menuData.recommendations.content || [])" :key="index">
            <div class="flex gap-2 mb-2">
                <textarea x-model="menuData.recommendations.content[index]" class="flex-1 p-2 border rounded" rows="2" placeholder="Текст рекомендации"></textarea>
                <button type="button" @click="removeRecommendationContent(index)" class="px-3 py-2 bg-red-500 text-white rounded text-sm h-fit">Удалить</button>
            </div>
        </template>
    </div>

    <!-- Предпросмотр следующего дня -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold">Предпросмотр следующего дня</h4>
            <button type="button" @click="addNextDayPreview()" class="px-4 py-2 bg-green-500 text-white rounded text-sm">+ Добавить</button>
        </div>
        <template x-for="(preview, index) in (menuData.recommendations.next_day_preview || [])" :key="index">
            <div class="border rounded p-4 mb-3">
                <div class="flex justify-between items-start mb-3">
                    <h5 class="font-medium">Предпросмотр <span x-text="index + 1"></span></h5>
                    <button type="button" @click="removeNextDayPreview(index)" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Удалить</button>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm mb-1">Прием пищи</label>
                        <input type="text" x-model="preview.meal" class="w-full p-2 border rounded" placeholder="Завтрак">
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Описание</label>
                        <input type="text" x-model="preview.description" class="w-full p-2 border rounded" placeholder="Описание блюда">
                    </div>
                </div>
                <div>
                    <label class="block text-sm mb-1">Изображение</label>
                    <label class="block w-full h-[150px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center cursor-pointer">
                        <p x-show="!preview.image" class="text-xs text-gray-500">Загрузить изображение</p>
                        <img :src="preview.image" alt="" class="max-w-full max-h-full" x-show="preview.image">
                        <input type="file" @change="uploadImageToArray($event, menuData.recommendations.next_day_preview, index, 'image')" class="hidden" accept="image/*">
                        <button x-show="preview.image" @click.prevent="preview.image = ''" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white text-xs">&times;</button>
                    </label>
                </div>
            </div>
        </template>
    </div>
</div>
