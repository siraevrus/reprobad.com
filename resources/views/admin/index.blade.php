@extends('admin.layouts.base')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Админ панель</h1>

    <a href="{{ route('admin.pages.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>страница</span>
    </a>

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
        <tr class="text-gray-600 text-sm leading-normal">
            <td class="py-3 px-6 text-left">Всего советов</td>
            <td class="py-3 px-6 text-left font-extrabold">{{ $advises }}</td>
        </tr>
    </table>
@endsection
