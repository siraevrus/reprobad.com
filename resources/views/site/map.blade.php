@extends('site.layouts.base')

@section('content')
    <section class="section map-section">
        <div class="container">
            <div class="inner-repro-head">
                <h1 class="inner-repro-h1"><span class="sistema-repro-semibold">Купить СИСТЕМУ РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="inline-text-block">в ближайшей к вам аптеке</span></h1>
                <div class="map-search-wrap"><input name="search" placeholder="Ваш адрес" class="map-search">
                    <div class="suggest-view">
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                        <a href="#" class="suggest-link">Link</a>
                    </div>
                </div>
            </div>
            <div class="map-wrap">
                <div id="map" class="map-container"></div>
                <div class="map-info-overlay"></div>
                <div class="map-info">
                    <a href="#" class="map-info-close-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="" class="map-info-close-icon"></a><img src="images/enc.png" loading="lazy" alt="" class="map-info-logo">
                    <div class="place-title">Аптека при клинике «Доктор Озон»</div>
                    <div class="place-subtitle">на Бульваре Дм. Донского</div>
                    <div class="place-address">г. Москва, ул. Старокачаловская, д. 6</div>
                    <div class="place-metro-wrap"><img src="images/M.svg" loading="lazy" width="14" alt="" class="metro-logo">
                        <div class="place-metro">Бульвар Дмитрия Донского, Улица Старокачаловская</div>
                    </div>
                    <div class="place-text">В медцентре «Доктор Озон» клиенты могут получить медицинское обслуживание по таким профилям, как кардиология, терапия, маммология, эндокринология, трихология, отоларингология, косметология, офтальмология.</div>
                    <div class="map-info-contacts">
                        <div class="map-info-contacts-col">
                            <a href="#" class="place-phone">8 (495) 135-38-48</a>
                            <div class="map-info-socials">
                                <a social="vkontakte" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <div class="map-info-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path>
                                        </svg></div>
                                </a>
                                <a social="odnoklassniki" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <div class="map-info-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm2.88 16.586a5.597 5.597 0 0 1-5.76 0 1.278 1.278 0 0 0-1.727.38 1.185 1.185 0 0 0 .392 1.668 8.188 8.188 0 0 0 2.484.993l-2.391 2.308a1.18 1.18 0 0 0 0 1.71c.245.237.565.355.886.355.32 0 .642-.118.887-.354L16 21.377l2.35 2.269a1.284 1.284 0 0 0 1.772 0 1.18 1.18 0 0 0 0-1.71l-2.391-2.31a8.175 8.175 0 0 0 2.483-.992 1.185 1.185 0 0 0 .393-1.668 1.279 1.279 0 0 0-1.728-.38zM15.99 8c-2.36 0-4.278 1.852-4.278 4.13 0 2.275 1.918 4.127 4.277 4.127 2.36 0 4.277-1.852 4.277-4.128C20.266 9.852 18.348 8 15.99 8zm0 2.42c.976 0 1.77.766 1.77 1.71 0 .941-.794 1.708-1.77 1.708-.977 0-1.772-.767-1.772-1.709 0-.943.795-1.71 1.771-1.71z" fill="currentColor" fill-rule="evenodd"></path>
                                        </svg></div>
                                </a>
                                <a social="telegram" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <div class="map-info-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                                        </svg></div>
                                </a>
                                <a social="whatsapp" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <div class="map-info-social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M27.314 4.686c6.248 6.249 6.248 16.38 0 22.628-6.249 6.248-16.38 6.248-22.628 0-6.248-6.249-6.248-16.38 0-22.628 6.249-6.248 16.38-6.248 22.628 0zm-10.787 1.18c-5.244 0-9.512 4.268-9.514 9.514 0 1.677.437 3.314 1.27 4.757l-1.35 4.93 5.044-1.323a9.506 9.506 0 0 0 4.546 1.158c5.25-.002 9.516-4.27 9.518-9.514a9.456 9.456 0 0 0-2.784-6.731 9.453 9.453 0 0 0-6.73-2.79zm.003 1.608c2.113 0 4.098.824 5.591 2.319a7.86 7.86 0 0 1 2.314 5.594c-.002 4.36-3.55 7.908-7.908 7.908a7.899 7.899 0 0 1-4.028-1.102l-.288-.172-2.993.785.798-2.918-.188-.299a7.889 7.889 0 0 1-1.209-4.208c.002-4.36 3.55-7.907 7.911-7.907zm-3.371 3.512a.873.873 0 0 0-.634.298l-.17.185c-.269.307-.662.862-.662 1.798 0 1.024.652 2.017.895 2.356l.325.453c.543.736 1.916 2.421 3.812 3.24.567.245 1.01.391 1.355.5.57.182 1.088.156 1.497.095.457-.068 1.407-.575 1.605-1.13.198-.556.198-1.032.138-1.13-.033-.058-.1-.101-.195-.15l-1.15-.564a13.69 13.69 0 0 0-.735-.338c-.217-.08-.376-.119-.534.119-.159.238-.614.773-.753.932-.123.141-.247.172-.44.094l-.075-.034c-.238-.12-1.004-.37-1.912-1.18-.707-.63-1.184-1.41-1.322-1.647-.111-.19-.054-.311.034-.412l.07-.073c.107-.107.238-.278.356-.417.12-.139.159-.238.238-.396a.415.415 0 0 0 .004-.365l-.085-.19c-.149-.352-.507-1.23-.672-1.627-.141-.34-.284-.397-.408-.406l-.126-.002a9.442 9.442 0 0 0-.456-.009z" fill="currentColor" fill-rule="evenodd"></path>
                                        </svg></div>
                                </a>
                            </div>
                        </div>
                        <div class="map-info-working-time">
                            <div class="map-info-work">
                                <div class="map-info-work-day">пн-пт</div>
                                <div class="map-info-work-hours">7:00 - 21:00</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" target="_blank" class="map-info-button w-button">Сайт аптеки —&gt;</a>
                </div>
            </div>
            <div class="map-objects">
                <div class="map-marker"></div>
                <div class="map-cluster">3</div>
            </div>
        </div>
    </section>
@endsection
