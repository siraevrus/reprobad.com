@extends('admin.layouts.base')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.test-questions.index') }}" 
           class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
            ← Назад к списку
        </a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-4">Вопрос теста #{{ $resource->id }}</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Порядок</label>
                <p class="mt-1 text-gray-900 text-lg font-bold">{{ $resource->order }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Блок теста</label>
                <p class="mt-1 text-gray-900">
                    @php($bt = \App\Support\ReproTestBlocks::titles())
                    {{ $bt[(int) $resource->block_number] ?? ('Блок ' . (int) $resource->block_number) }}
                </p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Статус</label>
                <p class="mt-1">
                    @if($resource->active)
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Активен</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Неактивен</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-500 mb-2">Текст вопроса</label>
            <p class="text-gray-900">{{ $resource->question_text }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-500 mb-2">Варианты ответов</label>
            @php $sortedAnswers = $resource->sorted_answers; @endphp
            @if(count($sortedAnswers) > 0)
                <p class="mb-2 text-xs text-gray-500">Отсортировано по баллу: 1‑й вариант — 0&nbsp;баллов, 2‑й — 1, 3‑й — 2, 4‑й — 3.</p>
                <div class="space-y-2">
                    @foreach($sortedAnswers as $idx => $answer)
                        <div class="bg-gray-50 p-3 rounded border border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-900 font-medium">{{ $idx + 1 }}. {{ $answer['text'] ?? '' }}</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">
                                    Балл: {{ $answer['value'] ?? 0 }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Варианты ответов не заданы</p>
            @endif
        </div>
    </div>

    <div class="flex gap-4">
        <a href="{{ route('admin.test-questions.edit', $resource->id) }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded">
            Редактировать
        </a>
        <form action="{{ route('admin.test-questions.destroy', $resource->id) }}" 
              method="POST" 
              onsubmit="return confirm('Вы уверены, что хотите удалить этот вопрос?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">
                Удалить вопрос
            </button>
        </form>
    </div>
@endsection
