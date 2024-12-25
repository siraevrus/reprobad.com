@extends('site.layouts.base')

@section('content')
    <section class="section contacts-form-section">
        <div class="container contacts-form-container"><img sizes="100vw" srcset="images/m1-p-500.webp 500w, images/m1-p-800.webp 800w, images/m1-p-1080.webp 1080w, images/m1.webp 1440w" alt="" src="images/m1.webp" loading="lazy" class="contacts-bg">
            <div class="contacts-content">
                <div class="contacts-head">
                    <div class="rfarm-contacts-logo-wrap"><img loading="lazy" src="images/RFarmLogo.png" alt="" class="rfarm-green-logo"></div>
                    <h1 class="contacts-h1">Контакты</h1>
                    <div>
                        {{ config('address') }}<br>
                        <a href="https://yandex.ru/maps/213/moscow/?ll=37.510402%2C55.661594&amp;mode=poi&amp;poi%5Bpoint%5D=37.509937%2C55.661575&amp;poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D1167776098&amp;z=15.75" target="_blank" class="contacts-map-link">на карте —&gt;</a>
                    </div>
                </div>
                <p class="mb-0 mw-24rem">Если у вас есть вопросы, позвоните на нашу горячую линию или напишите письмо:</p>
                <div class="contacts-wrap">
                    <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', config('phone2')) }}" class="contacts-link hot-line w-inline-block">
                        <div class="contacts-icon-wrap"><img loading="lazy" src="images/green-phone.svg" alt="" class="contacts-link-icon">
                            <div class="contacts-link-label">Телефон горячей линии</div>
                        </div>
                        <div class="contacts-link-text">{{ config('phone2') }}</div>
                    </a>
                    <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', config('phone')) }}" class="contacts-link w-inline-block">
                        <div class="contacts-icon-wrap"><img loading="lazy" src="images/green-phone.svg" alt="" class="contacts-link-icon"></div>
                        <div class="contacts-link-text">{{ config('phone') }}</div>
                    </a>
                    <a href="mailto:info@rpharm.ru" class="contacts-link w-inline-block">
                        <div class="contacts-icon-wrap"><img loading="lazy" src="images/green-email.svg" alt="" class="contacts-link-icon"></div>
                        <div class="contacts-link-text">{{ config('email') }}</div>
                    </a>
                </div>
                <div class="contacts-divider"></div>
                <p class="mb--1rem mob-mb--0-5rem">Контакты для средств массовой информации:</p>
                <a href="mailto:{{ config('email2') }}" class="contacts-link w-inline-block">
                    <div class="contacts-link-text">{{ config('email2') }}</div>
                </a>
                <div class="contacts-divider"></div>
                <p class="mb-0 mob-mb--05rem">О возможных нарушениях законодательства, кодекса этики ведения бизнеса, антикоррупционной или антимонопольной политики, а также положения о конфликте интересов можно анонимно сообщить на горячую линию:</p>
                <div class="contacts-wrap">
                    <a href="tel:{{ str_replace([' ', '(', ')', '-'], '', config('phone')) }}" class="contacts-link mb--0-5rem w-inline-block">
                        <div class="contacts-link-text">{{ config('phone') }}</div>
                    </a>
                    <a href="mailto:{{ config('email') }}" class="contacts-link w-inline-block">
                        <div class="contacts-link-text">{{ config('email') }}</div>
                    </a>
                </div>
            </div>
            <div class="contacts-form">
                <div class="question-form-block w-form">
                    <form class="form wf-form-Subscribe-Form" method="post" action="{{ route('site.form.feedback') }}">
                        @csrf
                        <a href="#" class="close-popup-button w-inline-block">
                            <img src="images/x.svg" loading="lazy" alt="" class="x-icon">
                        </a>
                        <div class="form-h">Возникли вопросы?</div>
                        <input class="text-field w-input mb-2" autocomplete="off" maxlength="256" name="name" placeholder="ФИО*" type="text" required="">
                        <input class="text-field w-input mb-2" autocomplete="off" maxlength="256" name="email" placeholder="Email*" type="email" required="">
                        <input class="text-field w-input mb-2" autocomplete="off" maxlength="256" name="phone" placeholder="Номер телефона" type="tel" required="">
                        <textarea class="text-field text-area w-input" autocomplete="off" maxlength="5000" name="message" placeholder="Ваш вопрос…"></textarea>
                        <div class="checkbox-wrap">
                            <label class="w-checkbox subscribe-checkbox black">
                                <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                                <input type="checkbox" value="1" name="agree" id="agree-2" style="opacity:0;position:absolute;z-index:-1" checked="">
                                <span class="subscribe-checkbox-label w-form-label" for="agree-2">
                                    Соглашаюсь с <a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link black">правилами политики конфиденциальности в отношении персональных данных</a>
                                </span>
                            </label>
                        </div>
                        <input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Отправить">
                    </form>
                </div>
                @if(session()->has('message'))
                    <div class="success-message w-form-done" style="display: block;margin-top:30px">
                        <img src="images/success-icon.svg" loading="lazy" alt="" class="success-icon">
                        <div>Ваш вопрос отправлен!</div>
                        <a href="#" class="close-popup-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="" class="x-icon"></a>
                    </div>
                @endif
                @if($errors->any())
                    <div class="error-message w-form-fail" style="display: block">
                        <div>Заполните требуемые поля</div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
