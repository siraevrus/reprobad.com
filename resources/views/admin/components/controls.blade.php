<form method="post" action="{{ route("admin.$route.destroy", $resource->id) }}" class="flex items-center justify-center gap-2">
    @csrf
    @method('DELETE')

    @if(in_array($route, ['complex', 'products']))
    <a href="{{ route("admin.$route.up", $resource->id) }}" class="text-blue-500 hover:text-blue-700">
        <span class="material-icons">arrow_upward</span>
    </a>
    <a href="{{ route("admin.$route.down", $resource->id) }}" class="text-blue-500 hover:text-blue-700">
        <span class="material-icons">arrow_downward</span>
    </a>
    @endif

    <a href="{{ route("admin.$route.edit", $resource->id) }}" class="text-blue-500 hover:text-blue-700">
        <span class="material-icons">edit</span>
    </a>
    <a href="{{ route("admin.$route.switch", $resource->id) }}" class="text-blue-500 hover:text-blue-700">
        <span class="material-icons">visibility{{ $resource->active ? '' : '_off' }}</span>
    </a>
    <button type="submit" onclick="return confirm('Вы уверены, что хотите удалить?');" class="text-red-500 hover:text-red-700">
        <span class="material-icons">delete</span>
    </button>
</form>
