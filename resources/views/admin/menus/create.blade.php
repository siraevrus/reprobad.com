@extends('admin.layouts.base')

@section('content')
    <div x-data="menuApp()" x-init="init()">
        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} меню</h2>
        
        <form action="#" method="POST" @submit.prevent="saveMenu">
            @csrf

            <!-- Основные поля -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-4">Основная информация</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>@include('admin.components.text-input', ['title' => 'День (1-7)', 'field' => 'day'])</div>
                    <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>
                    <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>
                    <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => ['1' => 'Да', '0' => 'Нет']])</div>
                </div>
                <div class="mt-4">
                    @include('admin.components.textarea-input', ['title' => 'Описание', 'field' => 'description', 'no_editor' => true])
                </div>
                <div class="mt-4 border-t pt-4">
                    <h4 class="text-md font-semibold mb-3">SEO настройки</h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                SEO Title <span class="text-gray-500">(до 60 символов)</span>
                            </label>
                            <input type="text" x-model="form.seo_title" maxlength="60" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <div class="mt-1 text-sm text-gray-500">
                                <span x-text="(form.seo_title || '').length"></span>/60 символов
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                SEO Description <span class="text-gray-500">(до 160 символов)</span>
                            </label>
                            <textarea x-model="form.seo_description" rows="3" maxlength="160"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <div class="mt-1 text-sm text-gray-500">
                                <span x-text="(form.seo_description || '').length"></span>/160 символов
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Табы для приемов пищи -->
            <div class="bg-white rounded-lg shadow">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px overflow-x-auto">
                        <button type="button" @click="activeTab = 'breakfast'" 
                                :class="activeTab === 'breakfast' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Завтрак
                        </button>
                        <button type="button" @click="activeTab = 'snack'"
                                :class="activeTab === 'snack' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Перекус
                        </button>
                        <button type="button" @click="activeTab = 'dinner'"
                                :class="activeTab === 'dinner' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Обед
                        </button>
                        <button type="button" @click="activeTab = 'lunch'"
                                :class="activeTab === 'lunch' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Ужин
                        </button>
                        <button type="button" @click="activeTab = 'daily'"
                                :class="activeTab === 'daily' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Дневное КБЖУ
                        </button>
                        <button type="button" @click="activeTab = 'recommendations'"
                                :class="activeTab === 'recommendations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 px-6 text-sm font-medium border-b-2 whitespace-nowrap">
                            Рекомендации
                        </button>
                    </nav>
                </div>

                <!-- Контент табов -->
                <div class="p-6">
                    <!-- Завтрак -->
                    <div x-show="activeTab === 'breakfast'" x-transition>
                        @include('admin.menus.partials.meal-form', ['mealKey' => 'breakfast', 'mealName' => 'Завтрак'])
                    </div>

                    <!-- Перекус -->
                    <div x-show="activeTab === 'snack'" x-transition>
                        @include('admin.menus.partials.meal-form', ['mealKey' => 'snack', 'mealName' => 'Перекус'])
                    </div>

                    <!-- Обед -->
                    <div x-show="activeTab === 'dinner'" x-transition>
                        @include('admin.menus.partials.meal-form', ['mealKey' => 'dinner', 'mealName' => 'Обед'])
                    </div>

                    <!-- Ужин -->
                    <div x-show="activeTab === 'lunch'" x-transition>
                        @include('admin.menus.partials.meal-form', ['mealKey' => 'lunch', 'mealName' => 'Ужин'])
                    </div>

                    <!-- Дневное КБЖУ -->
                    <div x-show="activeTab === 'daily'" x-transition>
                        @include('admin.menus.partials.daily-kbju-form')
                    </div>

                    <!-- Рекомендации -->
                    <div x-show="activeTab === 'recommendations'" x-transition>
                        @include('admin.menus.partials.recommendations-form')
                    </div>
                </div>
            </div>

            @include('admin.components.buttons')
        </form>

        <!-- Модальное окно для обрезки изображений -->
        <div x-show="cropperModal.show" 
             x-cloak
             x-transition
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
             @click.self="closeImageCropper()">
            <div class="bg-white rounded-lg p-6 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Обрезка изображения (<span x-text="cropperModal.targetWidth"></span>×<span x-text="cropperModal.targetHeight"></span>px)</h3>
                    <button @click="closeImageCropper()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>
                
                <div class="mb-4" style="max-height: 60vh; overflow: auto; min-height: 300px;">
                    <div x-show="!cropperModal.imageUrl" class="flex items-center justify-center h-[300px] text-gray-400">
                        Загрузка изображения...
                    </div>
                    <img id="cropper-image-menu" 
                         :src="cropperModal.imageUrl" 
                         style="max-width: 100%; display: block;" 
                         x-show="cropperModal.imageUrl"
                         alt="Изображение для обрезки">
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button @click="closeImageCropper()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Отмена
                    </button>
                    <button @click="saveCroppedImage()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
// Проверяем загрузку Cropper.js
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Cropper === 'undefined') {
        console.error('Cropper.js не загружен! Проверьте подключение библиотеки.');
    } else {
        console.log('Cropper.js загружен успешно');
    }
});

function menuApp() {
    return {
        ...userIsNotActive,
        ...variables,
        ...showAlert,
        ...imageUpload,
        activeTab: 'breakfast',
        cropperModal: {
            show: false,
            imageUrl: '',
            mealKey: '',
            field: '',
            imgIndex: undefined,
            cropper: null,
            targetWidth: 600,
            targetHeight: 400
        },
        menuData: {
            breakfast: { 
                image: '', image_big: '', image_small: '', images: [],
                title: '', name: 'Завтрак', anchor: 'breakfast',
                kbju: { calories: '', proteins: '', fats: '', carbs: '' },
                description: '', recipe: '', note: '',
                recipe_tables: [],
                expandables: []
            },
            snack: { 
                image: '', image_big: '', image_small: '', images: [],
                title: '', name: 'Перекус', anchor: 'snack',
                kbju: { calories: '', proteins: '', fats: '', carbs: '' },
                description: '', recipe: '', note: '',
                recipe_tables: [],
                expandables: []
            },
            dinner: { 
                image: '', image_big: '', image_small: '', images: [],
                title: '', name: 'Обед', anchor: 'dinner',
                kbju: { calories: '', proteins: '', fats: '', carbs: '' },
                description: '', recipe: '', note: '',
                recipe_tables: [],
                expandables: []
            },
            lunch: { 
                image: '', image_big: '', image_small: '', images: [],
                title: '', name: 'Ужин', anchor: 'lunch',
                kbju: { calories: '', proteins: '', fats: '', carbs: '' },
                description: '', recipe: '', note: '',
                recipe_tables: [],
                expandables: []
            },
            daily_kbju: { 
                with_snack: { calories: '', proteins: '', fats: '', carbs: '' },
                without_snack: { calories: '', proteins: '', fats: '', carbs: '' }
            },
            recommendations: { 
                title: '', 
                content: [], 
                next_day_preview: [] 
            }
        },
        form: {
            day: '',
            title: '',
            alias: '',
            description: '',
            seo_title: '',
            seo_description: '',
            active: 1,
        },
        async init() {
            this.initVariables();
            if (this.action !== 'create') {
                await this.get();
            }
            // Инициализируем редакторы после загрузки данных
            this.$nextTick(() => {
                setTimeout(() => {
                    this.initializeRecipeEditors();
                    this.initializeDescriptionEditors();
                    this.initializeExpandableContentEditors();
                }, 500);
            });
            
            // Следим за переключением табов и инициализируем редакторы
            this.$watch('activeTab', () => {
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.initializeRecipeEditors();
                    this.initializeDescriptionEditors();
                    this.initializeExpandableContentEditors();
                    }, 300);
                });
            });
            
            // Следим за изменениями КБЖУ и автоматически пересчитываем дневное КБЖУ
            const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
            const kbjuFields = ['proteins', 'fats', 'carbs', 'calories'];
            
            mealKeys.forEach(mealKey => {
                kbjuFields.forEach(field => {
                    this.$watch(`menuData.${mealKey}.kbju.${field}`, () => {
                        this.calculateDailyKbju();
                    });
                });
            });
            
            // Первоначальный расчет при загрузке
            this.$nextTick(() => {
                this.calculateDailyKbju();
            });
        },
        initializeRecipeEditors() {
            if (typeof tinymce === 'undefined') {
                return;
            }
            
            // Инициализируем редакторы для всех полей рецепта
            const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
            mealKeys.forEach(mealKey => {
                const editorId = `recipe-editor-${mealKey}`;
                const textarea = document.getElementById(editorId);
                
                if (!textarea) {
                    return;
                }
                
                // Проверяем, не инициализирован ли уже редактор
                const existingEditor = tinymce.get(editorId);
                if (existingEditor) {
                    return; // Редактор уже инициализирован
                }
                
                // Инициализируем редактор только если элемент видим или будет видим
                tinymce.init({
                    selector: `#${editorId}`,
                    license_key: 'gpl',
                    height: 300,
                    menubar: false,
                    language: 'ru',
                    language_url: '/js/ru.min.js',
                    plugins: 'advlist autolink lists link image charmap preview anchor code',
                    toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                    setup: (editor) => {
                        editor.on('change', () => {
                            this.menuData[mealKey].recipe = editor.getContent();
                        });
                        // Синхронизация при загрузке содержимого
                        editor.on('init', () => {
                            if (this.menuData[mealKey] && this.menuData[mealKey].recipe) {
                                editor.setContent(this.menuData[mealKey].recipe);
                            }
                        });
                    }
                });
            });
        },
        initializeDescriptionEditors() {
            if (typeof tinymce === 'undefined') {
                return;
            }
            
            // Инициализируем редакторы для всех полей описания
            const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
            mealKeys.forEach(mealKey => {
                const editorId = `description-editor-${mealKey}`;
                const textarea = document.getElementById(editorId);
                
                if (!textarea) {
                    return;
                }
                
                // Проверяем, не инициализирован ли уже редактор
                const existingEditor = tinymce.get(editorId);
                if (existingEditor) {
                    return; // Редактор уже инициализирован
                }
                
                // Инициализируем редактор только если элемент видим или будет видим
                tinymce.init({
                    selector: `#${editorId}`,
                    license_key: 'gpl',
                    height: 300,
                    menubar: false,
                    language: 'ru',
                    language_url: '/js/ru.min.js',
                    plugins: 'advlist autolink lists link image charmap preview anchor code',
                    toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                    setup: (editor) => {
                        editor.on('change', () => {
                            this.menuData[mealKey].description = editor.getContent();
                        });
                        // Синхронизация при загрузке содержимого
                        editor.on('init', () => {
                            if (this.menuData[mealKey] && this.menuData[mealKey].description) {
                                editor.setContent(this.menuData[mealKey].description);
                            }
                        });
                    }
                });
            });
        },
        initializeExpandableContentEditors() {
            if (typeof tinymce === 'undefined') {
                return;
            }
            
            // Инициализируем редакторы для всех полей содержания в expandable блоках
            const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
            mealKeys.forEach(mealKey => {
                const expandables = this.menuData[mealKey]?.expandables || [];
                expandables.forEach((expandable, index) => {
                    const editorId = `expandable-content-${mealKey}-${index}`;
                    const textarea = document.getElementById(editorId);
                    
                    if (!textarea) {
                        return;
                    }
                    
                    // Проверяем, не инициализирован ли уже редактор
                    const existingEditor = tinymce.get(editorId);
                    if (existingEditor) {
                        return; // Редактор уже инициализирован
                    }
                    
                    // Инициализируем редактор
                    tinymce.init({
                        selector: `#${editorId}`,
                        license_key: 'gpl',
                        height: 300,
                        menubar: false,
                        language: 'ru',
                        language_url: '/js/ru.min.js',
                        plugins: 'advlist autolink lists link image charmap preview anchor code',
                        toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                        setup: (editor) => {
                            editor.on('change', () => {
                                if (this.menuData[mealKey] && this.menuData[mealKey].expandables && this.menuData[mealKey].expandables[index]) {
                                    this.menuData[mealKey].expandables[index].content = editor.getContent();
                                }
                            });
                            // Синхронизация при загрузке содержимого
                            editor.on('init', () => {
                                if (expandable && expandable.content) {
                                    editor.setContent(expandable.content);
                                }
                            });
                        }
                    });
                });
            });
        },
        async get() {
            this.loading = true;
            try {
                const response = await fetch('/admin/' + this.route + '/' + this.action);
                const data = await response.json();
                
                this.form = {
                    day: data.day || '',
                    title: data.title || '',
                    alias: data.alias || '',
                    description: data.description || '',
                    seo_title: data.seo_title || '',
                    seo_description: data.seo_description || '',
                    active: data.active ?? 1,
                };
                
                if (data.menu_data) {
                    let parsedData;
                    if (typeof data.menu_data === 'object') {
                        parsedData = data.menu_data;
                    } else if (typeof data.menu_data === 'string' && data.menu_data) {
                        try {
                            parsedData = JSON.parse(data.menu_data);
                        } catch (e) {
                            console.error('Ошибка парсинга JSON:', e);
                            parsedData = null;
                        }
                    }
                    
                    if (parsedData) {
                        // Миграция существующих таблиц в expandables (старый формат tables на уровне meal)
                        const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
                        mealKeys.forEach(mealKey => {
                            if (parsedData[mealKey] && parsedData[mealKey].tables && Array.isArray(parsedData[mealKey].tables)) {
                                if (!parsedData[mealKey].expandables) {
                                    parsedData[mealKey].expandables = [];
                                }
                                parsedData[mealKey].tables.forEach(table => {
                                    parsedData[mealKey].expandables.push({
                                        title: table.title || '',
                                        content: '',
                                        note: '',
                                        tables: [{
                                            title: table.title || '',
                                            type: table.type || 'products',
                                            background_color: table.background_color || '',
                                            rows: table.rows || []
                                        }]
                                    });
                                });
                                delete parsedData[mealKey].tables;
                            }
                            // Миграция recipe_table -> recipe_tables (одна таблица -> массив)
                            if (parsedData[mealKey] && parsedData[mealKey].recipe_table != null && typeof parsedData[mealKey].recipe_table === 'object' && !Array.isArray(parsedData[mealKey].recipe_tables)) {
                                parsedData[mealKey].recipe_tables = [parsedData[mealKey].recipe_table];
                                delete parsedData[mealKey].recipe_table;
                            }
                            // Миграция expandable.table -> expandable.tables
                            if (parsedData[mealKey] && Array.isArray(parsedData[mealKey].expandables)) {
                                parsedData[mealKey].expandables.forEach(expandable => {
                                    if (expandable.table != null && typeof expandable.table === 'object' && !Array.isArray(expandable.tables)) {
                                        expandable.tables = [expandable.table];
                                        delete expandable.table;
                                    }
                                });
                            }
                        });

                        this.menuData = this.mergeMenuData(this.menuData, parsedData);
                    }
                }
                
                this.loading = false;
                // Инициализируем редакторы после загрузки данных
                this.$nextTick(() => {
                    setTimeout(() => {
                        this.initializeRecipeEditors();
                        this.initializeDescriptionEditors();
                        this.initializeExpandableContentEditors();
                        // Пересчитываем дневное КБЖУ после загрузки данных
                        this.calculateDailyKbju();
                    }, 500);
                });
            } catch (e) {
                console.log(e);
                this.loading = false;
            }
        },
        mergeMenuData(defaultData, savedData) {
            const merged = JSON.parse(JSON.stringify(defaultData));
            for (let key in savedData) {
                if (merged[key] && typeof merged[key] === 'object' && !Array.isArray(merged[key])) {
                    // Для meal объектов (breakfast, snack, dinner, lunch) делаем глубокое слияние
                    if (['breakfast', 'snack', 'dinner', 'lunch'].includes(key)) {
                        merged[key] = { ...merged[key], ...savedData[key] };
                        if (merged[key].tables) {
                            delete merged[key].tables;
                        }
                        if (!merged[key].expandables) {
                            merged[key].expandables = [];
                        }
                        // Инициализируем массив images, если его нет
                        if (!Array.isArray(merged[key].images)) {
                            merged[key].images = [];
                        }
                        // Нормализуем формат images: если есть строки, преобразуем в объекты с url
                        if (Array.isArray(merged[key].images)) {
                            merged[key].images = merged[key].images.map(img => {
                                if (typeof img === 'string') {
                                    return { url: img };
                                }
                                return img;
                            });
                        }
                        // Миграция recipe_table -> recipe_tables
                        if (merged[key].recipe_table != null && typeof merged[key].recipe_table === 'object' && !Array.isArray(merged[key].recipe_tables)) {
                            merged[key].recipe_tables = [merged[key].recipe_table];
                            delete merged[key].recipe_table;
                        }
                        if (!Array.isArray(merged[key].recipe_tables)) {
                            merged[key].recipe_tables = [];
                        }
                        merged[key].recipe_tables.forEach(t => {
                            if (t && !Array.isArray(t.rows)) t.rows = [];
                        });
                        // Миграция expandable.table -> expandable.tables
                        if (Array.isArray(merged[key].expandables)) {
                            merged[key].expandables.forEach(expandable => {
                                if (expandable.table != null && typeof expandable.table === 'object' && !Array.isArray(expandable.tables)) {
                                    expandable.tables = [expandable.table];
                                    delete expandable.table;
                                }
                                if (!Array.isArray(expandable.tables)) {
                                    expandable.tables = [];
                                }
                                (expandable.tables || []).forEach(t => {
                                    if (t && !Array.isArray(t.rows)) t.rows = [];
                                });
                            });
                        }
                    } else {
                        merged[key] = { ...merged[key], ...savedData[key] };
                    }
                } else {
                    merged[key] = savedData[key];
                }
            }
            return merged;
        },
        // Функция для парсинга строкового числа с запятой в число
        parseMenuNumber(value) {
            if (!value || value === '') return 0;
            // Заменяем запятую на точку для парсинга
            const str = String(value).replace(',', '.');
            const num = parseFloat(str);
            return isNaN(num) ? 0 : num;
        },
        // Функция для форматирования числа обратно в строку с запятой
        formatMenuNumber(value) {
            if (value === 0 || value === '0') return '0,00';
            const num = typeof value === 'string' ? this.parseMenuNumber(value) : value;
            return num.toFixed(2).replace('.', ',');
        },
        // Функция расчета дневного КБЖУ
        calculateDailyKbju() {
            const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
            const kbjuFields = ['proteins', 'fats', 'carbs', 'calories'];
            
            // Инициализируем суммы
            const withSnack = { proteins: 0, fats: 0, carbs: 0, calories: 0 };
            const withoutSnack = { proteins: 0, fats: 0, carbs: 0, calories: 0 };
            
            // Суммируем значения для каждого приема пищи
            mealKeys.forEach(mealKey => {
                const meal = this.menuData[mealKey];
                if (meal && meal.kbju) {
                    kbjuFields.forEach(field => {
                        const value = this.parseMenuNumber(meal.kbju[field] || 0);
                        withSnack[field] += value;
                        
                        // Для "без перекуса" не учитываем snack
                        if (mealKey !== 'snack') {
                            withoutSnack[field] += value;
                        }
                    });
                }
            });
            
            // Обновляем значения дневного КБЖУ
            kbjuFields.forEach(field => {
                this.menuData.daily_kbju.with_snack[field] = this.formatMenuNumber(withSnack[field]);
                this.menuData.daily_kbju.without_snack[field] = this.formatMenuNumber(withoutSnack[field]);
            });
        },
        async saveMenu() {
            this.loading = true;
            try {
                // Сохраняем содержимое редакторов перед отправкой
                if (typeof tinymce !== 'undefined') {
                    const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
                    mealKeys.forEach(mealKey => {
                        // Сохраняем редакторы рецептов
                        const recipeEditorId = `recipe-editor-${mealKey}`;
                        const recipeEditor = tinymce.get(recipeEditorId);
                        if (recipeEditor) {
                            recipeEditor.save();
                            this.menuData[mealKey].recipe = recipeEditor.getContent();
                        }
                        
                        // Сохраняем редакторы содержания в expandable блоках
                        const expandables = this.menuData[mealKey]?.expandables || [];
                        expandables.forEach((expandable, index) => {
                            const expandableEditorId = `expandable-content-${mealKey}-${index}`;
                            const expandableEditor = tinymce.get(expandableEditorId);
                            if (expandableEditor) {
                                expandableEditor.save();
                                if (this.menuData[mealKey] && this.menuData[mealKey].expandables && this.menuData[mealKey].expandables[index]) {
                                    this.menuData[mealKey].expandables[index].content = expandableEditor.getContent();
                                }
                            }
                        });
                    });
                }
                
                // Очищаем устаревшие ключи из menuData перед сохранением
                const mealKeys = ['breakfast', 'snack', 'dinner', 'lunch'];
                const cleanedMenuData = JSON.parse(JSON.stringify(this.menuData));
                mealKeys.forEach(mealKey => {
                    if (!cleanedMenuData[mealKey]) return;
                    if (cleanedMenuData[mealKey].tables) delete cleanedMenuData[mealKey].tables;
                    if (cleanedMenuData[mealKey].recipe_table !== undefined) delete cleanedMenuData[mealKey].recipe_table;
                    (cleanedMenuData[mealKey].expandables || []).forEach(exp => {
                        if (exp.table !== undefined) delete exp.table;
                    });
                });
                
                // Отправляем menu_data как объект, Laravel автоматически его обработает
                const formData = {
                    ...this.form,
                    menu_data: cleanedMenuData
                };
                
                const response = await fetch(this.url, {
                    method: this.action !== 'create' ? 'PUT' : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.token
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (data.success) {
                    if(this.action === 'create') {
                        window.location.href = '/admin/' + this.route + '/';
                    } else {
                        this.showAlert('Сохранено');
                    }
                } else {
                    this.errors = data.errors || {};
                    this.showAlert(data.errors || 'Ошибка при сохранении', true);
                }
            } catch (e) {
                console.log(e);
                this.showAlert('Ошибка при сохранении: ' + e.message, true);
            } finally {
                this.loading = false;
            }
        },
        addExpandable(mealKey) {
            if (!this.menuData[mealKey].expandables) {
                this.menuData[mealKey].expandables = [];
            }
            this.menuData[mealKey].expandables.push({ 
                title: '', 
                content: '', 
                note: '',
                tables: []
            });
            // Инициализируем редактор для нового expandable блока
            this.$nextTick(() => {
                setTimeout(() => {
                    this.initializeExpandableContentEditors();
                }, 300);
            });
        },
        removeExpandable(mealKey, index) {
            this.menuData[mealKey].expandables.splice(index, 1);
        },
        addTableToExpandable(mealKey, expandableIndex) {
            const expandable = this.menuData[mealKey].expandables[expandableIndex];
            if (!expandable.tables) {
                expandable.tables = [];
            }
            expandable.tables.push({
                title: '',
                type: 'products',
                background_color: '',
                rows: []
            });
        },
        removeTableFromExpandable(mealKey, expandableIndex, tableIndex) {
            const expandable = this.menuData[mealKey].expandables[expandableIndex];
            if (expandable.tables) {
                expandable.tables.splice(tableIndex, 1);
            }
        },
        addTableRowToExpandable(mealKey, expandableIndex, tableIndex) {
            const expandable = this.menuData[mealKey].expandables[expandableIndex];
            if (!expandable.tables || !expandable.tables[tableIndex]) return;
            const table = expandable.tables[tableIndex];
            if (!table.rows) table.rows = [];
            table.rows.push({
                product: '',
                weight: '',
                proteins: '',
                fats: '',
                carbs: '',
                calories: ''
            });
        },
        removeTableRowFromExpandable(mealKey, expandableIndex, tableIndex, rowIndex) {
            const expandable = this.menuData[mealKey].expandables[expandableIndex];
            if (expandable.tables && expandable.tables[tableIndex] && expandable.tables[tableIndex].rows) {
                expandable.tables[tableIndex].rows.splice(rowIndex, 1);
            }
        },
        importCsvToExpandableTable(event, mealKey, expandableIndex, tableIndex) {
            const file = event.target.files[0];
            if (!file) return;

            const expandable = this.menuData[mealKey].expandables[expandableIndex];
            if (!expandable.tables) expandable.tables = [];
            if (!expandable.tables[tableIndex]) {
                expandable.tables[tableIndex] = { title: '', type: 'products', background_color: '', rows: [] };
            }
            const table = expandable.tables[tableIndex];
            if (!table.rows) table.rows = [];

            const reader = new FileReader();
            reader.onload = (e) => {
                const text = e.target.result;
                const normalizedText = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
                const lines = normalizedText.split('\n').filter(line => line.trim());
                
                if (lines.length === 0) {
                    alert('Файл пустой');
                    return;
                }

                const firstLine = lines[0];
                let delimiter = firstLine.includes(';') ? ';' : (firstLine.includes(',') ? ',' : null);
                if (!delimiter) {
                    alert('Ошибка: Не удалось определить разделитель CSV. Используйте запятую (,) или точку с запятой (;)');
                    return;
                }

                const parseCsvLine = (line, d) => {
                    const result = [];
                    let current = '';
                    let inQuotes = false;
                    for (let i = 0; i < line.length; i++) {
                        const char = line[i];
                        const nextChar = line[i + 1];
                        if (char === '"') {
                            if (inQuotes && nextChar === '"') { current += '"'; i++; } else inQuotes = !inQuotes;
                        } else if (char === d && !inQuotes) {
                            result.push(current.trim());
                            current = '';
                        } else current += char;
                    }
                    result.push(current.trim());
                    return result;
                };

                const normalizeHeader = (header) => header.toLowerCase().replace(/,/g, '').replace(/\s+/g, ' ').trim();
                const headerMap = {
                    'продукт': 'product', 'product': 'product', 'вес (гр)': 'weight', 'вес гр': 'weight', 'вес': 'weight', 'weight': 'weight',
                    'белки': 'proteins', 'бел гр': 'proteins', 'бел': 'proteins', 'proteins': 'proteins',
                    'жиры': 'fats', 'жир гр': 'fats', 'жир': 'fats', 'fats': 'fats',
                    'углеводы': 'carbs', 'угл гр': 'carbs', 'угл': 'carbs', 'carbs': 'carbs',
                    'калории': 'calories', 'кал ккал': 'calories', 'ккал': 'calories', 'calories': 'calories'
                };
                const headers = parseCsvLine(lines[0], delimiter).map(h => h.replace(/^"|"$/g, '').trim().toLowerCase());
                const normalizedHeaders = headers.map(h => headerMap[normalizeHeader(h)] || headerMap[h] || h);
                if (!normalizedHeaders.includes('product')) {
                    alert('Ошибка: В CSV файле отсутствует колонка "Продукт"');
                    return;
                }

                let imported = 0, skipped = 0;
                for (let i = 1; i < lines.length; i++) {
                    const values = parseCsvLine(lines[i], delimiter).map(v => v.replace(/^"|"$/g, '').trim());
                    if (values.every(v => !v)) { skipped++; continue; }
                    const row = {};
                    normalizedHeaders.forEach((header, index) => { row[header] = values[index] || ''; });
                    if (row.product) {
                        table.rows.push({
                            product: row.product || '', weight: row.weight || '', proteins: row.proteins || '',
                            fats: row.fats || '', carbs: row.carbs || '', calories: row.calories || ''
                        });
                        imported++;
                    } else skipped++;
                }
                event.target.value = '';
                alert(`Импорт завершен!\nИмпортировано: ${imported}\nПропущено: ${skipped}`);
            };
            reader.onerror = () => alert('Ошибка при чтении файла');
            reader.readAsText(file, 'UTF-8');
        },
        addRecipeTable(mealKey) {
            if (!this.menuData[mealKey].recipe_tables) {
                this.menuData[mealKey].recipe_tables = [];
            }
            this.menuData[mealKey].recipe_tables.push({
                title: '',
                type: 'products',
                background_color: '',
                rows: []
            });
        },
        removeRecipeTable(mealKey, tableIndex) {
            if (this.menuData[mealKey].recipe_tables) {
                this.menuData[mealKey].recipe_tables.splice(tableIndex, 1);
            }
        },
        addRecipeTableRow(mealKey, tableIndex) {
            const tables = this.menuData[mealKey].recipe_tables;
            if (!tables || !tables[tableIndex]) return;
            if (!tables[tableIndex].rows) tables[tableIndex].rows = [];
            tables[tableIndex].rows.push({
                product: '', weight: '', proteins: '', fats: '', carbs: '', calories: ''
            });
        },
        removeRecipeTableRow(mealKey, tableIndex, rowIndex) {
            const tables = this.menuData[mealKey].recipe_tables;
            if (tables && tables[tableIndex] && tables[tableIndex].rows) {
                tables[tableIndex].rows.splice(rowIndex, 1);
            }
        },
        addImageToGallery(mealKey) {
            if (!this.menuData[mealKey].images) {
                this.menuData[mealKey].images = [];
            }
            this.menuData[mealKey].images.push({ url: '' });
        },
        removeImageFromGallery(mealKey, imgIndex) {
            if (this.menuData[mealKey].images) {
                this.menuData[mealKey].images.splice(imgIndex, 1);
            }
        },
        openImageCropperForGallery(event, mealKey, imgIndex, width, height) {
            console.log('openImageCropperForGallery вызван', { mealKey, imgIndex, width, height });
            const file = event.target.files[0];
            if (!file) {
                console.log('Файл не выбран');
                return;
            }
            
            if (typeof Cropper === 'undefined') {
                console.error('Cropper.js не загружен');
                alert('Ошибка: библиотека Cropper.js не загружена. Пожалуйста, обновите страницу.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (e) => {
                console.log('Изображение загружено, открываем модальное окно');
                this.cropperModal.imageUrl = e.target.result;
                this.cropperModal.mealKey = mealKey;
                this.cropperModal.field = `images[${imgIndex}].url`;
                this.cropperModal.imgIndex = imgIndex;
                this.cropperModal.targetWidth = width;
                this.cropperModal.targetHeight = height;
                this.cropperModal.show = true;
                
                // Ждем пока DOM обновится и Alpine.js отрисует модальное окно
                this.$nextTick(() => {
                    setTimeout(() => {
                        const imageElement = document.getElementById('cropper-image-menu');
                        console.log('Ищем элемент изображения:', imageElement, 'URL:', this.cropperModal.imageUrl);
                        if (imageElement && this.cropperModal.imageUrl) {
                            if (this.cropperModal.cropper) {
                                this.cropperModal.cropper.destroy();
                                this.cropperModal.cropper = null;
                            }
                            
                            // Функция инициализации Cropper
                            const initCropper = () => {
                                console.log('Инициализируем Cropper');
                                try {
                                    this.cropperModal.cropper = new Cropper(imageElement, {
                                        aspectRatio: width / height,
                                        viewMode: 1,
                                        autoCropArea: 1,
                                        responsive: true,
                                        background: false,
                                        guides: true,
                                        center: true,
                                        highlight: false,
                                        cropBoxMovable: true,
                                        cropBoxResizable: true,
                                        toggleDragModeOnDblclick: false,
                                    });
                                    console.log('Cropper инициализирован успешно');
                                } catch (error) {
                                    console.error('Ошибка при инициализации Cropper:', error);
                                    alert('Ошибка при инициализации редактора изображений. Попробуйте обновить страницу.');
                                }
                            };
                            
                            if (imageElement.complete) {
                                initCropper();
                            } else {
                                imageElement.onload = initCropper;
                            }
                        } else {
                            console.error('Элемент изображения не найден или URL пуст');
                        }
                    }, 100);
                });
            };
            reader.onerror = () => {
                console.error('Ошибка при чтении файла');
                alert('Ошибка при чтении файла изображения');
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        },
        importCsvToRecipeTable(event, mealKey, tableIndex) {
            const file = event.target.files[0];
            if (!file) return;

            if (!this.menuData[mealKey].recipe_tables) this.menuData[mealKey].recipe_tables = [];
            if (!this.menuData[mealKey].recipe_tables[tableIndex]) {
                this.menuData[mealKey].recipe_tables[tableIndex] = { title: '', type: 'products', background_color: '', rows: [] };
            }
            const table = this.menuData[mealKey].recipe_tables[tableIndex];
            if (!table.rows) table.rows = [];

            const reader = new FileReader();
            reader.onload = (e) => {
                const text = e.target.result;
                // Нормализация окончаний строк (Windows/Unix/Mac)
                const normalizedText = text.replace(/\r\n/g, '\n').replace(/\r/g, '\n');
                const lines = normalizedText.split('\n').filter(line => line.trim());
                
                if (lines.length === 0) {
                    alert('Файл пустой');
                    return;
                }

                // Определение разделителя: проверяем первую строку (заголовки)
                const firstLine = lines[0];
                let delimiter = ',';
                
                // Если в первой строке есть точка с запятой, используем её
                if (firstLine.includes(';')) {
                    delimiter = ';';
                } else if (firstLine.includes(',')) {
                    delimiter = ',';
                } else {
                    alert('Ошибка: Не удалось определить разделитель CSV. Используйте запятую (,) или точку с запятой (;)');
                    return;
                }

                // Функция для правильного парсинга CSV строки с учетом кавычек
                const parseCsvLine = (line, delimiter) => {
                    const result = [];
                    let current = '';
                    let inQuotes = false;
                    
                    for (let i = 0; i < line.length; i++) {
                        const char = line[i];
                        const nextChar = line[i + 1];
                        
                        if (char === '"') {
                            if (inQuotes && nextChar === '"') {
                                // Двойные кавычки - экранированная кавычка
                                current += '"';
                                i++; // Пропускаем следующую кавычку
                            } else {
                                // Переключаем режим кавычек
                                inQuotes = !inQuotes;
                            }
                        } else if (char === delimiter && !inQuotes) {
                            // Разделитель вне кавычек - новая колонка
                            result.push(current.trim());
                            current = '';
                        } else {
                            current += char;
                        }
                    }
                    // Добавляем последнюю колонку
                    result.push(current.trim());
                    return result;
                };

                const headers = parseCsvLine(lines[0], delimiter).map(h => h.replace(/^"|"$/g, '').trim().toLowerCase());
                
                // Нормализация заголовков (удаляем запятые и лишние пробелы для сравнения)
                const normalizeHeader = (header) => {
                    return header.toLowerCase().replace(/,/g, '').replace(/\s+/g, ' ').trim();
                };
                
                const headerMap = {
                    'продукт': 'product',
                    'product': 'product',
                    'вес (гр)': 'weight',
                    'вес гр': 'weight',
                    'вес': 'weight',
                    'weight': 'weight',
                    'белки': 'proteins',
                    'бел гр': 'proteins',
                    'бел': 'proteins',
                    'proteins': 'proteins',
                    'жиры': 'fats',
                    'жир гр': 'fats',
                    'жир': 'fats',
                    'fats': 'fats',
                    'углеводы': 'carbs',
                    'угл гр': 'carbs',
                    'угл': 'carbs',
                    'carbs': 'carbs',
                    'калории': 'calories',
                    'кал ккал': 'calories',
                    'ккал': 'calories',
                    'calories': 'calories'
                };

                const normalizedHeaders = headers.map(h => {
                    const normalized = normalizeHeader(h);
                    // Сначала проверяем нормализованный вариант, потом оригинал
                    return headerMap[normalized] || headerMap[h] || h;
                });
                
                // Отладка: выводим информацию о заголовках
                console.log('Заголовки CSV:', headers);
                console.log('Нормализованные заголовки:', normalizedHeaders);
                
                // Проверка наличия обязательного поля product
                if (!normalizedHeaders.includes('product')) {
                    alert('Ошибка: В CSV файле отсутствует колонка "Продукт". Найденные заголовки: ' + headers.join(', '));
                    return;
                }

                let imported = 0;
                let skipped = 0;

                // Парсинг строк данных (начиная со второй строки)
                for (let i = 1; i < lines.length; i++) {
                    const rawValues = parseCsvLine(lines[i], delimiter);
                    const values = rawValues.map(v => {
                        // Удаляем кавычки
                        let cleaned = v.replace(/^"|"$/g, '');
                        // Удаляем ВСЕ пробелы в начале и конце (включая неразрывные пробелы)
                        cleaned = cleaned.replace(/^[\s\u00A0]+|[\s\u00A0]+$/g, '');
                        return cleaned;
                    });
                    
                    // Пропуск пустых строк
                    if (values.every(v => !v)) {
                        skipped++;
                        continue;
                    }

                    const row = {};
                    // Создаем маппинг: оригинальный индекс заголовка -> нормализованное имя
                    headers.forEach((originalHeader, originalIndex) => {
                        const normalized = normalizeHeader(originalHeader);
                        const mappedHeader = headerMap[normalized] || headerMap[originalHeader] || originalHeader;
                        // Используем оригинальный индекс для получения значения
                        const value = values[originalIndex] !== undefined && values[originalIndex] !== null 
                            ? String(values[originalIndex]).trim() 
                            : '';
                        row[mappedHeader] = value;
                    });
                    
                    // Отладка для первых двух строк
                    if (i <= 2) {
                        console.log(`Строка ${i}:`, {
                            rawValues: rawValues,
                            values: values,
                            normalizedHeaders: normalizedHeaders,
                            row: row
                        });
                    }

                    // Добавление строки только если есть название продукта
                    if (row.product && row.product.trim()) {
                        const newRow = {
                            product: (row.product || '').trim(),
                            weight: (row.weight || '').trim(),
                            proteins: (row.proteins || '').trim(),
                            fats: (row.fats || '').trim(),
                            carbs: (row.carbs || '').trim(),
                            calories: (row.calories || '').trim()
                        };
                        
                        // Отладка для первой строки
                        if (i === 1) {
                            console.log('Добавляемая строка:', newRow);
                        }
                        
                        table.rows.push(newRow);
                        imported++;
                    } else {
                        skipped++;
                    }
                }

                // Очистка input для возможности повторной загрузки того же файла
                event.target.value = '';

                alert(`Импорт завершен!\nИмпортировано: ${imported}\nПропущено: ${skipped}`);
            };

            reader.onerror = () => {
                alert('Ошибка при чтении файла');
            };

            reader.readAsText(file, 'UTF-8');
        },
        addRecommendationContent() {
            if (!this.menuData.recommendations.content) {
                this.menuData.recommendations.content = [];
            }
            this.menuData.recommendations.content.push('');
        },
        removeRecommendationContent(index) {
            this.menuData.recommendations.content.splice(index, 1);
        },
        addNextDayPreview() {
            if (!this.menuData.recommendations.next_day_preview) {
                this.menuData.recommendations.next_day_preview = [];
            }
            this.menuData.recommendations.next_day_preview.push({
                meal: '',
                image: '',
                description: ''
            });
        },
        removeNextDayPreview(index) {
            this.menuData.recommendations.next_day_preview.splice(index, 1);
        },
        uploadImageToArray(event, array, index, field) {
            const reader = new FileReader();
            reader.onload = () => {
                array[index][field] = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
            event.target.value = '';
        },
        openImageCropper(event, mealKey, field, width, height) {
            console.log('openImageCropper вызван', { mealKey, field, width, height });
            const file = event.target.files[0];
            if (!file) {
                console.log('Файл не выбран');
                return;
            }
            
            if (typeof Cropper === 'undefined') {
                console.error('Cropper.js не загружен');
                alert('Ошибка: библиотека Cropper.js не загружена. Пожалуйста, обновите страницу.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = (e) => {
                console.log('Изображение загружено, открываем модальное окно');
                this.cropperModal.imageUrl = e.target.result;
                this.cropperModal.mealKey = mealKey;
                this.cropperModal.field = field;
                this.cropperModal.targetWidth = width;
                this.cropperModal.targetHeight = height;
                this.cropperModal.show = true;
                
                // Ждем пока DOM обновится и Alpine.js отрисует модальное окно
                this.$nextTick(() => {
                    setTimeout(() => {
                        const imageElement = document.getElementById('cropper-image-menu');
                        console.log('Ищем элемент изображения:', imageElement, 'URL:', this.cropperModal.imageUrl);
                        if (imageElement && this.cropperModal.imageUrl) {
                            if (this.cropperModal.cropper) {
                                this.cropperModal.cropper.destroy();
                                this.cropperModal.cropper = null;
                            }
                            
                            // Функция инициализации Cropper
                            const initCropper = () => {
                                console.log('Инициализируем Cropper');
                                try {
                                    this.cropperModal.cropper = new Cropper(imageElement, {
                                        aspectRatio: width / height,
                                        viewMode: 1,
                                        autoCropArea: 1,
                                        responsive: true,
                                        background: false,
                                        guides: true,
                                        center: true,
                                        highlight: true,
                                        cropBoxMovable: true,
                                        cropBoxResizable: true,
                                    });
                                    console.log('Cropper инициализирован успешно');
                                } catch (error) {
                                    console.error('Ошибка инициализации Cropper:', error);
                                    alert('Ошибка инициализации редактора: ' + error.message);
                                }
                            };
                            
                            // Убеждаемся что изображение загружено
                            if (imageElement.complete && imageElement.naturalWidth > 0) {
                                initCropper();
                            } else {
                                imageElement.onload = initCropper;
                                imageElement.onerror = () => {
                                    console.error('Ошибка загрузки изображения');
                                    alert('Ошибка загрузки изображения');
                                };
                            }
                        } else {
                            console.error('Элемент изображения не найден или URL пустой');
                            console.log('Попытка найти элемент через 500ms...');
                            setTimeout(() => {
                                const retryElement = document.getElementById('cropper-image-menu');
                                if (retryElement) {
                                    console.log('Элемент найден при повторной попытке');
                                    this.cropperModal.cropper = new Cropper(retryElement, {
                                        aspectRatio: width / height,
                                        viewMode: 1,
                                        autoCropArea: 1,
                                        responsive: true,
                                        background: false,
                                        guides: true,
                                        center: true,
                                        highlight: true,
                                        cropBoxMovable: true,
                                        cropBoxResizable: true,
                                    });
                                }
                            }, 500);
                        }
                    }, 300);
                });
            };
            reader.onerror = (error) => {
                console.error('Ошибка чтения файла:', error);
                this.showAlert('Ошибка загрузки изображения', true);
            };
            reader.readAsDataURL(file);
            event.target.value = '';
        },
        closeImageCropper() {
            this.cropperModal.show = false;
            if (this.cropperModal.cropper) {
                this.cropperModal.cropper.destroy();
                this.cropperModal.cropper = null;
            }
            this.cropperModal.imgIndex = undefined;
        },
        saveCroppedImage() {
            console.log('saveCroppedImage вызван');
            if (!this.cropperModal.cropper) {
                console.error('Cropper не инициализирован');
                alert('Ошибка: редактор не инициализирован');
                return;
            }
            
            try {
                const canvas = this.cropperModal.cropper.getCroppedCanvas({
                    width: this.cropperModal.targetWidth,
                    height: this.cropperModal.targetHeight,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                if (canvas) {
                    const croppedImageUrl = canvas.toDataURL('image/jpeg', 0.9);
                    console.log('Изображение обрезано, сохраняем в', this.cropperModal.mealKey, this.cropperModal.field);
                    
                    // Сохраняем в menuData
                    if (this.menuData[this.cropperModal.mealKey]) {
                        // Проверяем, сохраняем ли мы в массив images
                        if (this.cropperModal.field && this.cropperModal.field.startsWith('images[') && typeof this.cropperModal.imgIndex !== 'undefined') {
                            // Сохраняем в массив images
                            if (!this.menuData[this.cropperModal.mealKey].images) {
                                this.menuData[this.cropperModal.mealKey].images = [];
                            }
                            if (!this.menuData[this.cropperModal.mealKey].images[this.cropperModal.imgIndex]) {
                                this.menuData[this.cropperModal.mealKey].images[this.cropperModal.imgIndex] = { url: '' };
                            }
                            this.menuData[this.cropperModal.mealKey].images[this.cropperModal.imgIndex].url = croppedImageUrl;
                            console.log('Изображение сохранено в галерею, индекс:', this.cropperModal.imgIndex);
                        } else {
                            // Обычное сохранение в поле
                            this.menuData[this.cropperModal.mealKey][this.cropperModal.field] = croppedImageUrl;
                            console.log('Изображение сохранено');
                        }
                    } else {
                        console.error('mealKey не найден:', this.cropperModal.mealKey);
                    }
                    
                    this.closeImageCropper();
                }
            } catch (error) {
                console.error('Ошибка при сохранении изображения:', error);
                alert('Ошибка при сохранении изображения: ' + error.message);
            }
        },
        uploadImageForMenu(event, fieldPath) {
            const reader = new FileReader();
            reader.onload = () => {
                try {
                    // Парсим путь вида 'menuData.breakfast.image' или 'menuData.recommendations.next_day_preview[0].image'
                    // Убираем 'menuData.' из начала пути, так как мы уже в контексте this
                    const path = fieldPath.replace(/^menuData\./, '');
                    const parts = path.split('.');
                    let current = this.menuData;
                    
                    for (let i = 0; i < parts.length; i++) {
                        const part = parts[i];
                        
                        // Обработка массивов вида 'next_day_preview[0]'
                        if (part.includes('[') && part.includes(']')) {
                            const match = part.match(/(\w+)\[(\d+)\]/);
                            if (match) {
                                const [, name, idx] = match;
                                const index = parseInt(idx);
                                
                                if (i === parts.length - 1) {
                                    // Последний элемент - устанавливаем значение
                                    if (!current[name]) current[name] = [];
                                    current[name][index] = reader.result;
                                } else {
                                    // Промежуточный элемент - переходим дальше
                                    if (!current[name]) current[name] = [];
                                    if (!current[name][index]) current[name][index] = {};
                                    current = current[name][index];
                                }
                            }
                        } else {
                            if (i === parts.length - 1) {
                                // Последний элемент - устанавливаем значение
                                current[part] = reader.result;
                            } else {
                                // Промежуточный элемент - переходим дальше
                                if (!current[part]) current[part] = {};
                                current = current[part];
                            }
                        }
                    }
                } catch (e) {
                    console.error('Ошибка загрузки изображения:', e);
                    this.showAlert('Ошибка загрузки изображения', true);
                }
            };
            reader.readAsDataURL(event.target.files[0]);
            event.target.value = '';
        }
    }
}
</script>
@endsection
