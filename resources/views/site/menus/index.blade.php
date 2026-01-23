@extends('site.layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">РЕПРОменю на семь дней</h1>
        
        @if($menus->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menus as $menu)
                    <a href="{{ route('site.menus.show', $menu->alias) }}" class="block bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                День {{ $menu->day }}
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">{{ $menu->title }}</h2>
                        @if($menu->description)
                            <p class="text-gray-600">{{ Str::limit($menu->description, 150) }}</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-yellow-800">Меню пока не добавлено. Добавьте меню через админ панель.</p>
            </div>
        @endif
    </div>
@endsection
