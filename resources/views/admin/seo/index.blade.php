@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">SEO управление</h1>
        <a href="{{ route('admin.seo.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Добавить SEO
        </a>
    </div>

    @if(session('success'))
        <div class="px-6 py-4 text-base text-green-600 rounded-lg mb-5 bg-green-200 border border-green-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">SEO данные страниц</h2>
        </div>
        
        @if($seoData->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Тип страницы</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Название</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($seoData as $seo)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @switch($seo->page_type)
                                        @case('Article')
                                            Статья
                                            @break
                                        @case('Page')
                                            Страница
                                            @break
                                        @case('Product')
                                            Продукт
                                            @break
                                        @case('Event')
                                            Событие
                                            @break
                                        @case('Advise')
                                            Совет
                                            @break
                                        @case('Complex')
                                            Комплекс
                                            @break
                                        @default
                                            {{ $seo->page_type }}
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $seo->page->title ?? 'Не найдено' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($seo->title, 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($seo->description, 80) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.seo.edit', $seo->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('admin.seo.destroy', $seo->id) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 ml-2"
                                                onclick="return confirm('Вы уверены, что хотите удалить эти SEO данные?')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center text-gray-500">
                <p>SEO данные не найдены</p>
            </div>
        @endif
    </div>
@endsection 