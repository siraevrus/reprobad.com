<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Вход</h2>

    @if(session('error'))
        <div class="mb-4 p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('login.auth') }}" method="POST" class="space-y-4">
        @csrf
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300 @error('email') border-red-500 @enderror"
                placeholder="Введите email"
                required>
            @error('email')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Пароль</label>
            <input
                type="password"
                name="password"
                id="password"
                class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300 @error('password') border-red-500 @enderror"
                placeholder="Введите пароль"
                required>
            @error('password')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center">
            <input
                type="checkbox"
                name="remember"
                id="remember"
                value="1"
                class="h-4 w-4 text-blue-500 border-gray-300 rounded focus:ring-blue-300">
            <label for="remember" class="ml-2 text-sm text-gray-700">Запомнить меня (30 дней)</label>
        </div>
        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                Войти
            </button>
        </div>
    </form>
</div>
</body>
</html>
