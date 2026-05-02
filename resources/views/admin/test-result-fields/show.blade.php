@extends('admin.layouts.base')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.test-result-fields.index') }}" 
           class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
            ← Назад к списку
        </a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-4">Результат теста #{{ $resource->field_number }}</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6 space-y-6">
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Основная информация</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Номер поля</label>
                    <p class="text-gray-800">
                        <span class="bg-purple-200 text-purple-700 px-2 py-1 rounded text-sm font-bold">
                            Поле {{ $resource->field_number }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Блок теста</label>
                    <p class="text-gray-800">
                        @php($bt = \App\Support\ReproTestBlocks::titles())
                        {{ $bt[(int) $resource->block_number] ?? ('Блок ' . (int) $resource->block_number) }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Статус</label>
                    <p>
                        @if($resource->active)
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Активно</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Неактивно</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Цвет блока</label>
                    <p>
                        @if($resource->color)
                            <span class="bg-{{ $resource->color }}-100 text-{{ $resource->color }}-800 px-2 py-1 rounded text-sm">
                                {{ $resource->color }}
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">По умолчанию</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Порядок сортировки</label>
                    <p class="text-gray-800">{{ $resource->order }}</p>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Описание</h2>
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $resource->description }}</p>
            </div>
            <p class="mt-2 text-xs text-gray-500">Этот текст будет вставлен в &lt;p class="reprotest-p"&gt;</p>
        </div>

        @if($resource->email_description)
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Расширенное описание для email</h2>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-gray-800 whitespace-pre-wrap">{{ $resource->email_description }}</p>
            </div>
            <p class="mt-2 text-xs text-gray-500">Этот текст будет использоваться в email-письмах</p>
        </div>
        @endif

        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Продукты</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Продукт 1 -->
                @if($resource->link1 || $resource->image1)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Продукт 1</h3>
                        <div class="mb-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Ссылка</label>
                            @if($resource->link1)
                                <a href="{{ $resource->link1 }}" 
                                   target="_blank" 
                                   class="text-blue-500 hover:text-blue-700 text-sm break-all">
                                    {{ $resource->link1 }}
                                </a>
                            @else
                                <p class="text-xs text-gray-400">Не указано</p>
                            @endif
                        </div>
                        @if($resource->image1)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Изображение</label>
                                <img src="{{ asset($resource->image1) }}" 
                                     alt="Product 1" 
                                     class="max-w-full max-h-48 rounded border border-gray-200">
                            </div>
                        @else
                            <p class="text-xs text-gray-400">Изображение не загружено</p>
                        @endif
                    </div>
                @endif

                <!-- Продукт 2 -->
                @if($resource->link2 || $resource->image2)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Продукт 2</h3>
                        <div class="mb-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Ссылка</label>
                            @if($resource->link2)
                                <a href="{{ $resource->link2 }}" 
                                   target="_blank" 
                                   class="text-blue-500 hover:text-blue-700 text-sm break-all">
                                    {{ $resource->link2 }}
                                </a>
                            @else
                                <p class="text-xs text-gray-400">Не указано</p>
                            @endif
                        </div>
                        @if($resource->image2)
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Изображение</label>
                                <img src="{{ asset($resource->image2) }}" 
                                     alt="Product 2" 
                                     class="max-w-full max-h-48 rounded border border-gray-200">
                            </div>
                        @else
                            <p class="text-xs text-gray-400">Изображение не загружено</p>
                        @endif
                    </div>
                @endif

                @if(!$resource->link1 && !$resource->image1 && !$resource->link2 && !$resource->image2)
                    <p class="text-gray-400">Продукты не добавлены</p>
                @endif
            </div>
        </div>

        <div class="flex gap-4 pt-4 border-t">
            <a href="{{ route('admin.test-result-fields.edit', $resource->id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded">
                Редактировать
            </a>
            <form action="{{ route('admin.test-result-fields.destroy', $resource->id) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Вы уверены, что хотите удалить этот результат?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">
                    Удалить
                </button>
            </form>
        </div>
    </div>
@endsection
