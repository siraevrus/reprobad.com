@extends('admin.layouts.base')

@section('content')
    @include('admin.components.header', ['title' => 'Короткие ссылки', 'route' => 'short-links'])

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200">
            <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Название</th>
                <th class="py-3 px-6 text-left">Длинная ссылка</th>
                <th class="py-3 px-6 text-left">Короткая ссылка</th>
                <th class="py-3 px-6 text-left">Клики</th>
                <th class="py-3 px-6 text-left">Создан</th>
                <th class="py-3 px-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
            @forelse($resources as $resource)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="py-3 px-6">{{ $resource->id }}</td>
                <td class="py-3 px-6">{{ $resource->name ?: '—' }}</td>
                <td class="py-3 px-6 max-w-xs truncate" title="{{ $resource->long_url }}">{{ Str::limit($resource->long_url, 50) }}</td>
                <td class="py-3 px-6">
                    <span class="font-mono text-blue-600">{{ $resource->short_url }}</span>
                    <button type="button" class="ml-1 text-gray-500 hover:text-gray-700 copy-btn" data-url="{{ $resource->short_url }}" title="Копировать">
                        <span class="material-icons text-sm">content_copy</span>
                    </button>
                </td>
                <td class="py-3 px-6">{{ $resource->clicks_count }}</td>
                <td class="py-3 px-6">{{ $resource->created_at->format('d.m.Y H:i') }}</td>
                <td class="py-3 px-6 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.short-links.show', $resource) }}" class="text-blue-500 hover:text-blue-700" title="Статистика">
                            <span class="material-icons">bar_chart</span>
                        </a>
                        <a href="{{ route('admin.short-links.edit', $resource) }}" class="text-blue-500 hover:text-blue-700" title="Редактировать">
                            <span class="material-icons">edit</span>
                        </a>
                        <form method="post" action="{{ route('admin.short-links.destroy', $resource) }}" class="inline" onsubmit="return confirm('Удалить эту ссылку?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700" title="Удалить">
                                <span class="material-icons">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-6 px-6 text-center text-gray-500">Коротких ссылок пока нет</td>
            </tr>
            @endforelse
            </tbody>
        </table>

        @if($resources->hasPages())
            {{ $resources->links('vendor.pagination.admin') }}
        @endif
    </div>

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.copy-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            navigator.clipboard.writeText(url).then(function() {
                var icon = btn.querySelector('.material-icons');
                if (icon) icon.textContent = 'check';
                setTimeout(function() { if (icon) icon.textContent = 'content_copy'; }, 1500);
            });
        });
    });
</script>
@endsection
