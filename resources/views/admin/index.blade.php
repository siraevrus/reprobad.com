@extends('admin.layouts.base')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Главная</h1>

    <p class="text-gray-600 mb-6">Добро пожаловать в админ панель</p>

    <a href="{{ route('admin.pages.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>Создать страницу</span>
    </a>

    <a href="{{ route('admin.articles.create') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>Создать новость</span>
    </a>

    <table class="min-w-full border border-gray-200">
        <tr class="text-gray-600 text-sm leading-normal b-gray-600 border-b">
            <td class="py-3 px-6 text-left">Всего новостей</td>
            <td class="py-3 px-6 text-left">2</td>
        </tr>
        <tr class="text-gray-600 text-sm leading-normal">
            <td class="py-3 px-6 text-left">Всего страниц</td>
            <td class="py-3 px-6 text-left">2</td>
        </tr>
    </table>
@endsection
