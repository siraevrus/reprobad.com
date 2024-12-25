@extends('site.layouts.base')

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
                        <div class="event-address">{{ $resource->address }}</div>
                    </div>
                    <div class="event-contacts">
                        @if(isset($resource->email) && $resource->email)
                        <a href="#" class="event-link w-inline-block"><img src="images/event-email-icon_1event-email-icon.png" loading="lazy" alt="" class="event-link-icon">
                            <div>{{ $resource->email }}</div>
                        </a>
                        @endif
                        @if(isset($resource->phone) && $resource->phone)
                        <a href="#" class="event-link w-inline-block"><img src="images/event-phone-icon_1event-phone-icon.png" loading="lazy" alt="" class="event-link-icon">
                            <div>{{ $resource->phone }}</div>
                        </a>
                        @endif
                    </div>
                    @if(isset($resource->logo) && $resource->logo)
                    <img src="{{ $resource->logo }}" loading="lazy" alt="" class="event-logo">
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
                        <figure class="w-richtext-align-fullwidth w-richtext-figure-type-image">
                            <div><img src="{{ $resource->image }}" loading="lazy" alt="" class="image"></div>
                        </figure>
                        @endif
                        {!! $resource->content ?? '' !!}
                    </div>
                </div>
                <div class="side">
                    <div class="mobile-popup">
                        <div class="mobile-popup-overlay"></div>
                        <div class="question-form-block w-form">
                            <form action="{{ route('site.form.feedback') }}" method="post" class="form">
                                @csrf
                                <a href="#" class="close-popup-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="" class="x-icon"></a>
                                <div class="form-h">Возникли вопросы?</div>
                                <input class="text-field w-input" name="name" autocomplete="off" maxlength="256" data-name="Name 3" placeholder="ФИО*" type="text" id="name-3" required="">
                                <input class="text-field w-input" name="email" autocomplete="off" maxlength="256" data-name="Email 6" placeholder="Email*" type="email" id="email-6" required="">
                                <input class="text-field w-input" name="phone" autocomplete="off" maxlength="256" data-name="Phone 2" placeholder="Номер телефона" type="tel" id="phone-2" required="">
                                <textarea class="text-field text-area w-input" name="message" autocomplete="off" maxlength="5000" data-name="Message 2" placeholder="Ваш вопрос…" id="message-2"></textarea>
                                <div class="checkbox-wrap">
                                    <label class="w-checkbox subscribe-checkbox black">
                                        <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                                        <input type="checkbox" name="agree-2" id="agree-2" data-name="Agree 2" style="opacity:0;position:absolute;z-index:-1" checked="">
                                        <span class="subscribe-checkbox-label w-form-label" for="agree-2">
                                            Соглашаюсь с&nbsp;<a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link black">правилами <a href="privacy" target="_blank">политики конфиденциальности</a> в&nbsp;отношении персональных&nbsp;данных</a>
                                        </span>
                                    </label>
                                </div>
                                <input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Отправить">
                            </form>
                            <div class="success-message w-form-done" tabindex="-1" role="region" aria-label="Question Form success"><img src="images/success-icon.svg" loading="lazy" alt="" class="success-icon">
                                <div>Ваш вопрос отправлен!</div>
                                <a href="#" class="close-popup-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="" class="x-icon"></a>
                            </div>
                            <div class="error-message w-form-fail" tabindex="-1" role="region" aria-label="Question Form failure">
                                <div>В форме обнаружены ошибки</div>
                            </div>
                        </div>
                    </div>
                    <div class="side-footer">
                        <div class="subscribe">
                            <div class="share">
                                <div class="subscribe-head-label">Поделиться мероприятием</div>
                                <div class="share-buttons a2a_kit" style="line-height: 16px;">
                                    <a href="/#vk" class="share-button a2a_button_vk w-inline-block" target="_blank" rel="nofollow noopener">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path>
                                            </svg></div>
                                    </a>
                                    <a href="/#odnoklassniki" class="share-button a2a_button_odnoklassniki w-inline-block" target="_blank" rel="nofollow noopener">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm2.88 16.586a5.597 5.597 0 0 1-5.76 0 1.278 1.278 0 0 0-1.727.38 1.185 1.185 0 0 0 .392 1.668 8.188 8.188 0 0 0 2.484.993l-2.391 2.308a1.18 1.18 0 0 0 0 1.71c.245.237.565.355.886.355.32 0 .642-.118.887-.354L16 21.377l2.35 2.269a1.284 1.284 0 0 0 1.772 0 1.18 1.18 0 0 0 0-1.71l-2.391-2.31a8.175 8.175 0 0 0 2.483-.992 1.185 1.185 0 0 0 .393-1.668 1.279 1.279 0 0 0-1.728-.38zM15.99 8c-2.36 0-4.278 1.852-4.278 4.13 0 2.275 1.918 4.127 4.277 4.127 2.36 0 4.277-1.852 4.277-4.128C20.266 9.852 18.348 8 15.99 8zm0 2.42c.976 0 1.77.766 1.77 1.71 0 .941-.794 1.708-1.77 1.708-.977 0-1.772-.767-1.772-1.709 0-.943.795-1.71 1.771-1.71z" fill="currentColor" fill-rule="evenodd"></path>
                                            </svg></div>
                                    </a>
                                    <a href="/#telegram" class="share-button a2a_button_telegram w-inline-block" target="_blank" rel="nofollow noopener">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                                            </svg></div>
                                    </a>
                                    <a href="/#whatsapp" class="share-button a2a_button_whatsapp w-inline-block" target="_blank" rel="nofollow noopener">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M27.314 4.686c6.248 6.249 6.248 16.38 0 22.628-6.249 6.248-16.38 6.248-22.628 0-6.248-6.249-6.248-16.38 0-22.628 6.249-6.248 16.38-6.248 22.628 0zm-10.787 1.18c-5.244 0-9.512 4.268-9.514 9.514 0 1.677.437 3.314 1.27 4.757l-1.35 4.93 5.044-1.323a9.506 9.506 0 0 0 4.546 1.158c5.25-.002 9.516-4.27 9.518-9.514a9.456 9.456 0 0 0-2.784-6.731 9.453 9.453 0 0 0-6.73-2.79zm.003 1.608c2.113 0 4.098.824 5.591 2.319a7.86 7.86 0 0 1 2.314 5.594c-.002 4.36-3.55 7.908-7.908 7.908a7.899 7.899 0 0 1-4.028-1.102l-.288-.172-2.993.785.798-2.918-.188-.299a7.889 7.889 0 0 1-1.209-4.208c.002-4.36 3.55-7.907 7.911-7.907zm-3.371 3.512a.873.873 0 0 0-.634.298l-.17.185c-.269.307-.662.862-.662 1.798 0 1.024.652 2.017.895 2.356l.325.453c.543.736 1.916 2.421 3.812 3.24.567.245 1.01.391 1.355.5.57.182 1.088.156 1.497.095.457-.068 1.407-.575 1.605-1.13.198-.556.198-1.032.138-1.13-.033-.058-.1-.101-.195-.15l-1.15-.564a13.69 13.69 0 0 0-.735-.338c-.217-.08-.376-.119-.534.119-.159.238-.614.773-.753.932-.123.141-.247.172-.44.094l-.075-.034c-.238-.12-1.004-.37-1.912-1.18-.707-.63-1.184-1.41-1.322-1.647-.111-.19-.054-.311.034-.412l.07-.073c.107-.107.238-.278.356-.417.12-.139.159-.238.238-.396a.415.415 0 0 0 .004-.365l-.085-.19c-.149-.352-.507-1.23-.672-1.627-.141-.34-.284-.397-.408-.406l-.126-.002a9.442 9.442 0 0 0-.456-.009z" fill="currentColor" fill-rule="evenodd"></path>
                                            </svg></div>
                                    </a>
                                    <a href="/#copy_link" class="share-button a2a_button_copy_link w-inline-block" target="_blank" rel="nofollow noopener">
                                        <div class="card-social-icon w-embed"><svg width="100%" height="100%" viewBox="0 0 47.99996 47.99996" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <path d="M40.97054,7.02942 C50.3431,16.40198 50.3431,31.59798 40.97054,40.97054 C31.59798,50.3431 16.40198,50.3431 7.02942,40.97054 C-2.34314,31.59798 -2.34314,16.40198 7.02942,7.02942 C16.40198,-2.34314 31.59798,-2.34314 40.97054,7.02942 Z M26.7297122,21.6573315 C24.4382627,18.5908384 20.0966443,17.9643212 17.0329817,20.2582837 C16.7678212,20.4568261 16.5172292,20.6741414 16.2831332,20.9085578 L12.8136987,24.381487 C10.1425928,27.1496298 10.2187854,31.5379328 12.9699932,34.1978064 C15.6544564,36.793151 19.910824,36.7931509 22.5952871,34.1978062 L24.5871262,32.2042053 C25.0337839,31.7570977 25.0334192,31.0325577 24.5863116,30.5859 C24.1392039,30.1392423 23.414664,30.139607 22.9680063,30.5867146 L20.9903454,32.5663675 C19.2071679,34.2901071 16.3581124,34.2901071 14.5607565,32.5524197 C12.7176388,30.7704896 12.6665805,27.8297937 14.4467514,25.9847862 L17.902399,22.5259024 C18.0593226,22.368764 18.2271409,22.2232307 18.4047096,22.0902738 C20.4557829,20.5545024 23.3619805,20.9738813 24.896395,23.0272852 C25.2746973,23.5335418 25.9917739,23.6372692 26.4980305,23.258967 C27.004287,22.8806647 27.1080145,22.163588 26.7297122,21.6573315 Z M34.0300068,12.8021936 C31.3455436,10.2068489 27.0891759,10.2068491 24.4047129,12.8021941 L22.4036698,14.7934382 C21.9557105,15.2392417 21.9539629,15.9637796 22.3997664,16.4117389 C22.8455699,16.8596982 23.5701078,16.8614459 24.0180671,16.4156424 L26.0072933,14.4359895 C27.7928321,12.7098929 30.6418876,12.7098928 32.4392435,14.4475802 C34.2823612,16.2295103 34.3334195,19.1702063 32.5532484,21.0152139 L29.0976009,24.4740977 C28.9406773,24.6312361 28.772859,24.7767694 28.5952902,24.9097263 C26.544217,26.4454977 23.6380194,26.0261188 22.1036049,23.972715 C21.7253026,23.4664584 21.008226,23.362731 20.5019694,23.7410333 C19.9957129,24.1193356 19.8919855,24.8364122 20.2702877,25.3426688 C22.5617372,28.4091617 26.9033556,29.0356789 29.9670182,26.7417164 C30.2321787,26.543174 30.4827706,26.3258587 30.7168667,26.0914423 L34.1863012,22.6185131 C36.8574072,19.8503702 36.7812147,15.4620672 34.0300068,12.8021936 Z" id="Shape" fill="currentColor"></path>
                                            </svg></div>
                                    </a>
                                </div>
                                <div class="a2a-code-embed w-embed w-script">
                                    <script async="" src="https://static.addtoany.com/menu/page.js"></script>
                                </div>
                            </div>
                            <div class="subscribe-body w-form">
                                <form action="{{ route('site.form.subscribe') }}" method="post" class="form subscribe-form">
                                    @csrf
                                    <div class="subscribe-head-label">Подписаться на рассылку</div><input class="text-field w-input" autocomplete="off" maxlength="256" name="subscribe_email" data-name="subscribe_email" placeholder="Ваш Email*" type="email" id="subscribe_email"><label class="w-checkbox subscribe-checkbox">
                                        <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div><input type="checkbox" name="agree" id="agree" data-name="agree" required="" style="opacity:0;position:absolute;z-index:-1" checked=""><span class="subscribe-checkbox-label w-form-label" for="agree">Даю согласие на получение рассылки с&nbsp;сайта «Репробад» и соглашаюсь с&nbsp;<a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link">правилами политики конфиденциальности в&nbsp;отношении персональных&nbsp;данных</a></span>
                                    </label><input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Подписаться">
                                </form>
                                <div class="subscribe-success w-form-done" tabindex="-1" role="region" aria-label="Subscribe Form success"><img src="images/success-icon.svg" loading="lazy" alt="" class="success-icon">
                                    <div>Вы успешно подписались <br>на рассылку!</div>
                                </div>
                                <div class="error-message mt-0 w-form-fail" tabindex="-1" role="region" aria-label="Subscribe Form failure">
                                    <div>Oops! Something went wrong while submitting the form.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
