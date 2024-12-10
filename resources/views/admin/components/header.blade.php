<div class="flex justify-between" >
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">{{ $title }}</h1>
    <a href="{{ route("admin.$route.create") }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 mb-5 items-center inline-flex gap-1">
        <span class="material-icons">add</span>
        <span>Создать</span>
    </a>
</div>
