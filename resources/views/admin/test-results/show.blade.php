@extends('admin.layouts.base')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.test-results.index') }}" 
           class="text-blue-500 hover:text-blue-700 mb-4 inline-block">
            ← Назад к списку
        </a>
        <h1 class="text-2xl font-semibold text-gray-800 mt-4">Результат теста #{{ $resource->id }}</h1>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Информация о прохождении</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Email</label>
                <p class="mt-1 text-gray-900">{{ $resource->email ?? 'Не указан' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Дата прохождения</label>
                <p class="mt-1 text-gray-900">{{ $resource->date }}</p>
            </div>
            @if($resource->user_id)
            <div>
                <label class="block text-sm font-medium text-gray-500">Пользователь</label>
                <p class="mt-1 text-gray-900">ID: {{ $resource->user_id }}</p>
            </div>
            @endif
        </div>
    </div>

    @if(isset($resource->results['scores']))
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Баллы по категориям</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 p-4 rounded">
                <label class="block text-sm font-medium text-gray-500">Психоэмоциональное состояние</label>
                <p class="mt-1 text-2xl font-bold text-blue-600">
                    {{ $resource->results['scores']['category1'] ?? 0 }}
                </p>
            </div>
            <div class="bg-green-50 p-4 rounded">
                <label class="block text-sm font-medium text-gray-500">Микрофлора и детоксикация</label>
                <p class="mt-1 text-2xl font-bold text-green-600">
                    {{ $resource->results['scores']['category2'] ?? 0 }}
                </p>
            </div>
            <div class="bg-yellow-50 p-4 rounded">
                <label class="block text-sm font-medium text-gray-500">Метаболизм и энергия</label>
                <p class="mt-1 text-2xl font-bold text-yellow-600">
                    {{ $resource->results['scores']['category3'] ?? 0 }}
                </p>
            </div>
            <div class="bg-purple-50 p-4 rounded">
                <label class="block text-sm font-medium text-gray-500">Репродуктивное здоровье</label>
                <p class="mt-1 text-2xl font-bold text-purple-600">
                    {{ $resource->results['scores']['category4'] ?? 0 }}
                </p>
            </div>
        </div>
    </div>
    @endif

    @if(isset($resource->results['results']) && is_array($resource->results['results']) && count($resource->results['results']) > 0)
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Рекомендации ({{ count($resource->results['results']) }})</h2>
        <div class="space-y-4">
            @foreach($resource->results['results'] as $index => $result)
            <div class="border border-gray-200 rounded-lg p-4 {{ isset($result['color']) ? 'bg-' . $result['color'] . '-50' : '' }}">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Кодирование {{ $result['coding'] ?? ($index + 1) }}
                    </h3>
                    @if(isset($result['score']))
                    <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-sm">
                        Балл: {{ $result['score'] }}
                    </span>
                    @endif
                </div>
                <h4 class="font-medium text-gray-700 mb-2">{{ $result['title'] ?? '' }}</h4>
                <p class="text-gray-600 mb-3">{{ $result['description'] ?? '' }}</p>
                
                @if(isset($result['products']) && is_array($result['products']) && count($result['products']) > 0)
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-500 mb-2">Рекомендуемые продукты:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($result['products'] as $product)
                        <li class="text-gray-700">
                            <strong>{{ $product['name'] ?? '' }}</strong>
                            @if(isset($product['duration']))
                                <span class="text-gray-500">({{ $product['duration'] }})</span>
                            @endif
                            @if(isset($product['link']))
                                <a href="{{ $product['link'] }}" target="_blank" class="text-blue-500 hover:text-blue-700 ml-2">
                                    → Ссылка
                                </a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Ответы на вопросы</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-2 px-4 text-left">Вопрос</th>
                    <th class="py-2 px-4 text-center">Ответ</th>
                    <th class="py-2 px-4 text-center">Балл</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                @if(isset($resource->answers) && is_array($resource->answers))
                    @php
                        $questions = [
                            'Я чувствую тревогу, беспокойство, напряжение без видимой причины',
                            'Я плохо засыпаю вечером',
                            'Мне трудно просыпаться по утрам',
                            'После пробуждения я чувствую разбитость, сонливость',
                            'Я злоупотребляю энергетиками (включая чай и кофе)',
                            'Я испытываю сентиментальность, плаксивость без видимой причины',
                            'У меня бывают проблемы со стулом',
                            'Я испытываю дискомфорт, распирание, вздутие живота во время или после еды?',
                            'У меня бывают аллергические реакции, высыпания на коже, зуд',
                            'В течение последнего года я использовал антибиотики',
                            'Я принимаю препараты, которые могут влиять на печень',
                            'У меня бывают простудные заболевания',
                            'В моей жизни присутствуют вредные привычки (алкоголь, курение и т д)',
                            'Я нахожусь в экологически неблагоприятной обстановке',
                            'У меня есть избыточный вес',
                            'Я оцениваю свой уровень энергии в течение дня как',
                            'У меня бывают головокружения, слабость, потливость',
                            'Я метеочувствительный',
                            'Я ем сладости, быстрые углеводы, фаст-фуд',
                            'У меня бывают покалывания, онемение или "мурашки" в руках, ногах, ступнях',
                            'У меня бывают проблемы с кожей, волосами, ногтями',
                            'У меня бывают проблемы с памятью, концентрацией внимания или перепады настроения',
                            'Я испытываю проблемы с сексуальным влечением',
                            'У меня есть проблемы с менструальным циклом (для женщин)',
                        ];
                        $answerLabels = [
                            0 => 'Никогда / Нет',
                            1 => 'Редко',
                            2 => 'Часто',
                            3 => 'Постоянно / Да',
                        ];
                    @endphp
                    @foreach($resource->answers as $index => $answer)
                    <tr class="border-b border-gray-200">
                        <td class="py-2 px-4">{{ $index + 1 }}. {{ $questions[$index] ?? 'Вопрос ' . ($index + 1) }}</td>
                        <td class="py-2 px-4 text-center">
                            {{ $answerLabels[$answer] ?? $answer }}
                        </td>
                        <td class="py-2 px-4 text-center">
                            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">
                                {{ $answer }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">
                            Ответы не сохранены
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex gap-4">
        <form action="{{ route('admin.test-results.destroy', $resource->id) }}" 
              method="POST" 
              onsubmit="return confirm('Вы уверены, что хотите удалить этот результат?');">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded">
                Удалить результат
            </button>
        </form>
    </div>
@endsection
