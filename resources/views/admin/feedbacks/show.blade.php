@extends('admin.layouts.base')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.feedbacks.index') }}" class="text-blue-600 hover:text-blue-800">← Назад к списку</a>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Вопрос с сайта #{{ $resource->id }}</h1>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Дата</label>
                <div class="text-gray-900">{{ $resource->date }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ФИО</label>
                <div class="text-gray-900">{{ $resource->name }}</div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <div class="text-gray-900">
                    <a href="mailto:{{ $resource->email }}" class="text-blue-600 hover:text-blue-800">{{ $resource->email }}</a>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Телефон</label>
                <div class="text-gray-900">
                    @if($resource->phone)
                        <a href="tel:{{ $resource->phone }}" class="text-blue-600 hover:text-blue-800">{{ $resource->phone }}</a>
                    @else
                        <span class="text-gray-400">Не указан</span>
                    @endif
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Вопрос</label>
                <div class="text-gray-900 bg-gray-50 p-4 rounded border border-gray-200 whitespace-pre-wrap">{{ $resource->message }}</div>
            </div>
        </div>
        
        <div class="mt-6">
            <form action="{{ route('admin.feedbacks.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить этот вопрос?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Удалить вопрос</button>
            </form>
        </div>
    </div>
@endsection

