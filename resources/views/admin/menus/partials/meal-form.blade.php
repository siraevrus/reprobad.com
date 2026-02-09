<div>
    <h3 class="text-lg font-semibold mb-4">{{ $mealName }}</h3>
    
    <!-- Изображения -->
    <div class="mb-6">
        <h4 class="font-semibold mb-3">Изображения</h4>
        <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-4">
            <p class="text-sm text-blue-800 mb-2"><strong>Требования к изображениям:</strong></p>
            <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                <li><strong>Формат:</strong> JPG, PNG, WebP</li>
                <li><strong>Изображение (основное):</strong> 600×400px, используется в карточках меню</li>
                <li><strong>Большое изображение:</strong> 768×512px, используется в детальном просмотре блюда</li>
                <li><strong>Маленькое изображение:</strong> 200×150px, используется в боковом меню навигации</li>
                <li><strong>Соотношение сторон:</strong> 3:2 (ширина:высота) - автоматически применяется при обрезке</li>
                <li><strong>Размер файла:</strong> до 2 МБ на изображение</li>
            </ul>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <!-- Основное изображение -->
            <div>
                <label class="block font-semibold mb-2">Изображение <span class="text-xs text-gray-500">(600×400px)</span></label>
                <div class="relative">
                    <label class="block w-full h-[150px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center cursor-pointer hover:border-blue-400 transition">
                        <div x-show="!menuData.{{ $mealKey }}.image" class="text-xs text-gray-500 px-2">
                            <p>Загрузить</p>
                            <p class="text-[10px] mt-1">600×400px</p>
                        </div>
                        <img :src="menuData.{{ $mealKey }}.image" alt="" class="max-w-full max-h-full object-cover rounded" x-show="menuData.{{ $mealKey }}.image">
                        <input type="file" @change="openImageCropper($event, '{{ $mealKey }}', 'image', 600, 400)" class="hidden" accept="image/jpeg,image/png,image/webp">
                        <button x-show="menuData.{{ $mealKey }}.image" @click.prevent="menuData.{{ $mealKey }}.image = ''" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white text-xs rounded">&times;</button>
                    </label>
                </div>
            </div>
            
            <!-- Большое изображение -->
            <div>
                <label class="block font-semibold mb-2">Большое изображение <span class="text-xs text-gray-500">(768×512px)</span></label>
                <div class="relative">
                    <label class="block w-full h-[150px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center cursor-pointer hover:border-blue-400 transition">
                        <div x-show="!menuData.{{ $mealKey }}.image_big" class="text-xs text-gray-500 px-2">
                            <p>Загрузить</p>
                            <p class="text-[10px] mt-1">768×512px</p>
                        </div>
                        <img :src="menuData.{{ $mealKey }}.image_big" alt="" class="max-w-full max-h-full object-cover rounded" x-show="menuData.{{ $mealKey }}.image_big">
                        <input type="file" @change="openImageCropper($event, '{{ $mealKey }}', 'image_big', 768, 512)" class="hidden" accept="image/jpeg,image/png,image/webp">
                        <button x-show="menuData.{{ $mealKey }}.image_big" @click.prevent="menuData.{{ $mealKey }}.image_big = ''" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white text-xs rounded">&times;</button>
                    </label>
                </div>
            </div>
            
            <!-- Маленькое изображение -->
            <div>
                <label class="block font-semibold mb-2">Маленькое изображение <span class="text-xs text-gray-500">(200×150px)</span></label>
                <div class="relative">
                    <label class="block w-full h-[150px] border-2 relative border-dashed border-gray-300 rounded flex items-center text-center justify-center cursor-pointer hover:border-blue-400 transition">
                        <div x-show="!menuData.{{ $mealKey }}.image_small" class="text-xs text-gray-500 px-2">
                            <p>Загрузить</p>
                            <p class="text-[10px] mt-1">200×150px</p>
                        </div>
                        <img :src="menuData.{{ $mealKey }}.image_small" alt="" class="max-w-full max-h-full object-cover rounded" x-show="menuData.{{ $mealKey }}.image_small">
                        <input type="file" @change="openImageCropper($event, '{{ $mealKey }}', 'image_small', 200, 150)" class="hidden" accept="image/jpeg,image/png,image/webp">
                        <button x-show="menuData.{{ $mealKey }}.image_small" @click.prevent="menuData.{{ $mealKey }}.image_small = ''" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white text-xs rounded">&times;</button>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Основная информация -->
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <label class="block font-semibold mb-2">Название</label>
            <input type="text" x-model="menuData.{{ $mealKey }}.title" class="w-full p-2 border rounded" placeholder="Название блюда">
        </div>
        <div>
            <label class="block font-semibold mb-2">Якорь (anchor)</label>
            <input type="text" x-model="menuData.{{ $mealKey }}.anchor" class="w-full p-2 border rounded" placeholder="breakfast">
        </div>
    </div>

    <!-- КБЖУ -->
    <div class="mb-6">
        <h4 class="font-semibold mb-3">КБЖУ</h4>
        <div class="grid grid-cols-4 gap-4">
            <div>
                <label class="block text-sm mb-1">Белки</label>
                <input type="text" x-model="menuData.{{ $mealKey }}.kbju.proteins" class="w-full p-2 border rounded" placeholder="0">
            </div>
            <div>
                <label class="block text-sm mb-1">Жиры</label>
                <input type="text" x-model="menuData.{{ $mealKey }}.kbju.fats" class="w-full p-2 border rounded" placeholder="0">
            </div>
            <div>
                <label class="block text-sm mb-1">Углеводы</label>
                <input type="text" x-model="menuData.{{ $mealKey }}.kbju.carbs" class="w-full p-2 border rounded" placeholder="0">
            </div>
            <div>
                <label class="block text-sm mb-1">Калории</label>
                <input type="text" x-model="menuData.{{ $mealKey }}.kbju.calories" class="w-full p-2 border rounded" placeholder="0">
            </div>
        </div>
    </div>

    <!-- Описание и рецепт -->
    <div class="mb-6">
        <label class="block font-semibold mb-2">Описание</label>
        <textarea x-model="menuData.{{ $mealKey }}.description" id="description-editor-{{ $mealKey }}" class="w-full p-2 border rounded editor" rows="4" placeholder="Описание блюда"></textarea>
    </div>

    <div class="mb-6">
        <label class="block font-semibold mb-2">Рецепт</label>
        <textarea x-model="menuData.{{ $mealKey }}.recipe" id="recipe-editor-{{ $mealKey }}" class="w-full p-2 border rounded editor" rows="4" placeholder="Рецепт приготовления"></textarea>
    </div>

    <!-- Таблица продуктов для рецепта -->
    <div class="mb-6 border rounded p-4">
        <div class="flex justify-between items-center mb-3">
            <label class="block text-sm font-semibold">Таблица продуктов</label>
            <div class="flex gap-2">
                <button type="button" x-show="!menuData.{{ $mealKey }}.recipe_table" @click="addRecipeTable('{{ $mealKey }}')" class="px-3 py-1 bg-green-500 text-white rounded text-sm">+ Добавить таблицу</button>
                <button type="button" x-show="menuData.{{ $mealKey }}.recipe_table" @click="removeRecipeTable('{{ $mealKey }}')" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Удалить таблицу</button>
            </div>
        </div>
        
        <template x-if="menuData.{{ $mealKey }}.recipe_table">
            <div class="space-y-3">
                <div>
                    <label class="block text-sm mb-1">Название таблицы</label>
                    <input type="text" x-model="menuData.{{ $mealKey }}.recipe_table.title" class="w-full p-2 border rounded" placeholder="Название таблицы">
                </div>
                <div>
                    <label class="block text-sm mb-1">Тип</label>
                    <select x-model="menuData.{{ $mealKey }}.recipe_table.type" class="w-full p-2 border rounded">
                        <option value="products">Продукты</option>
                        <option value="variants">Варианты</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Цвет подложки</label>
                    <div class="flex items-center gap-3">
                        <input type="color" x-model="menuData.{{ $mealKey }}.recipe_table.background_color" class="h-10 w-20 border rounded cursor-pointer" value="#ffffff">
                        <input type="text" x-model="menuData.{{ $mealKey }}.recipe_table.background_color" class="flex-1 p-2 border rounded" placeholder="#ffffff или прозрачно" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                        <button type="button" @click="menuData.{{ $mealKey }}.recipe_table.background_color = ''" class="px-3 py-2 bg-gray-500 text-white rounded text-sm">Очистить</button>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-xs text-gray-600">Предпросмотр:</span>
                        <div class="w-16 h-8 border rounded" :style="menuData.{{ $mealKey }}.recipe_table && menuData.{{ $mealKey }}.recipe_table.background_color ? 'background-color: ' + menuData.{{ $mealKey }}.recipe_table.background_color : 'background: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #ccc 75%), linear-gradient(-45deg, transparent 75%, #ccc 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px;'"></div>
                        <span class="text-xs text-gray-500" x-text="menuData.{{ $mealKey }}.recipe_table && menuData.{{ $mealKey }}.recipe_table.background_color ? menuData.{{ $mealKey }}.recipe_table.background_color : 'прозрачно'"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Оставьте пустым для прозрачного фона. Формат: #ffffff или #fff</p>
                </div>
                
                <div class="mb-3 flex gap-2">
                    <button type="button" @click="addRecipeTableRow('{{ $mealKey }}')" class="px-4 py-2 bg-blue-500 text-white rounded text-sm">+ Добавить строку</button>
                    <label class="px-4 py-2 bg-green-500 text-white rounded text-sm cursor-pointer hover:bg-green-600">
                        📥 Импорт из CSV
                        <input type="file" accept=".csv" class="hidden" @change="importCsvToRecipeTable($event, '{{ $mealKey }}')">
                    </label>
                </div>
                
                <div class="overflow-x-auto" x-show="menuData.{{ $mealKey }}.recipe_table && menuData.{{ $mealKey }}.recipe_table.rows && menuData.{{ $mealKey }}.recipe_table.rows.length > 0">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 text-left">Продукт</th>
                                <th class="border p-2 text-left">Вес (гр)</th>
                                <th class="border p-2 text-left">Белки</th>
                                <th class="border p-2 text-left">Жиры</th>
                                <th class="border p-2 text-left">Углеводы</th>
                                <th class="border p-2 text-left">Калории</th>
                                <th class="border p-2 text-left">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(row, rowIndex) in (menuData.{{ $mealKey }}.recipe_table && menuData.{{ $mealKey }}.recipe_table.rows ? menuData.{{ $mealKey }}.recipe_table.rows : [])" :key="rowIndex">
                            <tr>
                                <td class="border p-2">
                                    <input type="text" x-model="row.product" class="w-full p-1 border rounded text-sm" placeholder="Название продукта">
                                </td>
                                <td class="border p-2">
                                    <input type="text" x-model="row.weight" class="w-full p-1 border rounded text-sm" placeholder="0">
                                </td>
                                <td class="border p-2">
                                    <input type="text" x-model="row.proteins" class="w-full p-1 border rounded text-sm" placeholder="0">
                                </td>
                                <td class="border p-2">
                                    <input type="text" x-model="row.fats" class="w-full p-1 border rounded text-sm" placeholder="0">
                                </td>
                                <td class="border p-2">
                                    <input type="text" x-model="row.carbs" class="w-full p-1 border rounded text-sm" placeholder="0">
                                </td>
                                <td class="border p-2">
                                    <input type="text" x-model="row.calories" class="w-full p-1 border rounded text-sm" placeholder="0">
                                </td>
                                <td class="border p-2">
                                    <button type="button" @click="removeRecipeTableRow('{{ $mealKey }}', rowIndex)" class="px-2 py-1 bg-red-500 text-white rounded text-xs">Удалить</button>
                                </td>
                            </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </template>
    </div>

    <div class="mb-6">
        <label class="block font-semibold mb-2">Примечание</label>
        <textarea x-model="menuData.{{ $mealKey }}.note" class="w-full p-2 border rounded" rows="2" placeholder="Дополнительное примечание"></textarea>
    </div>

    <!-- Расширяемые блоки (Expandables) -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-semibold">Расширяемые блоки</h4>
            <button type="button" @click="addExpandable('{{ $mealKey }}')" class="px-4 py-2 bg-green-500 text-white rounded text-sm">+ Добавить</button>
        </div>
        <template x-for="(expandable, index) in (menuData.{{ $mealKey }}.expandables || [])" :key="index">
            <div class="border rounded p-4 mb-3">
                <div class="flex justify-between items-start mb-3">
                    <h5 class="font-medium">Блок <span x-text="index + 1"></span></h5>
                    <button type="button" @click="removeExpandable('{{ $mealKey }}', index)" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Удалить</button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm mb-1">Заголовок</label>
                        <input type="text" x-model="expandable.title" class="w-full p-2 border rounded" placeholder="Заголовок блока">
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Содержание</label>
                        <textarea x-model="expandable.content" class="w-full p-2 border rounded" rows="3" placeholder="Содержание блока"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Примечание</label>
                        <textarea x-model="expandable.note" class="w-full p-2 border rounded" rows="2" placeholder="Примечание"></textarea>
                    </div>
                    
                    <!-- Таблица продуктов внутри expandable -->
                    <div class="border-t pt-3 mt-3">
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-semibold">Таблица продуктов</label>
                            <div class="flex gap-2">
                                <button type="button" x-show="!expandable.table" @click="addTableToExpandable('{{ $mealKey }}', index)" class="px-3 py-1 bg-green-500 text-white rounded text-sm">+ Добавить таблицу</button>
                                <button type="button" x-show="expandable.table" @click="removeTableFromExpandable('{{ $mealKey }}', index)" class="px-3 py-1 bg-red-500 text-white rounded text-sm">Удалить таблицу</button>
                            </div>
                        </div>
                        
                        <template x-if="expandable.table">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm mb-1">Название таблицы</label>
                                    <input type="text" x-model="expandable.table.title" class="w-full p-2 border rounded" placeholder="Название таблицы">
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Тип</label>
                                    <select x-model="expandable.table.type" class="w-full p-2 border rounded">
                                        <option value="products">Продукты</option>
                                        <option value="variants">Варианты</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Цвет подложки</label>
                                    <div class="flex items-center gap-3">
                                        <input type="color" x-model="expandable.table.background_color" class="h-10 w-20 border rounded cursor-pointer" value="#ffffff">
                                        <input type="text" x-model="expandable.table.background_color" class="flex-1 p-2 border rounded" placeholder="#ffffff или прозрачно" pattern="^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$">
                                        <button type="button" @click="expandable.table.background_color = ''" class="px-3 py-2 bg-gray-500 text-white rounded text-sm">Очистить</button>
                                    </div>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="text-xs text-gray-600">Предпросмотр:</span>
                                        <div class="w-16 h-8 border rounded" :style="expandable.table && expandable.table.background_color ? 'background-color: ' + expandable.table.background_color : 'background: linear-gradient(45deg, #ccc 25%, transparent 25%), linear-gradient(-45deg, #ccc 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #ccc 75%), linear-gradient(-45deg, transparent 75%, #ccc 75%); background-size: 8px 8px; background-position: 0 0, 0 4px, 4px -4px, -4px 0px;'"></div>
                                        <span class="text-xs text-gray-500" x-text="expandable.table && expandable.table.background_color ? expandable.table.background_color : 'прозрачно'"></span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Оставьте пустым для прозрачного фона. Формат: #ffffff или #fff</p>
                                </div>
                                
                                <div class="mb-3 flex gap-2">
                                    <button type="button" @click="addTableRowToExpandable('{{ $mealKey }}', index)" class="px-4 py-2 bg-blue-500 text-white rounded text-sm">+ Добавить строку</button>
                                    <label class="px-4 py-2 bg-green-500 text-white rounded text-sm cursor-pointer hover:bg-green-600">
                                        📥 Импорт из CSV
                                        <input type="file" accept=".csv" class="hidden" @change="importCsvToExpandableTable($event, '{{ $mealKey }}', index)">
                                    </label>
                                </div>
                                
                                <div class="overflow-x-auto" x-show="expandable.table && expandable.table.rows && expandable.table.rows.length > 0">
                                    <table class="min-w-full border border-gray-300">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="border p-2 text-left">Продукт</th>
                                                <th class="border p-2 text-left">Вес (гр)</th>
                                                <th class="border p-2 text-left">Белки</th>
                                                <th class="border p-2 text-left">Жиры</th>
                                                <th class="border p-2 text-left">Углеводы</th>
                                                <th class="border p-2 text-left">Калории</th>
                                                <th class="border p-2 text-left">Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, rowIndex) in (expandable.table && expandable.table.rows ? expandable.table.rows : [])" :key="rowIndex">
                                            <tr>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.product" class="w-full p-1 border rounded text-sm" placeholder="Название продукта">
                                                </td>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.weight" class="w-full p-1 border rounded text-sm" placeholder="0">
                                                </td>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.proteins" class="w-full p-1 border rounded text-sm" placeholder="0">
                                                </td>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.fats" class="w-full p-1 border rounded text-sm" placeholder="0">
                                                </td>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.carbs" class="w-full p-1 border rounded text-sm" placeholder="0">
                                                </td>
                                                <td class="border p-2">
                                                    <input type="text" x-model="row.calories" class="w-full p-1 border rounded text-sm" placeholder="0">
                                                </td>
                                                <td class="border p-2">
                                                    <button type="button" @click="removeTableRowFromExpandable('{{ $mealKey }}', index, rowIndex)" class="px-2 py-1 bg-red-500 text-white rounded text-xs">Удалить</button>
                                                </td>
                                            </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
