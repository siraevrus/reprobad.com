@extends('admin.layouts.base')

@section('content')
    <div x-data="app()" x-init="init()">

        @include('admin.components.alert')

        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ request()->segment(3) == 'create' ? 'Создать' : 'Изменить' }} статью</h2>
        <form action="#" method="POST" class="space-y-6" @submit.prevent="save">
            @csrf

            <div>@include('admin.components.image-crop-input', ['title' => 'Фото', 'field' => 'image', 'width' => 1280, 'height' => 853])</div>
            <div>@include('admin.components.text-input', ['title' => 'Alt для фото', 'field' => 'image_alt'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Заголовок', 'field' => 'title'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Алиас', 'field' => 'alias'])</div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block font-semibold">SEO description</label>
                    <button type="button" @click="generateAi('description')"
                            :disabled="aiLoading.description"
                            class="flex items-center gap-1 px-3 py-1 text-sm bg-violet-600 hover:bg-violet-700 disabled:opacity-50 text-white rounded transition">
                        <span x-show="!aiLoading.description">✨ AI</span>
                        <span x-show="aiLoading.description">⏳ Генерирую...</span>
                    </button>
                </div>
                @include('admin.components.text-input', ['title' => '', 'field' => 'seo_description'])
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block font-semibold">Meta Keywords</label>
                    <button type="button" @click="generateAi('keywords')"
                            :disabled="aiLoading.keywords"
                            class="flex items-center gap-1 px-3 py-1 text-sm bg-violet-600 hover:bg-violet-700 disabled:opacity-50 text-white rounded transition">
                        <span x-show="!aiLoading.keywords">✨ AI</span>
                        <span x-show="aiLoading.keywords">⏳ Генерирую...</span>
                    </button>
                </div>
                @include('admin.components.textarea-input', ['title' => '', 'field' => 'seo_keywords', 'rows' => 2, 'no_editor' => true])
            </div>

            <div>@include('admin.components.select-input', ['title' => 'Активно', 'field' => 'active', 'options' => ['1' => 'Да', '0' => 'Нет']])</div>

            <div>
                <label class="block font-semibold mb-2">Иконка</label>
                <div class="flex space-x-2">
                    @foreach($icons as $icon)
                        <label for="icon_{{ $icon }}">
                            <input id="icon_{{ $icon }}" type="radio" name="icon" value="{{ $icon }}" x-model="form.icon" class="mr-2">
                            <img src="{{ $icon }}" alt="">
                        </label>
                    @endforeach
                </div>
            </div>

            <div>@include('admin.components.text-input', ['title' => 'Время на чтение', 'field' => 'time'])</div>

            <div>@include('admin.components.text-input', ['title' => 'Категория', 'field' => 'category'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Короткий текст', 'field' => 'description'])</div>

            <div>@include('admin.components.textarea-input', ['title' => 'Содержание', 'field' => 'content'])</div>

            @include('admin.components.buttons')
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        function app() {
            return {
                ...initializeEditor,
                ...userIsNotActive,
                ...imageUpload,
                ...variables,
                ...showAlert,
                ...get,
                ...save,
                ...init,
                form: {
                    active: 1,
                },
                aiLoading: {
                    keywords: false,
                    description: false,
                },
                async generateAi(type) {
                    const content = this.form.content || '';
                    if (!content.trim()) {
                        this.showAlert('Заполните поле «Содержание» перед генерацией', true);
                        return;
                    }
                    this.aiLoading[type] = true;
                    try {
                        const response = await fetch('/admin/ai/generate', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.token,
                            },
                            body: JSON.stringify({
                                type,
                                content,
                                title: this.form.title || '',
                            }),
                        });
                        const data = await response.json();
                        if (data.success) {
                            if (type === 'keywords') {
                                this.form.seo_keywords = data.result;
                            } else {
                                this.form.seo_description = data.result;
                            }
                        } else {
                            this.showAlert(data.error || 'Ошибка генерации', true);
                        }
                    } catch (e) {
                        this.showAlert('Ошибка запроса к AI: ' + e.message, true);
                    } finally {
                        this.aiLoading[type] = false;
                    }
                },
            }
        }
    </script>
@endsection
