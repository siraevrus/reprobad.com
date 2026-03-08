@extends('site.layouts.base')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "{{ config('app.url') }}",
        "name": "Главная"
      }
    },
    {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "{{ route('site.events.index') }}",
        "name": "События"
      }
    },
    {
      "@type": "ListItem",
      "position": 3,
      "item": {
        "@id": "{{ route('site.events.show', $resource->alias) }}",
        "name": "{{ strip_tags($resource->title) }}"
      }
    }
  ]
}
</script>
@php
    $eventImage = $resource->image ?? $resource->logo ?? null;
    if ($eventImage && !str_starts_with($eventImage, 'http')) {
        $eventImage = config('app.url') . '/' . ltrim($eventImage, '/');
    }
    $eventStartDate = null;
    if ($resource->dates) {
        try {
            $dateStr = trim(explode('-', $resource->dates)[0] ?? $resource->dates);
            $d = \Carbon\Carbon::createFromFormat('d.m.Y', $dateStr);
            $eventStartDate = $d ? $d->toIso8601String() : null;
        } catch (\Exception $e) {
            $eventStartDate = null;
        }
    }
    $eventSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => strip_tags($resource->title),
        'description' => strip_tags($resource->description ?? ''),
        'organizer' => [
            '@type' => 'Organization',
            'name' => 'Система РЕПРО',
        ],
    ];
    if ($eventImage) {
        $eventSchema['image'] = $eventImage;
    }
    if ($eventStartDate) {
        $eventSchema['startDate'] = $eventStartDate;
    }
    if ($resource->address) {
        $eventSchema['location'] = [
            '@type' => 'Place',
            'name' => strip_tags($resource->address),
        ];
    }
@endphp
<script type="application/ld+json">
{!! json_encode($eventSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <div class="page-background mandarin"></div>
    <section class="section article-section">
        <div class="container">
            <div class="breadcrumbs">
                <a href="{{ route('site.events.index') }}" nav="back" class="breadcrumb">&lt;- События</a>
            </div>
            <div class="article-head full-width">
                <h1 class="article-h1">{{ $resource->title }}</h1>
                <div class="event-options">
                    <div class="event-place">
                        <div class="event-date">{{ $resource->dates }}</div>
                        <div class="event-address">{!! $resource->address !!}</div>
                    </div>
                    <div class="event-contacts">
                        @if(isset($resource->email) && $resource->email)
                        <a href="#" class="event-link w-inline-block"><img src="images/event-email-icon_1event-email-icon.png" loading="lazy" alt="email" class="event-link-icon">
                            <div>{{ $resource->email }}</div>
                        </a>
                        @endif
                        @if(isset($resource->phone) && $resource->phone)
                        <a href="#" class="event-link w-inline-block"><img src="images/event-phone-icon_1event-phone-icon.png" loading="lazy" alt="phone" class="event-link-icon">
                            <div>{{ $resource->phone }}</div>
                        </a>
                        @endif
                    </div>
                    @if(isset($resource->logo) && $resource->logo)
                    <img src="{{ $resource->logo }}" loading="lazy" alt="{{ $resource->logo_alt ?? strip_tags($resource->title) }}" class="event-logo">
                    @endif
                    <a href="#" class="queston-popup-button w-button">Задать вопрос</a>
                    @if(isset($resource->file) && $resource->file)
                    <a href="{{ $resource->file }}" class="event-programm-button w-inline-block">
                        <div>Программа мероприятия</div>
                        <div class="event-programm-button-action">Скачать</div>
                    </a>
                    @endif
                </div>
            </div>
            <div class="article-wrap">
                <div class="article-content">
                    <div class="w-richtext">
                        @if($resource->image)
                        <figure class="w-richtext-align-center w-richtext-figure-type-image">
                            <div><img src="{{ $resource->image }}" loading="lazy" alt="{{ $resource->image_alt ?? strip_tags($resource->title) }}" class="image"></div>
                        </figure>
                        @endif
                        {!! $resource->content ?? '' !!}
                    </div>
                </div>
                <div class="side" x-data="app()">
                    <div class="side-promo">
                        <a href="//www.eapteka.ru/search/?q=репро" target="_blank">
                            <img src="images/banner.png" style="width:100%" alt="Купить в Eapteka">
                        </a>
                    </div>
                    <div class="mobile-popup">
                        <div class="mobile-popup-overlay"></div>
                        <div class="question-form-block w-form">
                            <form action="{{ route('site.form.feedback') }}" @submit.prevent="feedbackForm" method="post" class="form" x-show="!successFeedback">
                                <a href="#" class="close-popup-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="закрыть" class="x-icon"></a>
                                <div class="form-h">Возникли вопросы?</div>
                                <input class="text-field w-input" x-model="formFeedback.name" autocomplete="off" maxlength="256" placeholder="ФИО*" type="text" id="name-3"  :class="errorsFeedback.name ? 'input-error' : ''">
                                <input class="text-field w-input" x-model="formFeedback.email" autocomplete="off" maxlength="256" placeholder="Email*" type="email" id="email-6"  :class="errorsFeedback.email ? 'input-error' : ''">
                                <input class="text-field w-input" x-model="formFeedback.phone" autocomplete="off" maxlength="256" placeholder="Номер телефона" type="tel" id="phone-2"  :class="errorsFeedback.phone ? 'input-error' : ''">
                                <textarea class="text-field text-area w-input" x-model="formFeedback.message" autocomplete="off" maxlength="5000" placeholder="Ваш вопрос…" id="message-2" :class="errorsFeedback.message ? 'input-error' : ''"></textarea>
                                <div class="checkbox-wrap">
                                    <label class="w-checkbox subscribe-checkbox black">
                                        <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                                        <input type="checkbox" x-model="formFeedback.agree" id="agree-2" data-name="Agree 2" style="opacity:0;position:absolute;z-index:-1" checked="">
                                        <span class="subscribe-checkbox-label w-form-label" for="agree-2">
                                            Соглашаюсь с&nbsp;<a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link black">правилами <a href="privacy" target="_blank">политики конфиденциальности</a> в&nbsp;отношении персональных&nbsp;данных</a>
                                        </span>
                                    </label>
                                </div>
                                <input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Отправить" :disabled="isSubmitting">
                            </form>

                            <div x-show="successFeedback" x-cloak class="success-message w-form-done" tabindex="-1" role="region" aria-label="Question Form success">
                                <img src="images/success-icon.svg" loading="lazy" alt="иконка письмо отправлено" class="success-icon">
                                <div>Вопрос отправлен</div>
                                <a href="#" class="close-popup-button w-inline-block" @click.prevent="successFeedback = false; formFeedback = {name: '', email: '', phone: '', message: '', agree: true}; errorsFeedback = {};">
                                    <img src="images/x.svg" loading="lazy" alt="закрыть" class="x-icon">
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="side-footer">
                        <div class="subscribe">
                            <div class="subscribe-body w-form">
                                <form action="{{ route('site.form.subscribe') }}" @submit.prevent="subscribeForm" method="post" class="form subscribe-form" x-show="!successSubscribe">
                                    <div class="subscribe-head-label">Подписаться на рассылку</div>
                                    <input class="text-field w-input" autocomplete="off" maxlength="256" x-model="formSubscribe.email" placeholder="Ваш Email*" type="email" id="subscribe_email" :class="errorsSubscribe.email ? 'input-error' : ''">
                                    <label class="w-checkbox subscribe-checkbox">
                                        <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                                        <input type="checkbox" x-model="formSubscribe.agree" id="agree" required="" style="opacity:0;position:absolute;z-index:-1" checked="">
                                        <span class="subscribe-checkbox-label w-form-label" for="agree">
                                            Даю согласие на получение рассылки с&nbsp;сайта «Репробад» и соглашаюсь с&nbsp;<a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link">правилами политики конфиденциальности в&nbsp;отношении персональных&nbsp;данных</a>
                                        </span>
                                    </label>
                                    <input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Подписаться">
                                </form>

                                <div x-show="successSubscribe" class="subscribe-success w-form-done" tabindex="-1" role="region" aria-label="Subscribe Form success">
                                    <img src="images/success-icon.svg" loading="lazy" alt="иконка письмо отправлено" class="success-icon">
                                    <div>Вы успешно подписались <br>на рассылку!</div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <style>
        .input-error {
            border: 1px solid red;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
        function app() {
            return {
                formFeedback: {
                    name: '',
                    email: '',
                    phone: '',
                    message: '',
                    agree: true
                },
                formSubscribe: {
                    email: '',
                    agree: 1
                },
                errorsFeedback: {},
                errorsSubscribe: {},
                successFeedback: false,
                successSubscribe: false,
                isSubmitting: false,

                async feedbackForm() {
                    // Предотвращаем двойную отправку
                    if (this.isSubmitting) {
                        return;
                    }
                    
                    this.isSubmitting = true;
                    this.errorsFeedback = {};
                    
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        
                        if (!token) {
                            throw new Error('CSRF токен не найден');
                        }
                        
                        // Преобразуем agree в правильный формат для валидации (checkbox возвращает true/false)
                        const formData = {
                            name: this.formFeedback.name?.trim() || '',
                            email: this.formFeedback.email?.trim() || '',
                            phone: this.formFeedback.phone?.trim() || '',
                            message: this.formFeedback.message?.trim() || '',
                            agree: this.formFeedback.agree ? 1 : 0
                        };
                        
                        console.log('Отправка формы:', formData);
                        
                        const response = await fetch('/forms/feedback', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        });

                        console.log('Ответ сервера:', response.status, response.statusText);
                        
                        let data;
                        try {
                            data = await response.json();
                            console.log('Данные ответа:', data);
                        } catch (e) {
                            console.error('Ошибка парсинга JSON:', e);
                            throw new Error('Неверный формат ответа от сервера');
                        }
                        
                        if (response.ok && data.success) {
                            console.log('Успешная отправка, показываем сообщение');
                            this.errorsFeedback = {};
                            this.successFeedback = true;
                            // Очищаем форму после успешной отправки
                            this.formFeedback = {
                                name: '',
                                email: '',
                                phone: '',
                                message: '',
                                agree: 1
                            };
                        } else {
                            console.log('Ошибки валидации:', data.errors);
                            this.errorsFeedback = data.errors || {};
                            this.successFeedback = false;
                        }
                    }
                    catch (e) {
                        console.error('Ошибка при отправке формы:', e);
                        this.errorsFeedback = { 
                            general: [e.message || 'Произошла ошибка при отправке формы. Попробуйте еще раз.'] 
                        };
                        this.successFeedback = false;
                    }
                    finally {
                        this.isSubmitting = false;
                    }
                },

                async subscribeForm() {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch('/forms/subscribe', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                email: this.formSubscribe.email,
                                agree: this.formSubscribe.agree
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.errorsSubscribe = {};
                            this.successSubscribe = true;
                        } else {
                            this.errorsSubscribe = data.errors;
                        }
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    </script>
@endsection
