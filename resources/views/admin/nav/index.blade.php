@extends('admin.layouts.base')

@section('content')
    <div x-data="app()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} меню</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <ul>
                <template x-for="(item, index) in form.menu" :key="index">
                    <li class="mb-4">
                        <div class="flex items-center gap-2">
                            <!-- Редактирование названия и URL -->
                            <input type="text" x-model="item.title" class="p-2 border rounded" />
                            <input type="text" x-model="item.url" class="p-2 border rounded" />
                            <button @click="addSubMenuItem(index)" class="px-4 py-2 bg-blue-500 text-white rounded">
                                Добавить
                            </button>

                            <!-- Кнопка удаления только для новых пунктов -->
                            <button
                                @click="removeMenuItem(index)"
                                x-show="item.isNew"
                                class="text-red-500">
                                Удалить
                            </button>
                        </div>

                        <!-- Дочерние элементы -->
                        <ul class="ml-6 mt-2">
                            <template x-for="(child, childIndex) in item.subLinks" :key="childIndex">
                                <li class="flex items-center gap-2">
                                    <input type="text" x-model="child.title" class="p-2 border rounded" />
                                    <input type="text" x-model="child.url" class="p-2 border rounded" />

                                    <!-- Кнопка удаления для подменю -->
                                    <button
                                        @click="removeSubMenuItem(index, childIndex)"
                                        x-show="child.isNew"
                                        class="text-red-500">
                                        Удалить
                                    </button>
                                </li>
                            </template>
                        </ul>

                    </li>
                </template>
            </ul>

            <!-- Форма добавления новых пунктов меню -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Добавить новый пункт меню</h3>
                <input type="text" x-model="newItem.title" placeholder="Название пункта" class="p-2 border rounded mb-2 w-full">
                <input type="text" x-model="newItem.url" placeholder="URL" class="p-2 border rounded mb-2 w-full">
                <button @click="addMenuItem()" class="px-4 py-2 bg-blue-500 text-white rounded">Добавить</button>
            </div>
            <div class="mt-4 flex justify-end">
                <button @click.prevent="save()" class="px-4 py-2 bg-green-500 text-white rounded">Сохранить</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function app() {
            return {
                ...save,
                form: {
                    menu: @json($data)
                },
                newItem: {
                    title: '',
                    url: '',
                    isNew: true,
                    subLinks: []
                },
                newChildItem: {
                    title: '',
                    url: '',
                    isNew: true
                },

                addMenuItem() {
                    this.form.menu.push({ ...this.newItem });
                    this.newItem = {
                        title: '',
                        url: '',
                        isNew: true,
                        subLinks: []
                    };
                },
                addSubMenuItem(parentIndex) {
                    this.form.menu[parentIndex].subLinks.push({ ...this.newChildItem });
                    this.newChildItem = {
                        title: '',
                        url: '',
                        isNew: true
                    };
                },
                removeMenuItem(index) {
                    if (this.form.menu[index].isNew) {
                        this.form.menu.splice(index, 1);
                    }
                },
                removeSubMenuItem(parentIndex, childIndex) {
                    if (this.form.menu[parentIndex].subLinks[childIndex].isNew) {
                        this.form.menu[parentIndex].subLinks.splice(childIndex, 1);
                    }
                },
            };
        }
    </script>
@endsection
