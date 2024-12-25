@component('mail::message')
    # Обратная связь

    Имя: {{ $name }}
    E-mail: {{ $email }}
    Телефон: {{ $phone }}
    Сообщение: {{ $message }}

    Спасибо,<br>
    {{ config('app.name') }}
@endcomponent
