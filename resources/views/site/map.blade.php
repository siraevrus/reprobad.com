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
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=546d45df-62e8-423a-ac02-6d7a0919c168" type="text/javascript"></script>
    <script>
        ymaps.ready(function() {
            console.log('Yandex Maps готов');
            
            var map = new ymaps.Map('map', {
                center: [55.7558, 37.6176], // координаты центра карты
                zoom: 10,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            });
            
            console.log('Карта создана:', map);

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

            // Получаем значение search из URL и центрируем карту
            var searchQuery = getSearchParam();
            if (searchQuery) {
                // Заполняем поле поиска значением из URL
                document.querySelector('.map-search').value = searchQuery;
                
                // Используем геокодер для поиска адреса из URL
                ymaps.geocode(searchQuery, {
                    results: 1
                }).then(function(res) {
                    if (res.geoObjects.getLength() > 0) {
                        var firstGeoObject = res.geoObjects.get(0);
                        var coords = firstGeoObject.geometry.getCoordinates();
                        
                        // Центрируем карту на найденном адресе и приближаем
                        map.setCenter(coords, 15);
                        
                        // Добавляем маркер на найденный адрес
                        var searchPlacemark = new ymaps.Placemark(coords, {
                            hintContent: firstGeoObject.getAddressLine(),
                            balloonContent: firstGeoObject.getAddressLine()
                        }, {
                            preset: 'islands#redDotIcon'
                        });
                        
                        map.geoObjects.add(searchPlacemark);
                        window.searchPlacemark = searchPlacemark;
                    }
                });
            }

            // Поиск и центрирование карты по адресу
            var searchInput = document.querySelector('.map-search');
            console.log('Поле поиска найдено:', searchInput);
            
            if (!searchInput) {
                console.error('Поле поиска не найдено!');
                return;
            }
            
            var searchTimeout;
            
            searchInput.addEventListener('input', function() {
                var query = searchInput.value.trim();
                console.log('Поиск:', query);
                
                // Очищаем предыдущий таймаут
                clearTimeout(searchTimeout);
                
                // Добавляем небольшую задержку для оптимизации
                searchTimeout = setTimeout(function() {
                    if (query.length >= 3) {
                        console.log('Начинаем геокодирование для:', query);
                        
                        // Используем геокодер Яндекса для поиска адреса
                        ymaps.geocode(query, {
                            results: 1
                        }).then(function(res) {
                            console.log('Результат геокодирования:', res);
                            
                            if (res.geoObjects.getLength() > 0) {
                                var firstGeoObject = res.geoObjects.get(0);
                                var coords = firstGeoObject.geometry.getCoordinates();
                                console.log('Найденные координаты:', coords);
                                
                                // Центрируем карту на найденном адресе и приближаем
                                map.setCenter(coords, 15);
                                
                                // Добавляем маркер на найденный адрес
                                var searchPlacemark = new ymaps.Placemark(coords, {
                                    hintContent: firstGeoObject.getAddressLine(),
                                    balloonContent: firstGeoObject.getAddressLine()
                                }, {
                                    preset: 'islands#redDotIcon'
                                });
                                
                                // Удаляем предыдущий маркер поиска если есть
                                if (window.searchPlacemark) {
                                    map.geoObjects.remove(window.searchPlacemark);
                                }
                                
                                // Добавляем новый маркер поиска
                                map.geoObjects.add(searchPlacemark);
                                window.searchPlacemark = searchPlacemark;
                                
                                console.log('Карта центрирована на:', firstGeoObject.getAddressLine());
                            } else {
                                console.log('Адрес не найден');
                            }
                        }).catch(function(error) {
                            console.error('Ошибка геокодирования:', error);
                        });
                    } else if (query.length === 0) {
                        console.log('Очищаем поиск');
                        // Если поле пустое, удаляем маркер поиска
                        if (window.searchPlacemark) {
                            map.geoObjects.remove(window.searchPlacemark);
                            window.searchPlacemark = null;
                        }
                    }
                }, 500); // Задержка 500мс
            });
        });
    </script>
@endsection
