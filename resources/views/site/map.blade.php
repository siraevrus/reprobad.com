@extends('site.layouts.base')

@section('content')
    <section class="section map-section">
        <div class="container">
            <div class="inner-repro-head">
                <h1 class="inner-repro-h1"><span class="sistema-repro-semibold">Купить СИСТЕМУ РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="inline-text-block">в ближайшей к вам аптеке</span></h1>
                <div class="map-search-wrap">
                    <input name="search" placeholder="Ваш адрес" class="map-search">
                    <div class="suggest-view">
                        <!-- Список подсказок будет здесь -->
                    </div>
                </div>
            </div>
            <div class="map-wrap">
                <div id="map" class="map-container"></div>
                <div class="map-info-overlay"></div>
                <div id="map-info" class="map-info" style="display: none;">
                    <a href="#" class="map-info-close-button w-inline-block">
                        <img src="images/x.svg" loading="lazy" alt="" class="map-info-close-icon">
                    </a>
                    <img src="images/enc.png" id="place-logo" loading="lazy" alt="" class="map-info-logo">
                    <div class="place-title" id="place-title">Аптека при клинике «Доктор Озон»</div>
                    <div class="place-subtitle" id="place-subtitle">на Бульваре Дм. Донского</div>
                    <div class="place-address" id="place-address">г. Москва, ул. Старокачаловская, д. 6</div>
                    <div class="place-metro-wrap"><img src="images/M.svg" loading="lazy" width="14" alt="" class="metro-logo">
                        <div class="place-metro" id="place-metro">Бульвар Дмитрия Донского, Улица Старокачаловская</div>
                    </div>
                    <div class="place-text" id="place-text">В медцентре «Доктор Озон» клиенты могут получить медицинское обслуживание по таким профилям, как кардиология, терапия, маммология, эндокринология, трихология, отоларингология, косметология, офтальмология.</div>
                    <div class="map-info-contacts">
                        <div class="map-info-contacts-col">
                            <a href="#" class="place-phone" id="place-phone">8 (495) 135-38-48</a>
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
                                <div class="map-info-work-day" id="place-days">пн-пт</div>
                                <div class="map-info-work-hours" id="place-time">7:00 - 21:00</div>
                            </div>
                        </div>
                    </div>
                    <a href="#" id="place-site" target="_blank" class="map-info-button w-button">Сайт аптеки —&gt;</a>
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
            var placemarks = {!! $resources !!};

            var mapPlacemarks = [];

            // Функция для добавления маркера на карту
            function addPlacemark(placemark) {
                var myPlacemark = new ymaps.Placemark(placemark.coordinates, {
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
                    document.getElementById('place-phone').innerText = placemark.phone;
                    document.getElementById('place-time').innerText = placemark.time;
                    document.getElementById('place-site').setAttribute('href', placemark.site);
                    document.getElementById('place-logo').setAttribute('src', placemark.image);

                    if(!placemark.site) document.getElementById('place-site').style.display = 'none';
                    if(!placemark.phone) document.getElementById('place-phone').style.display = 'none';
                    if(!placemark.time) document.getElementById('place-time').style.display = 'none';
                    if(!placemark.text) document.getElementById('place-text').style.display = 'none';
                    if(!placemark.metro) document.getElementById('place-metro').style.display = 'none';
                    if(!placemark.image) document.getElementById('place-logo').style.display = 'none';

                    // Показываем карточку с информацией
                    document.getElementById('map-info').style.display = 'block';
                });

                map.geoObjects.add(myPlacemark);
                mapPlacemarks.push(myPlacemark);
            }

            // Добавляем все маркеры на карту
            placemarks.forEach(addPlacemark);

            // Функция для получения параметра search из URL
            function getSearchParam() {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('search') || ''; // Если параметр не найден, возвращаем пустую строку
            }

            // Получаем значение search из URL и фильтруем маркеры
            var searchQuery = getSearchParam();
            if (searchQuery) {
                var lowerCaseQuery = searchQuery.toLowerCase();

                // Удаляем все маркеры
                map.geoObjects.removeAll();
                mapPlacemarks = [];

                // Фильтруем маркеры и добавляем только те, которые соответствуют запросу
                placemarks.forEach(function(placemark) {
                    if (placemark.title.toLowerCase().includes(lowerCaseQuery) || placemark.address.toLowerCase().includes(lowerCaseQuery)) {
                        addPlacemark(placemark);
                    }
                });

                // Заполняем поле поиска значением из URL
                document.querySelector('.map-search').value = searchQuery;
            }

            // Фильтрация маркеров по запросу в поле ввода
            var searchInput = document.querySelector('.map-search');
            searchInput.addEventListener('input', function() {
                var query = searchInput.value.toLowerCase();

                // Удаляем все маркеры
                map.geoObjects.removeAll();
                mapPlacemarks = [];

                // Фильтруем маркеры и добавляем только те, которые соответствуют запросу
                placemarks.forEach(function(placemark) {
                    if (placemark.title.toLowerCase().includes(query) || placemark.address.toLowerCase().includes(query)) {
                        addPlacemark(placemark);
                    }
                });
            });
        });
    </script>
@endsection
