@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Вопросы теста', 'route' => 'test-questions'])

    <div class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <p class="text-sm">Всего вопросов: <strong>{{ $resources->total() }}</strong></p>
        </div>
    </div>

    @php
        $blockTitles = \App\Support\ReproTestBlocks::titles();
    @endphp

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Порядок</th>
                <th class="py-3 px-6 text-left">Блок</th>
                <th class="py-3 px-6 text-left">Текст вопроса</th>
                <th class="py-3 px-6 text-left">Варианты ответов</th>
                <th class="py-3 px-6 text-center">Статус</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @forelse($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs font-bold">
                            {{ $resource->order }}
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        <span class="bg-indigo-50 text-indigo-800 px-2 py-1 rounded text-xs max-w-xs inline-block" title="{{ $blockTitles[(int) $resource->block_number] ?? '' }}">
                            {{ $blockTitles[(int) $resource->block_number] ?? ('Блок ' . (int) $resource->block_number) }}
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        <div class="max-w-md truncate" title="{{ $resource->question_text }}">
                            {{ $resource->question_text }}
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        @if(is_array($resource->answers))
                            <div class="flex flex-wrap gap-1">
                                @foreach($resource->answers as $answer)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                        {{ $answer['text'] }} ({{ $answer['value'] }})
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($resource->active)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Активен</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Неактивен</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.test-questions.show', $resource->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Просмотр
                            </a>
                            <a href="{{ route('admin.test-questions.edit', $resource->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Редактировать
                            </a>
                            <form action="{{ route('admin.test-questions.destroy', $resource->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить этот вопрос?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        Вопросов пока нет. <a href="{{ route('admin.test-questions.create') }}" class="text-blue-500 hover:text-blue-700">Создать первый вопрос</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
