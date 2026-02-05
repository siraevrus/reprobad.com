@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Редактирование результатов теста', 'route' => 'test-result-fields'])

    <div class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            <p class="text-sm">Всего результатов: <strong>{{ $resources->total() }}</strong></p>
            <p class="text-xs text-blue-600 mt-1">Здесь вы настраиваете шаблоны результатов теста (Поля 1-9), которые будут показываться пользователям в зависимости от их ответов</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Номер поля</th>
                <th class="py-3 px-6 text-left">Описание</th>
                <th class="py-3 px-6 text-left">Цвет</th>
                <th class="py-3 px-6 text-left">Продукты</th>
                <th class="py-3 px-6 text-center">Статус</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @forelse($resources as $resource)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">
                        <span class="bg-purple-200 text-purple-700 px-2 py-1 rounded text-xs font-bold">
                            Поле {{ $resource->field_number }}
                        </span>
                    </td>
                    <td class="py-3 px-6">
                        <div class="max-w-md truncate" title="{{ $resource->description }}">
                            {{ Str::limit($resource->description, 100) }}
                        </div>
                    </td>
                    <td class="py-3 px-6">
                        @if($resource->color)
                            <span class="bg-{{ $resource->color }}-100 text-{{ $resource->color }}-800 px-2 py-1 rounded text-xs">
                                {{ $resource->color }}
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">По умолчанию</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @php
                            $hasProducts = 0;
                            if($resource->image1 && $resource->link1) $hasProducts++;
                            if($resource->image2 && $resource->link2) $hasProducts++;
                        @endphp
                        @if($hasProducts > 0)
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                {{ $hasProducts }}
                            </span>
                        @else
                            <span class="text-gray-400">0</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        @if($resource->active)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Активно</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Неактивно</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.test-result-fields.show', $resource->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Просмотр
                            </a>
                            <a href="{{ route('admin.test-result-fields.edit', $resource->id) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Редактировать
                            </a>
                            <form action="{{ route('admin.test-result-fields.destroy', $resource->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Вы уверены, что хотите удалить этот результат?');">
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
                        Результаты пока не настроены. <a href="{{ route('admin.test-result-fields.create') }}" class="text-blue-500 hover:text-blue-700">Создать первый результат</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $resources->links() }}
    </div>
@endsection
