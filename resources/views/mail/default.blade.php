@component('mail::message')
    # Подпись на рассылку

    E-mail: {{ $email }}

    Спасибо,<br>
    {{ config('app.name') }}
@endcomponent
