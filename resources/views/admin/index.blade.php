@extends('admin.layouts.base')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Админ панель</h1>

    <a href="{{ route('admin.articles.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>статья</span>
    </a>

    <a href="{{ route('admin.events.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>событие</span>
    </a>

    <a href="{{ route('admin.products.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>продукт</span>
    </a>

    <a href="{{ route('admin.advises.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>совет</span>
    </a>

    <a href="{{ route('admin.pages.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>страница</span>
    </a>

    <a href="{{ route('admin.menus.index') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">restaurant</span>
        <span>меню</span>
    </a>

    <a href="{{ route('admin.file-manager.index') }}" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">folder</span>
        <span>файловый менеджер</span>
    </a>

    <a href="{{ route('admin.seo.index') }}" class="px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">search</span>
        <span>SEO управление</span>
    </a>

    <a href="{{ route('admin.chat-history.index') }}" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">history</span>
        <span>История запросов бота</span>
    </a>

    <div class="px-6 py-4 text-base text-green-600 rounded-lg mb-5 bg-green-200 border border-green-500">
        Иконки должны находится по пути "storage/app/public/icons" в формате svg
    </div>

    <table class="min-w-full border border-gray-200">
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего новостей</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $articles }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего страниц</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $pages }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего событий</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $events }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего продуктов</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $products }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего советов</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $advises }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего меню</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $menus }}</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal">
            <td class="py-3 px-6 text-left">Всего выборов городов</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $totalCitySelections }}</td>
        </tr>
    </table>

    @if(!empty($cityStats))
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Статистика выбора городов</h2>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Город</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Количество выборов</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Процент</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Визуализация</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cityStats as $city => $count)
                                @php
                                    $percentage = $totalCitySelections > 0 ? round(($count / $totalCitySelections) * 100, 1) : 0;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $city }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $percentage }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="mt-8">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">Статистика выбора городов пока пуста. Данные появятся после того, как пользователи начнут выбирать города.</p>
            </div>
        </div>
    @endif
@endsection
