@extends('admin.layouts.base')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Статистика: {{ $shortLink->name ?: 'Короткая ссылка #' . $shortLink->id }}</h1>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.short-links.edit', $shortLink) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Редактировать</a>
            <a href="{{ route('admin.short-links.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Назад</a>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-medium text-gray-800 mb-2">Короткая ссылка</h2>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="font-mono text-blue-600 break-all">{{ $shortLink->short_url }}</span>
                <button type="button" id="copy-short-url" data-url="{{ $shortLink->short_url }}"
                        class="px-2 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded inline-flex items-center gap-1">
                    <span class="material-icons text-sm">content_copy</span> Копировать
                </button>
            </div>
            <p class="mt-2 text-sm text-gray-500">Ведёт на: <span class="break-all">{{ $shortLink->long_url }}</span></p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Статистика</h2>
            <p class="text-2xl font-semibold text-gray-900">Всего переходов: {{ $shortLink->clicks_count }}</p>

            @if($clicksByDay->isNotEmpty())
                <h3 class="mt-4 text-md font-medium text-gray-700 mb-2">Переходы по дням (последние 30 дней)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left">Дата</th>
                            <th class="py-2 px-4 text-left">Кликов</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clicksByDay as $row)
                            <tr class="border-b border-gray-200">
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($row->date)->format('d.m.Y') }}</td>
                                <td class="py-2 px-4">{{ $row->count }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Последние переходы (до 100)</h2>
            @if($recentClicks->isEmpty())
                <p class="text-gray-500">Пока нет данных о переходах</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 text-left">Дата и время</th>
                            <th class="py-2 px-4 text-left">Referer</th>
                            <th class="py-2 px-4 text-left">User-Agent</th>
                            <th class="py-2 px-4 text-left">IP</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recentClicks as $click)
                            <tr class="border-b border-gray-200">
                                <td class="py-2 px-4 whitespace-nowrap">{{ $click->clicked_at->format('d.m.Y H:i:s') }}</td>
                                <td class="py-2 px-4 max-w-xs truncate" title="{{ $click->referer }}">{{ $click->referer ?: '—' }}</td>
                                <td class="py-2 px-4 max-w-md truncate" title="{{ $click->user_agent }}">{{ Str::limit($click->user_agent, 60) ?: '—' }}</td>
                                <td class="py-2 px-4">{{ $click->ip ?: '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('scripts')
<script>
    document.getElementById('copy-short-url').addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        navigator.clipboard.writeText(url).then(function() {
            var btn = document.getElementById('copy-short-url');
            var text = btn.innerHTML;
            btn.innerHTML = '<span class="material-icons text-sm">check</span> Скопировано';
            setTimeout(function() { btn.innerHTML = text; }, 2000);
        });
    });
</script>
@endsection
