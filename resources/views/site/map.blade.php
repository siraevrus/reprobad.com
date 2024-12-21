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
                <div id="map-info" class="map-info" style="display: none;">
                    <a href="#" class="map-info-close-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="" class="map-info-close-icon"></a><img src="images/enc.png" loading="lazy" alt="" class="map-info-logo">
                    <div class="place-title" id="place-title">Аптека при клинике «Доктор Озон»</div>
                    <div class="place-subtitle" id="place-subtitle">на Бульваре Дм. Донского</div>
                    <div class="place-address" id="place-address">г. Москва, ул. Старокачаловская, д. 6</div>
                    <div class="place-metro-wrap"><img src="images/M.svg" loading="lazy" width="14" alt="" class="metro-logo">
                        <div class="place-metro" id="place-metro">Бульвар Дмитрия Донского, Улица Старокачаловская</div>
                    </div>
                    <div class="place-text" id="place-text">В медцентре «Доктор Озон» клиенты могут получить медицинское обслуживание по таким профилям, как кардиология, терапия, маммология, эндокринология, трихология, отоларингология, косметология, офтальмология.</div>
                    <div class="map-info-contacts">
                        <div class="map-info-contacts-col">
                            <a href="#" class="place-phone">8 (495) 135-38-48</a>
                            <div class="map-info-socials">
                                <!-- Социальные сети -->
                                <a social="vkontakte" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <!-- SVG иконка -->
                                </a>
                                <a social="odnoklassniki" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <!-- SVG иконка -->
                                </a>
                                <a social="telegram" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <!-- SVG иконка -->
                                </a>
                                <a social="whatsapp" href="#" target="_blank" class="map-info-social w-inline-block">
                                    <!-- SVG иконка -->
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

@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
        ymaps.ready(function() {
            var map = new ymaps.Map('map', {
                center: [55.7558, 37.6176], // координаты центра карты
                zoom: 10,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            });

            // Пример маркеров с информацией
            var placemarks = [
                {
                    coords: [55.7558, 37.6176],
                    title: "Аптека при клинике «Доктор Озон»",
                    subtitle: "на Бульваре Дм. Донского",
                    address: "г. Москва, ул. Старокачаловская, д. 6",
                    metro: "Бульвар Дмитрия Донского, Улица Старокачаловская",
                    text: "В медцентре «Доктор Озон» клиенты могут получить медицинское обслуживание."
                },
                {
                    coords: [55.8038, 37.5876],
                    title: "Аптека в торговом центре",
                    subtitle: "на Проспекте Мира",
                    address: "г. Москва, Проспект Мира, д. 100",
                    metro: "Проспект Мира",
                    text: "Медицинские услуги, аптека с доставкой."
                }
            ];

            placemarks.forEach(function(placemark) {
                var myPlacemark = new ymaps.Placemark(placemark.coords, {
                    hintContent: placemark.title,
                    balloonContent: placemark.title
                }, {
                    preset: 'islands#blueDotIcon'
                });

                myPlacemark.events.add('click', function() {
                    // Заполняем информацию по клику
                    document.getElementById('place-title').innerText = placemark.title;
                    document.getElementById('place-subtitle').innerText = placemark.subtitle;
                    document.getElementById('place-address').innerText = placemark.address;
                    document.getElementById('place-metro').innerText = placemark.metro;
                    document.getElementById('place-text').innerText = placemark.text;

                    // Показываем карточку с информацией
                    document.getElementById('map-info').style.display = 'block';
                });

                map.geoObjects.add(myPlacemark);
            });
        });
    </script>
@endsection
