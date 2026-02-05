@extends('admin.layouts.base')

@section('content')
    @if(session('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.test-questions.index') }}" 
           class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
            ← Назад к списку
        </a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-4">Создать вопрос теста</h1>
    </div>

    <form action="{{ route('admin.test-questions.store') }}" method="POST" class="space-y-6" id="question-form">
        @csrf

        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Порядок вопроса (1-24) *
                </label>
                <input type="number" 
                       name="order" 
                       id="order-input"
                       value="{{ old('order') }}" 
                       min="1" 
                       max="24" 
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Текст вопроса *
                </label>
                <textarea name="question_text" 
                          id="question-text-input"
                          rows="3" 
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('question_text') }}</textarea>
                @error('question_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Варианты ответов *
                </label>
                <div id="answers-container" class="space-y-2">
                    <div class="answer-item flex gap-2 items-center">
                        <input type="text" 
                               name="answers[0][text]" 
                               placeholder="Текст ответа" 
                               required
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md">
                        <input type="number" 
                               name="answers[0][value]" 
                               placeholder="Балл" 
                               min="0" 
                               max="3" 
                               value="0"
                               required
                               class="w-24 px-3 py-2 border border-gray-300 rounded-md">
                        <button type="button" 
                                class="remove-answer bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600"
                                style="display: none;">
                            Удалить
                        </button>
                    </div>
                </div>
                <button type="button" 
                        id="add-answer" 
                        class="mt-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    + Добавить ответ
                </button>
                @error('answers')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="active" 
                           value="1" 
                           {{ old('active', true) ? 'checked' : '' }}
                           class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Активен</span>
                </label>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                Создать вопрос
            </button>
            <a href="{{ route('admin.test-questions.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Отмена
            </a>
        </div>
    </form>

    <script>
        let answerIndex = 1;
        
        document.getElementById('add-answer').addEventListener('click', function() {
            const container = document.getElementById('answers-container');
            const newAnswer = document.createElement('div');
            newAnswer.className = 'answer-item flex gap-2 items-center';
            newAnswer.innerHTML = `
                <input type="text" 
                       name="answers[${answerIndex}][text]" 
                       placeholder="Текст ответа" 
                       required
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md">
                <input type="number" 
                       name="answers[${answerIndex}][value]" 
                       placeholder="Балл" 
                       min="0" 
                       max="3" 
                       value="0"
                       required
                       class="w-24 px-3 py-2 border border-gray-300 rounded-md">
                <button type="button" 
                        class="remove-answer bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">
                    Удалить
                </button>
            `;
            container.appendChild(newAnswer);
            answerIndex++;
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            const items = document.querySelectorAll('.answer-item');
            items.forEach((item, index) => {
                const removeBtn = item.querySelector('.remove-answer');
                if (items.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-answer')) {
                const item = e.target.closest('.answer-item');
                item.remove();
                updateRemoveButtons();
            }
        });

        updateRemoveButtons();
    </script>

    @if(session('message'))
        <script>
            // Очищаем форму после успешного сохранения
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('question-form').reset();
                document.getElementById('answers-container').innerHTML = `
                    <div class="answer-item flex gap-2 items-center">
                        <input type="text" 
                               name="answers[0][text]" 
                               placeholder="Текст ответа" 
                               required
                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md">
                        <input type="number" 
                               name="answers[0][value]" 
                               placeholder="Балл" 
                               min="0" 
                               max="3" 
                               value="0"
                               required
                               class="w-24 px-3 py-2 border border-gray-300 rounded-md">
                        <button type="button" 
                                class="remove-answer bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600"
                                style="display: none;">
                            Удалить
                        </button>
                    </div>
                `;
                answerIndex = 1;
                updateRemoveButtons();
            });
        </script>
    @endif
@endsection
