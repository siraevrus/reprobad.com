@extends('admin.layouts.base')

@section('content')
    <div x-data="pageBuilder()">
        <div :class="loading ? 'opacity-50 pointer-events-none' : ''">

            <h1 class="text-xl font-bold mb-4">Конструктор страницы</h1>
            <!-- Основные поля -->
            <div class="mb-4">
                <label class="block font-semibold mb-2">Заголовок страницы</label>
                <input type="text" x-model="title" @input="generateAlias" class="w-full p-2 border rounded" placeholder="Введите заголовок страницы">
                <div class="text-red-500 text-xs mt-1" x-text="errors.title"></div>
                <div x-show="!errors.title" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Алиас</label>
                <input type="text" x-model="alias" class="w-full p-2 border rounded" placeholder="Введите алиас">
                <div class="text-red-500 text-xs mt-1" x-text="errors.alias"></div>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Описание</label>
                <textarea x-model="description" class="w-full p-2 border rounded"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.description"></div>
                <div x-show="!errors.description" class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">Ключевые слова</label>
                <textarea x-model="keywords" class="w-full p-2 border rounded"></textarea>
                <div class="text-red-500 text-xs mt-1" x-text="errors.keywords"></div>
                <div class="text-gray-400 text-xs mt-1">Максимум 250 символов</div>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Категория меню</label>
                <select x-model="category" class="w-full p-2 border rounded">
                    <option value="">Выберите категорию</option>
                    <template x-for="cat in Object.keys(categories)" :key="cat">
                        <option :value="cat" x-text="cat" :selected="cat == category"></option>
                    </template>
                </select>
                <div class="text-red-500 text-xs mt-1" x-text="errors.alias"></div>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    <input type="checkbox" x-model="active" :checked="active" class="mr-2">
                    Активна
                </label>
                <div class="text-red-500 text-xs mt-1" x-text="errors.active"></div>
            </div>

            <!-- Кнопки для добавления блоков -->
            <div class="flex flex-wrap gap-2 mb-4">
                <button x-on:click="addBlock('block1')" class="px-4 py-2 bg-gray-500 text-white rounded">Блок с фото</button>
                <button x-on:click="addBlock('block2')" class="px-4 py-2 bg-gray-500 text-white rounded">Блок шапка</button>
                <button x-on:click="addBlock('block3')" class="px-4 py-2 bg-gray-500 text-white rounded">Фото</button>
                <button x-on:click="addBlock('block4')" class="px-4 py-2 bg-gray-500 text-white rounded">Текстовый блок</button>
                <button x-on:click="addBlock('block7')" class="px-4 py-2 bg-gray-500 text-white rounded">Кроппер</button>
                <button x-on:click="addBlock('block8')" class="px-4 py-2 bg-gray-500 text-white rounded">html</button>
                <button x-on:click="addBlock('block9')" class="px-4 py-2 bg-gray-500 text-white rounded">Аккордион</button>
                <button x-on:click="addBlock('block10')" class="px-4 py-2 bg-gray-500 text-white rounded">Блок с карточками</button>
                <button x-on:click="addBlock('block11')" class="px-4 py-2 bg-gray-500 text-white rounded">Информационный блок</button>
            </div>
            <!-- Динамические блоки -->
            <div class="space-y-4">
                <template x-for="(block, index) in blocks" :key="index">
                    <div class="p-4 border rounded bg-gray-50 relative">
                        <!-- Удалить блок -->
                        <button x-on:click="removeBlock(index)" class="absolute top-2 right-2 text-red-500"><div class="material-icons">delete_forever</div></button>

                        <!-- Перемещение блоков -->
                        <div class="absolute top-2 right-10 flex gap-2">
                            <button x-on:click="moveBlock(index, 'up')" :disabled="index === 0" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_upward</div></button>
                            <button x-on:click="moveBlock(index, 'down')" :disabled="index === blocks.length - 1" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_downward</div></button>
                        </div>

                        <!-- фото с названием -->
                        <template x-if="block.type === 'block1'">
                            <div>
                                <h3 class="font-bold mb-2">Блок с фото</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                        <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите контент блока..." class="border p-2 mb-2 w-full"></textarea>
                                    </div>
                                    <div>
                                        <label
                                            x-on:dragover.prevent
                                            x-on:drop.prevent="handleDrop($event, block)"
                                            class="w-full w-lg-half max-h-[420px] border-2 relative border-dashed border-gray-300 rounded h-full flex items-center text-center justify-center mb-2 cursor-pointer"
                                        >
                                            <p x-show="!block.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                            <input type="file" x-on:change="uploadImage($event, block)" class="hidden" x-ref="fileInput">
                                            <img :src="block.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="block.data.image">
                                            <button x-show="block.data.image" x-on:click="removeImage($event, block)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- репитер -->
                        <template x-if="block.type === 'block2'">
                            <div>
                                <h3 class="font-bold mb-2">Блок шапка</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <div class="mb-2">
                                    <div>
                                        <label for="" class="mb-2 block">Подзаголовок</label>
                                        <input type="text" x-model="block.data.subtitle" class="w-full p-2 border rounded mb-2" placeholder="Введите подзаголовок">
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Заголовок</label>
                                        <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Ссылка</label>
                                        <input type="text" x-model="block.data.link" class="w-full p-2 border rounded mb-2" placeholder="Введите ссылку">
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Текст ссылки</label>
                                        <input type="text" x-model="block.data.linktext" class="w-full p-2 border rounded mb-2" placeholder="Введите текст ссылки">
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Видео</label>
                                        <input type="text" x-model="block.data.video" class="w-full p-2 border rounded mb-2" placeholder="Ссылка на видео" />
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Текст</label>
                                        <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите текст" class="border p-2 mb-2 w-full"></textarea>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="" class="font-bold">Тип блока</label>
                                    <select x-model="block.data.style" class="mt-2 w-full p-2 border rounded mb-2">
                                        <option value="triggers">Триггеры</option>
                                        <option value="cards">Карточки</option>
                                    </select>
                                </div>

                                <!-- Подблоки -->
                                <div class="p-4 border rounded bg-gray-100">
                                    <button x-on:click="addDynamicSubBlock(block)" class="px-4 py-2 bg-blue-500 text-white rounded mb-2">Добавить подблок</button>
                                    <template x-for="(subBlock, subIndex) in block.data.subBlocks" :key="subIndex">
                                        <div class="p-2 pt-10 border rounded bg-white mt-2 relative">

                                            <button x-on:click="removeSubBlock(block, subIndex)" class="absolute top-2 right-2 text-red-500"><div class="material-icons">delete_forever</div></button>

                                            <div class="absolute top-2 left-2 flex gap-2">
                                                <button x-on:click="moveSubBlock(block, subIndex, 'up')" :disabled="subIndex === 0" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_upward</div></button>
                                                <button x-on:click="moveSubBlock(block, subIndex, 'down')" :disabled="subIndex === block.data.subBlocks.length - 1" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_downward</div></button>
                                            </div>

                                            <div class="gap-4 mt-2"
                                                 :class="block.data.style == 'cards' ? 'grid grid-cols-2' : ''"
                                            >
                                                <div>
                                                    <input type="text" x-model="subBlock.data.title" class="w-full p-2 border rounded mb-2" placeholder="Подзаголовок">
                                                    <input type="text" x-model="subBlock.data.link" class="w-full p-2 border rounded mb-2" placeholder="Ссылка">
                                                    <textarea x-model="subBlock.data.text" rows="5" class="w-full p-2 border rounded mb-2"></textarea>
                                                </div>
                                                <div x-show="block.data.style == 'cards'">
                                                    <label
                                                        x-on:dragover.prevent
                                                        x-on:drop.prevent="handleDrop($event, subBlock)"
                                                        class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[200px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                                    >
                                                        <p x-show="!subBlock.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                                        <input type="file" x-on:change="uploadImage($event, subBlock)" class="hidden" x-ref="fileInput">
                                                        <img :src="subBlock.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="subBlock.data.image">
                                                        <button x-show="subBlock.data.image" x-on:click="removeImage($event, subBlock)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- фото -->
                        <template x-if="block.type === 'block3'">
                            <div>
                                <h3 class="font-bold mb-2">Фото</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <label
                                    x-on:dragover.prevent
                                    x-on:drop.prevent="handleDrop($event, block)"
                                    class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[350px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                >
                                    <p x-show="!block.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                    <input type="file" x-on:change="uploadImage($event, block)" class="hidden" x-ref="fileInput">
                                    <img :src="block.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="block.data.image">
                                    <button x-show="block.data.image" x-on:click="removeImage($event, block)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                </label>
                            </div>
                        </template>

                        <!-- текстовый блок -->
                        <template x-if="block.type === 'block4'">
                            <div>
                                <h3 class="font-bold mb-2">Текстовый блок</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <div>
                                    <label for="" class="mb-2 block">Текст над заголовком</label>
                                    <input type="text" x-model="block.data.suptitle" class="w-full p-2 border rounded mb-2" placeholder="Введите текст над заголовком">
                                </div>
                                <div>
                                    <label for="" class="mb-2 block">Заголовок</label>
                                    <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                </div>
                                <div>
                                    <label for="" class="mb-2 block">Ссылка</label>
                                    <input type="text" x-model="block.data.link" class="w-full p-2 border rounded mb-2" placeholder="Введите ссылку">
                                </div>
                                <div>
                                    <label for="" class="mb-2 block">Текст ссылки</label>
                                    <input type="text" x-model="block.data.linktext" class="w-full p-2 border rounded mb-2" placeholder="Введите текст ссылки">
                                </div>
                                <div>
                                    <label for="" class="mb-2 block">Текст</label>
                                    <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите текст" class="border p-2 mb-2 w-full"></textarea>
                                </div>
                            </div>
                        </template>

                        <!-- цитата -->
                        <template x-if="block.type === 'block5'">
                            <div>
                                <h3 class="font-bold mb-2">Цитата</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите текст" class="border p-2 w-full"></textarea>
                                <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mt-4" placeholder="Введите подпись">
                            </div>
                        </template>

                        <!-- селект -->
                        <template x-if="block.type === 'block6'">
                            <div>
                                <h3 class="font-bold mb-2">Выберите раздел</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <select x-model="block.data.type" class="w-full p-2 border rounded">
                                    <option value="Отзывы">Отзывы</option>
                                    <option value="Команда">Команда</option>
                                </select>
                            </div>
                        </template>

                        <!-- кроппер -->
                        <template x-if="block.type === 'block7'">
                            <div>
                                <h3 class="font-bold mb-2">Обрезка изображения</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <input type="file" x-on:change="prepareCrop($event, block)" class="w-full mb-2">
                                <div x-show="block.data.image" class="relative">
                                    <img :src="block.data.image" alt="" class="max-w-full m-auto block mt-4 h-[350px]" x-ref="cropperImage">
                                    <button x-on:click="cropImage(block)" class="px-4 py-2 bg-blue-500 text-white rounded mt-2">Обрезать</button>
                                </div>
                            </div>
                        </template>

                        <!-- код -->
                        <template x-if="block.type === 'block8'">
                            <div>
                                <h3 class="font-bold mb-2">HTML код</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>
                                <textarea x-model="block.data.text" rows="10" class="border p-2 mb-2 w-full"></textarea>
                                <div class="text-gray-400 text-xs mt-1">Кроме js</div>
                            </div>
                        </template>

                        <!-- репитер -->
                        <template x-if="block.type === 'block9'">
                            <div>
                                <h3 class="font-bold mb-2">Аккордион</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>

                                <div class="mb4">
                                    <div>
                                        <label for="" class="mb-2 block">Текст над заголовком</label>
                                        <input type="text" x-model="block.data.suptitle" class="w-full p-2 border rounded mb-2" placeholder="Введите текст над заголовком">
                                    </div>
                                    <div>
                                        <label for="" class="mb-2 block">Заголовок</label>
                                        <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                    </div>
                                </div>

                                <!-- Подблоки -->
                                <div class="p-4 border rounded bg-gray-100">
                                    <button x-on:click="addDynamicSubBlock(block)" class="px-4 py-2 bg-blue-500 text-white rounded mb-2">Добавить блок</button>
                                    <template x-for="(subBlock, subIndex) in block.data.subBlocks" :key="subIndex">
                                        <div class="p-2 pt-10 border rounded bg-white mt-2 relative">

                                            <button x-on:click="removeSubBlock(block, subIndex)" class="absolute top-2 right-2 text-red-500"><div class="material-icons">delete_forever</div></button>

                                            <div class="absolute top-2 left-2 flex gap-2">
                                                <button x-on:click="moveSubBlock(block, subIndex, 'up')" :disabled="subIndex === 0" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_upward</div></button>
                                                <button x-on:click="moveSubBlock(block, subIndex, 'down')" :disabled="subIndex === block.data.subBlocks.length - 1" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_downward</div></button>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-2">
                                                <div>
                                                    <label class="block font-semibold mb-2">
                                                        <input type="checkbox" x-model="subBlock.data.isExpanded" :checked="subBlock.data.isExpanded" class="mr-2">
                                                        Показывать сразу
                                                    </label>
                                                    <input type="text" x-model="subBlock.data.subtitle" class="w-full p-2 border rounded mb-2" placeholder="Подзаголовок">
                                                    <input type="text" x-model="subBlock.data.title" class="w-full p-2 border rounded mb-2" placeholder="Заголовок">
                                                    <input type="text" x-model="subBlock.data.link" class="w-full p-2 border rounded mb-2" placeholder="Ссылка">
                                                    <div>
                                                        <label for="">Цвет фона</label>
                                                        <input type="color" x-model="subBlock.data.className" class="w-full rounded mb-2" placeholder="Цвет фона">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label
                                                        x-on:dragover.prevent
                                                        x-on:drop.prevent="handleDrop($event, subBlock)"
                                                        class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[200px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                                    >
                                                        <p x-show="!subBlock.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                                        <input type="file" x-on:change="uploadImage($event, subBlock)" class="hidden" x-ref="fileInput">
                                                        <img :src="subBlock.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="subBlock.data.image">
                                                        <button x-show="subBlock.data.image" x-on:click="removeImage($event, subBlock)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="block.type === 'block10'">
                            <div>
                                <h3 class="font-bold mb-2">Блок с карточками</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>

                                <div class="mb4">
                                    <div>
                                        <label for="" class="mb-2 block">Заголовок</label>
                                        <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                        <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите текст" class="border p-2 w-full"></textarea>
                                    </div>
                                </div>

                                <!-- Подблоки -->
                                <div class="p-4 border rounded bg-gray-100">
                                    <button x-on:click="addDynamicSubBlock(block)" class="px-4 py-2 bg-blue-500 text-white rounded mb-2">Добавить блок</button>
                                    <template x-for="(subBlock, subIndex) in block.data.subBlocks" :key="subIndex">
                                        <div class="p-2 pt-10 border rounded bg-white mt-2 relative">

                                            <button x-on:click="removeSubBlock(block, subIndex)" class="absolute top-2 right-2 text-red-500"><div class="material-icons">delete_forever</div></button>

                                            <div class="absolute top-2 left-2 flex gap-2">
                                                <button x-on:click="moveSubBlock(block, subIndex, 'up')" :disabled="subIndex === 0" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_upward</div></button>
                                                <button x-on:click="moveSubBlock(block, subIndex, 'down')" :disabled="subIndex === block.data.subBlocks.length - 1" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_downward</div></button>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-2">
                                                <div>
                                                    <input type="text" x-model="subBlock.data.title" class="w-full p-2 border rounded mb-2" placeholder="Заголовок">
                                                    <input type="text" x-model="subBlock.data.text" class="w-full p-2 border rounded mb-2" placeholder="Текст">
                                                </div>
                                                <div>
                                                    <label
                                                        x-on:dragover.prevent
                                                        x-on:drop.prevent="handleDrop($event, subBlock)"
                                                        class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[200px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                                    >
                                                        <p x-show="!subBlock.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                                        <input type="file" x-on:change="uploadImage($event, subBlock)" class="hidden" x-ref="fileInput">
                                                        <img :src="subBlock.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="subBlock.data.image">
                                                        <button x-show="subBlock.data.image" x-on:click="removeImage($event, subBlock)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="block.type === 'block11'">
                            <div>
                                <h3 class="font-bold mb-2">Информационный блок</h3>
                                <div class="mb-4">
                                    <label class="block font-semibold mb-2">
                                        <input type="checkbox" x-model="block.hide" :checked="block.hide" class="mr-2">
                                        Скрыть
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <div class="mb-4">
                                        <label for="" class="mb-2 block">Заголовок</label>
                                        <input type="text" x-model="block.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                        <textarea :id="'editor-' + index" x-ref="editor" x-model="block.data.text" placeholder="Введите текст" class="border p-2 w-full"></textarea>
                                        <input type="text" x-model="block.data.link" class="w-full p-2 border rounded mb-2 mt-2" placeholder="Введите ссылку">
                                        <input type="text" x-model="block.data.linktext" class="w-full p-2 border rounded mb-2" placeholder="Введите текст ссылки">
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                        <template x-for="(subBlock, subIndex) in block.data.triggers" :key="subIndex">
                                            <div>
                                                <label
                                                    x-on:dragover.prevent
                                                    x-on:drop.prevent="handleDrop($event, subBlock)"
                                                    class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[100px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                                >
                                                    <p x-show="!subBlock.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                                    <input type="file" x-on:change="uploadImage($event, subBlock)" class="hidden" x-ref="fileInput">
                                                    <img :src="subBlock.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="subBlock.data.image">
                                                    <button x-show="subBlock.data.image" x-on:click="removeImage($event, subBlock)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                                </label>
                                                <input type="text" x-model="subBlock.data.title" class="w-full p-2 border rounded mb-2" placeholder="Введите заголовок">
                                                <textarea x-model="subBlock.data.text" class="w-full p-2 border rounded mb-2" rows="3" placeholder="Введите текст"></textarea>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Подблоки -->
                                <div class="p-4 border rounded bg-gray-100">
                                    <button x-on:click="addDynamicSubBlock(block)" class="px-4 py-2 bg-blue-500 text-white rounded mb-2">Добавить блок</button>
                                    <template x-for="(subBlock, subIndex) in block.data.subBlocks" :key="subIndex">
                                        <div class="p-2 pt-10 border rounded bg-white mt-2 relative">

                                            <button x-on:click="removeSubBlock(block, subIndex)" class="absolute top-2 right-2 text-red-500"><div class="material-icons">delete_forever</div></button>

                                            <div class="absolute top-2 left-2 flex gap-2">
                                                <button x-on:click="moveSubBlock(block, subIndex, 'up')" :disabled="subIndex === 0" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_upward</div></button>
                                                <button x-on:click="moveSubBlock(block, subIndex, 'down')" :disabled="subIndex === block.data.subBlocks.length - 1" class="text-black-500 disabled:opacity-50"><div class="material-icons">arrow_downward</div></button>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4 mt-2">
                                                <div>
                                                    <input type="text" x-model="subBlock.data.title" class="w-full p-2 border rounded mb-2" placeholder="Заголовок">
                                                    <textarea x-model="subBlock.data.text" rows="4" class="w-full p-2 border rounded mb-2" placeholder="Текст"></textarea>
                                                </div>
                                                <div>
                                                    <label
                                                        x-on:dragover.prevent
                                                        x-on:drop.prevent="handleDrop($event, subBlock)"
                                                        class="w-full w-lg-half border-2 relative border-dashed border-gray-300 rounded h-[150px] flex items-center text-center justify-center mb-2 cursor-pointer"
                                                    >
                                                        <p x-show="!subBlock.data.image">Перетащите изображение сюда <br>или нажмите для загрузки</p>
                                                        <input type="file" x-on:change="uploadImage($event, subBlock)" class="hidden" x-ref="fileInput">
                                                        <img :src="subBlock.data.image" alt="Загруженное изображение" class="max-w-full max-h-full" x-show="subBlock.data.image">
                                                        <button x-show="subBlock.data.image" x-on:click="removeImage($event, subBlock)" class="absolute top-0 right-0 py-1 px-2 bg-red-500 text-white">&times;</button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                    </div>
                </template>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        function pageBuilder() {
            return {
                alert: {
                    show: false,
                    message: '',
                    type: ''
                },
                categories: [],
                timeoutId: 0,
                loading: false,
                animate: false,
                token: '',
                errors: {},
                title: '',
                alias: '',
                category: '',
                keywords: '',
                description: '',
                active: false,
                blocks: [],
                blocksJson: '',
                async init() {

                    if(location.pathname.split('/')[3] !== undefined && location.pathname.split('/')[3] != 'create') {
                        await this.get();
                    }

                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    this.userIsNotActive();
                    this.initializeAll();
                },
                async userIsNotActive() {
                    let idleTime = 0;
                    const idleLimit = 10; // Время бездействия в секундах

                    document.addEventListener('mousemove', resetIdleTimer);
                    document.addEventListener('keydown', resetIdleTimer);
                    document.addEventListener('mousedown', resetIdleTimer);
                    document.addEventListener('scroll', resetIdleTimer);

                    function resetIdleTimer() {
                        idleTime = 0;
                    }

                    setInterval(async () => {
                        idleTime++;
                        if (idleTime >= idleLimit) {
                            console.log('Пользователь неактивен');

                            await this.save(true);
                        }
                    }, 20000);
                },
                initializeAll() {
                    tinymce.remove();
                    this.$nextTick(() => {
                        this.initializeEditor();
                    });
                },
                initializeEditor() {
                    this.$nextTick(() => {
                        tinymce.remove();

                        this.blocks.forEach((block, index) => {
                            tinymce.init({
                                selector: `#editor-${index}`,
                                height: 300,
                                menubar: false,
                                language: 'ru',
                                language_url: '/js/ru.min.js',
                                plugins: 'advlist autolink lists link image charmap preview anchor code',
                                toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                                setup: (editor) => {
                                    editor.on('change', () => {
                                        block.data.text = editor.getContent();
                                    });
                                }
                            });
                        });
                    });
                },
                addBlock(type) {
                    const block = { type, hide: false, data: {} };

                    switch(type) {
                        case 'block1':
                            block.data.title = '';
                            block.data.image = '';
                            break;
                        case 'block2':
                            block.data.title = '';
                            block.data.subBlocks = [];
                            break;
                        case 'block3':
                            block.data.image = '';
                            break;
                        case 'block4':
                            block.data.title = '';
                            block.data.subtitle = '';
                            block.data.text = '';
                            block.data.video = '';
                            break;
                        case 'block5':
                            block.data.quote = '';
                            break;
                        case 'block6':
                            block.data.options = ['Option 1', 'Option 2'];
                            break;
                        case 'block7':
                            block.data.image = '';
                            block.data.croppedImage = '';
                            break;
                        case 'block8':
                            block.data.text = '';
                            break;
                        case 'block9':
                            block.data.subBlocks = [];
                            break;
                        case 'block10':
                            block.data.title = '';
                            block.data.text = '';
                            block.data.subBlocks = [];
                            break;
                        case 'block11':
                            block.data.title = '';
                            block.data.text = '';
                            block.data.triggers = [
                                {
                                    data: {
                                        title: '',
                                        text: '',
                                        image: ''
                                    }
                                },
                                {
                                    data: {
                                        title: '',
                                        text: '',
                                        image: ''
                                    }
                                },
                                {
                                    data: {
                                        title: '',
                                        text: '',
                                        image: ''
                                    }
                                }
                            ];
                            block.data.subBlocks = [];
                            break;
                    }

                    this.blocks.push(block);
                    this.initializeAll();
                    this.showAlert('success', 'Блок добавлен');
                },
                removeBlock(index) {
                    this.blocks.splice(index, 1);
                    this.initializeAll();
                },
                moveBlock(index, direction) {
                    if (direction === 'up' && index > 0) {
                        this.blocks.splice(index - 1, 0, this.blocks.splice(index, 1)[0]);
                    } else if (direction === 'down' && index < this.blocks.length - 1) {
                        this.blocks.splice(index + 1, 0, this.blocks.splice(index, 1)[0]);
                    }
                    this.initializeAll();
                },
                addDynamicSubBlock(block) {
                    block.data.subBlocks.push({ data : {title: '', text: '', image: '', isExpanded: false} });
                    this.initializeAll();
                },
                removeSubBlock(block, subIndex) {
                    block.data.subBlocks.splice(subIndex, 1);
                    this.initializeAll();
                },
                moveSubBlock(block, subIndex, direction) {
                    if (direction === 'up' && subIndex > 0) {
                        block.data.subBlocks.splice(subIndex - 1, 0, block.data.subBlocks.splice(subIndex, 1)[0]);
                    } else if (direction === 'down' && subIndex < block.data.subBlocks.length - 1) {
                        block.data.subBlocks.splice(subIndex + 1, 0, block.data.subBlocks.splice(subIndex, 1)[0]);
                    }
                    this.initializeAll();
                },
                uploadImage(event, block) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        block.data.image = reader.result;
                    };
                    reader.readAsDataURL(event.target.files[0]);
                    event.target.value = '';
                },
                handleDrop(event, block) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        block.data.image = reader.result;
                    };
                    reader.readAsDataURL(event.dataTransfer.files[0]);

                    event.target.value = '';
                },
                prepareCrop(event, block) {
                    const file = event.target.files[0];
                    block.data.image = '';
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = () => {
                        block.data.image = reader.result;
                        this.$nextTick(() => {
                            const imageElement = this.$refs.cropperImage;
                            block.data.cropper = new Cropper(imageElement, {
                                viewMode: 1,
                                autoCropArea: 0.8,
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },
                cropImage(block) {
                    if (block.data.cropper) {
                        const canvas = block.data.cropper.getCroppedCanvas();
                        //block.data.croppedImage = canvas.toDataURL('image/png');
                        block.data.image = canvas.toDataURL('image/png')
                        block.data.cropper.destroy();
                        block.data.cropper = null;
                    }
                },
                removeImage(event, block) {
                    block.data.image = null
                },
                generateAlias() {
                    const cyrillicToLatinMap = {
                        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo',
                        'ж': 'zh', 'з': 'z', 'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm',
                        'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
                        'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ъ': '',
                        'ы': 'y', 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya', ' ': '-', '_': '-',
                        'А': 'A', 'Б': 'B', 'В': 'V', 'Г': 'G', 'Д': 'D', 'Е': 'E', 'Ё': 'Yo',
                        'Ж': 'Zh', 'З': 'Z', 'И': 'I', 'Й': 'Y', 'К': 'K', 'Л': 'L', 'М': 'M',
                        'Н': 'N', 'О': 'O', 'П': 'P', 'Р': 'R', 'С': 'S', 'Т': 'T', 'У': 'U',
                        'Ф': 'F', 'Х': 'H', 'Ц': 'Ts', 'Ч': 'Ch', 'Ш': 'Sh', 'Щ': 'Sch', 'Ъ': '',
                        'Ы': 'Y', 'Ь': '', 'Э': 'E', 'Ю': 'Yu', 'Я': 'Ya'
                    };

                    // Транслитерация строки
                    this.alias = this.title
                        .split('')
                        .map(char => cyrillicToLatinMap[char] || char) // Заменяем буквы по карте
                        .join('')
                        .toLowerCase()
                        .replace(/[^a-z0-9-]/g, '') // Удаляем лишние символы
                        .replace(/--+/g, '-')      // Удаляем повторяющиеся дефисы
                        .replace(/^-+|-+$/g, '');  // Удаляем дефисы в начале и конце
                },
                showAlert(type, message) {
                    if (this.timeoutId) clearTimeout(this.timeoutId);

                    this.alert = {show: true, message: message, type: type}

                    this.timeoutId = setTimeout(() => {
                        this.alert = {show: false, message: '', type: ''}
                    }, 1000);
                },
                async getCategories() {
                    const response = await fetch('/admin/pages/categories', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.token
                        }
                    });

                    const result = await response.json();
                    this.categories = result;
                },
                async get() {
                    try {
                        this.loading = true;
                        const id = location.pathname.split('/')[3];

                        const response = await fetch('/admin/pages/' + id + '/show', {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.token
                            }
                        });

                        const result = await response.json();

                        this.title = result.title;
                        this.alias = result.alias;
                        this.keywords = result.keywords;
                        this.description = result.description;
                        this.blocks = result.blocks;
                        this.active = result.active;
                        this.category = result.category;

                    } catch(e) {
                        console.log(e);
                    } finally {
                        this.loading = false;
                    }
                },
                async save(noRedirect = false) {
                    try {
                        this.loading = true;
                        this.animate = false;
                        this.errors = {};

                        const data = {
                            title: this.title,
                            alias: this.alias,
                            description: this.description,
                            keywords: this.keywords,
                            active: this.active,
                            category: this.category,
                            blocks: this.blocks
                        }

                        let edit = '';
                        if(location.pathname.split('/')[3] !== undefined && location.pathname.split('/')[3] != 'create') {
                            edit = '/' + location.pathname.split('/')[3]
                        }

                        const response = await fetch(`/admin/pages` + edit, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.token
                            },
                            body: JSON.stringify(data)
                        });

                        let result = await response.json();
                        if(!result.success) {
                            this.errors = result.errors;
                            this.animate = true;
                            this.showAlert('error', 'Исправьте ошибки');
                            return false;
                        }

                        this.showAlert('success', 'Успешно сохранено');

                        if(!noRedirect) location.href = '/admin/pages';
                    } catch(e) {
                        console.log(e);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
@endsection
