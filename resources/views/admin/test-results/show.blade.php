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

    @php $r = $resource->results ?? []; @endphp

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Расчёт</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-gray-500">ИБГБ:</span>
                <span class="font-semibold">{{ (int) ($r['ibhb'] ?? 0) }}%</span>
            </div>
            <div>
                <span class="text-gray-500">Сумма S:</span>
                <span class="font-semibold">{{ (int) ($r['S'] ?? 0) }}</span>
            </div>
            <div class="md:col-span-2">
                <span class="text-gray-500">Активные кодирования:</span>
                <span class="font-mono">{{ isset($r['active_codings']) ? implode(', ', $r['active_codings']) : '—' }}</span>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
            @foreach([1 => 'B₁ / IDX₁', 2 => 'B₂ / IDX₂', 3 => 'B₃ / IDX₃', 4 => 'B₄ / IDX₄'] as $bn => $label)
            <div class="bg-gray-50 p-3 rounded border border-gray-100">
                <div class="text-xs text-gray-500">{{ $label }}</div>
                <div class="text-lg font-bold text-gray-800">{{ (int) (($r['B'][$bn] ?? 0)) }} / {{ (int) (($r['IDX'][$bn] ?? 0)) }}%</div>
            </div>
            @endforeach
        </div>
    </div>

    @if(!empty($r['items']) && is_array($r['items']))
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Рекомендации по полям ({{ count($r['items']) }})</h2>
        <div class="space-y-4">
            @foreach($r['items'] as $item)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="text-sm text-gray-500 mb-1">Поле №{{ $item['field_number'] ?? '?' }}</div>
                <div class="text-gray-800 text-sm">{!! $item['description'] ?? '' !!}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(!empty($r['blocks']) && is_array($r['blocks']))
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Блоки на экране результата</h2>
        <div class="space-y-4">
            @foreach($r['blocks'] as $bn => $block)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="font-semibold text-gray-800 mb-2">Блок {{ $bn }} — IDX {{ (int) ($block['idx'] ?? 0) }}%</div>
                @if(!empty($block['paragraphs']))
                <div class="text-sm text-gray-600 space-y-1 mb-2">
                    @foreach($block['paragraphs'] as $p)
                    <div class="border-l-2 border-gray-200 pl-2">{!! $p !!}</div>
                    @endforeach
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
