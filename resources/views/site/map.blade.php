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
        "@id": "{{ route('site.map') }}",
        "name": "Карта"
      }
    }
  ]
}
</script>
@php
    $lb = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => 'Система РЕПРО',
        'url' => config('app.url'),
        'logo' => config('app.url') . '/images/lgog-gold.svg',
    ];
    if (config('address')) {
        $lb['address'] = ['@type' => 'PostalAddress', 'streetAddress' => config('address')];
    }
    if (config('phone') || config('phone2')) {
        $lb['telephone'] = config('phone2') ?: config('phone');
    }
    if (config('email')) {
        $lb['email'] = config('email');
    }
@endphp
<script type="application/ld+json">
{!! json_encode($lb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
<style>
    /* Базовые стили для карты */
    #map {
        height: 650px !important;
        width: 100% !important;
        min-height: 400px;
    }
    .map-container {
        height: 400px !important;
        width: 100% !important;
        min-height: 400px;
    }
    .map-wrap {
        position: relative;
        min-height: 400px;
    }

    .map-tabs-content {
        min-height: 500px;
    }

    .map-list-row {
        border-top: 0 !important;
    }

    .map-info {
        display: none !important;
        
    }
    
    .map-info.show {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    .map-info-overlay {
        display: none !important;
        pointer-events: none !important;
        background: transparent !important;
    }

    /* .map-section {
        background: #e6eff2;
    } */
    
    /* Стили для правильного переключения вкладок */
    .w-tab-pane {
        display: none;
        opacity: 0;
        transition: all, opacity 300ms;
    }
    .w-tab-pane.w--tab-active {
        display: block !important;
        opacity: 1 !important;
        transition: all, opacity 300ms !important;
    }
    
    /* ВАЖНО: Принудительные стили для кликабельности */
    .map-tabs-link {
        cursor: pointer !important;
        pointer-events: auto !important;
        user-select: none !important;
        transition: all 0.3s ease;
        position: relative !important;
        z-index: 10 !important;
    }
    .map-tabs-link:hover {
        background-color: rgba(133, 119, 183, 0.1) !important;
        transform: scale(1.02) !important;
    }
    .map-tabs-link.w--current {
        background-color: rgba(133, 119, 183, 0.2) !important;
        color: #8577B7 !important;
        font-weight: 600 !important;
    }
    
    /* Дополнительные стили для надежности */
    .map-tabs-menu {
        z-index: 5 !important;
    }
    .map-tabs-label {
        pointer-events: none !important; /* Предотвращаем конфликты с вложенными элементами */
    }
</style>
@endsection

@section('content')
    <section class="section map-section" style="max-width:100%">
        <div class="container">
            <div class="inner-repro-head">
                <h1 class="inner-repro-h1"><span class="sistema-repro-semibold">Купить СИСТЕМУ РЕПР</span><span class="o-span"><strong>О</strong></span> <span class="inline-text-block">в ближайшей к вам аптеке</span></h1>
            </div>
            <div data-current="Список" data-easing="ease" data-duration-in="300" data-duration-out="100" class="map-tabs w-tabs">
                <div class="map-tabs-menu w-tab-menu">
                    <a data-w-tab="Список" class="map-tabs-link w-inline-block w-tab-link w--current">
                        <div class="map-tabs-label">Список</div>
                    </a>
                    <a data-w-tab="Карта" class="map-tabs-link w-inline-block w-tab-link">
                        <div class="map-tabs-label">Карта</div>
                    </a>
                </div>
                <div class="map-tabs-content w-tab-content">
                    <div data-w-tab="Список" class="w-tab-pane w--tab-active">
                        <div class="map-list-heading">
                            <div>Аптека в </div>
                            <div data-delay="0" data-hover="true" class="map-city-dropdown w-dropdown">
                                <div class="map-city-dropdown-toggle w-dropdown-toggle">
                                    <div id="selected-city">г. Москва</div>
                                    <div class="map-city-dropdown-icon w-icon-dropdown-toggle"></div>
                                </div>
                                <nav class="map-city-navigation w-dropdown-list">
                                    <a href="#" class="map-city-link w-dropdown-link" data-city="Все города">Все города</a>
                                    @if(isset($cities) && $cities->count() > 0)
                                        @foreach($cities as $city)
                                            <a href="#" class="map-city-link w-dropdown-link" data-city="{{ $city }}">{{ $city }}</a>
                                        @endforeach
                                    @else
                                        <a href="#" class="map-city-link w-dropdown-link" data-city="Москва">Москва</a>
                                        <a href="#" class="map-city-link w-dropdown-link" data-city="СПб">СПб</a>
                                    @endif
                                </nav>
                            </div>
                        </div>
                        <div class="map-list map-list-head">
                            <div class="map-list-row map-list-head-row">
                                <div class="map-list-cell apteka-cell">Аптека</div>
                                <div class="map-list-cell">Адрес</div>
                                <div class="map-list-cell phone-cell">‍Телефон</div>
                            </div>
                        </div>
                        <div class="map-list">
                            @php
                                // Преобразуем JSON строку в массив если нужно
                                $resourcesArray = [];
                                if (isset($resources)) {
                                    if (is_string($resources)) {
                                        $resourcesArray = json_decode($resources, true) ?? [];
                                    } elseif (is_array($resources)) {
                                        $resourcesArray = $resources;
                                    }
                                }
                            @endphp
                            
                            @if(!empty($resourcesArray))
                                @foreach($resourcesArray as $placemark)
                                    <div class="map-list-row">
                                        <div class="map-list-cell apteka-cell"><strong>{{ $placemark['title'] ?? 'Аптека' }}</strong></div>
                                        <div class="map-list-cell">{{ $placemark['address'] ?? 'Адрес не указан' }}</div>
                                        <div class="map-list-cell phone-cell">
                                            @if(isset($placemark['phone']) && $placemark['phone'])
                                                <a href="tel:{{ $placemark['phone'] }}" class="map-list-phone-link">{{ $placemark['phone'] }}</a>
                                            @else
                                                <span class="map-list-phone-link">Телефон не указан</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="map-list-row">
                                    <div class="map-list-cell apteka-cell"><strong>Нет данных</strong></div>
                                    <div class="map-list-cell">Список аптек пуст</div>
                                    <div class="map-list-cell phone-cell">
                                        <span class="map-list-phone-link">-</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div data-w-tab="Карта" class="map-tab-pane w-tab-pane">
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
                        <div class="map-wrap">
                            <div id="map" class="map-container"></div>
                            <div class="map-info-overlay"></div>
                            <div class="map-info">
                                <a href="#" class="map-info-close-button w-inline-block"><img loading="lazy" src="images/x.svg" alt="" class="map-info-close-icon"></a><img loading="lazy" src="images/enc.png" alt="" class="map-info-logo">
                                <div class="place-title">Аптека при клинике «Доктор Озон»</div>
                                <div class="place-subtitle">на Бульваре Дм. Донского</div>
                                <div class="place-address">г. Москва, ул. Старокачаловская, д. 6</div>
                                <div class="place-metro-wrap"><img width="14" loading="lazy" alt="" src="images/M.svg" class="metro-logo">
                                    <div class="place-metro">Бульвар Дмитрия Донского, Улица Старокачаловская</div>
                                </div>
                                <div class="place-text">В медцентре «Доктор Озон» клиенты могут получить медицинское обслуживание по таким профилям, как кардиология, терапия, маммология, эндокринология, трихология, отоларингология, косметология, офтальмология.</div>
                                <div class="map-info-contacts">
                                    <div class="map-info-contacts-col">
                                        <a href="#" class="place-phone">8 (495) 135-38-48</a>
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
                    </div>
                </div>
            </div>
            <div class="map-objects">
                <div class="map-marker"></div>
                <div class="map-cluster">3</div>
            </div>
        </div>
    </section>
    <div class="page-background blue"></div>
@endsection

@section('scripts')
    <!-- jQuery и Webflow для корректной работы табов -->
    <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=673718a9aa664236cdc0b633" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/webflow@1.0.0/dist/js/webflow.min.js" type="text/javascript"></script>
    <!-- Yandex Maps API v2.1 - оставляем стабильную версию -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script>
        // Первоначальная реализация переключения вкладок (усиленная)
        function initTabSwitching() {
            console.log('Инициализируем переключение вкладок (усиленная версия)');
            
            // Множественные селекторы для надежности
            var tabSelectors = [
                '.map-tabs-link',
                'a[data-w-tab]',
                '.w-tab-link',
                'a.map-tabs-link.w-inline-block.w-tab-link'
            ];
            
            var tabLinks = [];
            tabSelectors.forEach(function(selector) {
                var elements = document.querySelectorAll(selector);
                elements.forEach(function(el) {
                    if (tabLinks.indexOf(el) === -1) {
                        tabLinks.push(el);
                    }
                });
            });
            
            var tabPanes = document.querySelectorAll('.w-tab-pane, [data-w-tab].w-tab-pane');
            
            console.log('Найдено ссылок вкладок:', tabLinks.length);
            console.log('Найдено панелей вкладок:', tabPanes.length);
            
            // Принудительное присвоение обработчиков
            tabLinks.forEach(function(link, index) {
                console.log('Настраиваем обработчик для ссылки', index + 1, link);
                
                // Удаляем старые обработчики
                link.removeEventListener('click', handleTabClick);
                
                // Множественные события для надежности
                ['click', 'mousedown', 'touchstart'].forEach(function(eventType) {
                    link.addEventListener(eventType, handleTabClick, { passive: false, capture: true });
                });
                
                // Принудительно макем элемент кликабельным
                link.style.cursor = 'pointer';
                link.style.pointerEvents = 'auto';
                link.style.userSelect = 'none';
                link.tabIndex = 0; // Для доступности
            });
        }
        
        function handleTabClick(e) {
            // Обрабатываем click и touchstart (для мобильных), все остальные события игнорируем
            if (e.type !== 'click' && e.type !== 'touchstart') {
                return;
            }

            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            
            var targetTab = this.getAttribute('data-w-tab');
            console.log('Клик по вкладке:', targetTab, 'Тип события:', e.type);
            
            if (!targetTab) {
                console.warn('Не найден атрибут data-w-tab');
                return;
            }
            
            // Получаем все вкладки и панели
            var allTabLinks = document.querySelectorAll('.map-tabs-link, a[data-w-tab], .w-tab-link');
            var allTabPanes = document.querySelectorAll('.w-tab-pane, [data-w-tab].w-tab-pane');
            
            // Убираем активные классы со всех ссылок
            allTabLinks.forEach(function(tab) {
                tab.classList.remove('w--current');
            });
            
            // Скрываем все панели с удалением стилей и классов
            allTabPanes.forEach(function(pane) {
                pane.classList.remove('w--tab-active');
                pane.style.opacity = '0';
                pane.style.transition = '';
                pane.style.display = 'none';
            });
            
            // Активируем текущую ссылку
            this.classList.add('w--current');
            
            // Показываем целевую панель с правильными стилями
            var targetPane = document.querySelector('[data-w-tab="' + targetTab + '"].w-tab-pane');
            if (targetPane) {
                // Сначала показываем элемент
                targetPane.style.display = 'block';
                
                // Добавляем класс w--tab-active
                targetPane.classList.add('w--tab-active');
                
                // Устанавливаем точные стили как в спецификации
                targetPane.style.opacity = '1';
                targetPane.style.transition = 'all, opacity 300ms';
                
                console.log('Панель активирована:', targetTab, 'Стили применены: opacity: 1; transition: all, opacity 300ms;');
            } else {
                console.error('Не найдена панель для:', targetTab);
            }
            
            // Обновляем карту при переключении на карту
            if (targetTab === 'Карта' && window.mapInstance) {
                setTimeout(function() {
                    console.log('Обновляем размер карты');
                    window.mapInstance.container.fitToViewport();
                    ensureMapVisibility();
                }, 400);
            } else if (targetTab === 'Карта') {
                ensureMapVisibility();
            }
        }

        function ensureMapVisibility() {
            var mapElement = document.getElementById('map');
            if (!mapElement) return;

            var desiredHeight = window.innerWidth < 768 ? Math.max(window.innerHeight * 0.65, 360) : 600;
            mapElement.style.minHeight = desiredHeight + 'px';
            mapElement.style.height = desiredHeight + 'px';
            mapElement.style.width = '100%';

            // Чтобы на мобильных карта была видна сразу
            mapElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
        
        // Множественная инициализация
        document.addEventListener('DOMContentLoaded', initTabSwitching);
        
        // Повторная инициализация через некоторое время
        setTimeout(initTabSwitching, 500);
        setTimeout(initTabSwitching, 1000);
        
        // Webflow дублирующий обработчик (если Webflow загрузится)
        $(document).ready(function() {
            setTimeout(initTabSwitching, 100);
            
            $(document).on('click', '[data-w-tab="Карта"]', function() {
                setTimeout(function() {
                    if (window.mapInstance) {
                        window.mapInstance.container.fitToViewport();
                    }
                }, 300);
            });
            
            // Фильтрация по городам
            $('.map-city-link').on('click', function(e) {
                e.preventDefault();
                var selectedCity = $(this).data('city');
                console.log('Выбран город:', selectedCity);
                
                // Обновляем текст в dropdown
                $('#selected-city').text(selectedCity);
                
                // Фильтруем список аптек
                filterPharmaciesByCity(selectedCity);
                
                // Фильтруем маркеры на карте
                if (window.mapInstance && window.placemarks) {
                    filterMapMarkersByCity(selectedCity);
                }
            });
        });
        
        // Функция фильтрации списка аптек по городу
        function filterPharmaciesByCity(selectedCity) {
            var $pharmacyRows = $('.map-list .map-list-row');
            
            if (selectedCity === 'Все города') {
                // Показываем все аптеки
                $pharmacyRows.show();
                console.log('Показаны все аптеки');
            } else {
                // Скрываем все ряды
                $pharmacyRows.hide();
                
                // Показываем только те, которые содержат выбранный город
                $pharmacyRows.each(function() {
                    var addressText = $(this).find('.map-list-cell:nth-child(2)').text();
                    if (addressText.toLowerCase().includes(selectedCity.toLowerCase())) {
                        $(this).show();
                    }
                });
                
                console.log('Показаны аптеки для города:', selectedCity);
            }
        }
        
        // Функция фильтрации маркеров на карте
        function filterMapMarkersByCity(selectedCity) {
            if (!window.mapPlacemarks || !window.placemarks) {
                console.log('Маркеры еще не загружены');
                return;
            }
            
            // Удаляем все маркеры
            window.mapPlacemarks.forEach(function(marker) {
                window.mapInstance.geoObjects.remove(marker);
            });
            window.mapPlacemarks = [];
            
            // Добавляем отфильтрованные маркеры
            window.placemarks.forEach(function(placemark) {
                var showMarker = false;
                
                if (selectedCity === 'Все города') {
                    showMarker = true;
                } else if (placemark.city && placemark.city.toLowerCase().includes(selectedCity.toLowerCase())) {
                    showMarker = true;
                } else if (placemark.address && placemark.address.toLowerCase().includes(selectedCity.toLowerCase())) {
                    showMarker = true;
                }
                
                if (showMarker) {
                    window.addPlacemark(placemark);
                }
            });
            
            console.log('Обновлены маркеры для города:', selectedCity);
        }

        ymaps.ready(function() {
            console.log('Yandex Maps готов');
            
            // Инициализируем карту с API v2.1
            var map = new ymaps.Map('map', {
                center: [55.7558, 37.6176], // координаты центра карты
                zoom: 10,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            });
            
            // Сохраняем ссылку на карту
            window.mapInstance = map;
            
            console.log('Карта создана:', map);

            // Пример маркеров с информацией (глобальные переменные)
            window.placemarks = {!! $resources ?? '[]' !!};
            window.mapPlacemarks = [];

            // Функция для добавления маркера на карту (глобальная)
            window.addPlacemark = function(placemark) {
                console.log('Добавляем маркер:', placemark);
                
                var myPlacemark = new ymaps.Placemark(placemark.coordinates, {
                    hintContent: placemark.title,
                    balloonContent: placemark.title
                }, {
                    preset: 'islands#blueDotIcon'
                });

                myPlacemark.events.add('click', function() {
                    console.log('Клик по метке:', placemark.title);
                    
                    // Заполняем информацию по клику
                    var placeTitle = document.querySelector('.place-title');
                    var placeSubtitle = document.querySelector('.place-subtitle');
                    var placeAddress = document.querySelector('.place-address');
                    var placeMetro = document.querySelector('.place-metro');
                    var placeText = document.querySelector('.place-text');
                    var placePhone = document.querySelector('.place-phone');
                    var mapInfoButton = document.querySelector('.map-info-button');
                    var mapInfoLogo = document.querySelector('.map-info-logo');
                    var placeMetroWrap = document.querySelector('.place-metro-wrap');
                    
                    if (placeTitle) placeTitle.innerText = placemark.title || '';
                    if (placeSubtitle) placeSubtitle.innerText = placemark.subtitle || '';
                    if (placeAddress) placeAddress.innerText = placemark.address || '';
                    if (placeMetro) placeMetro.innerText = placemark.metro || '';
                    if (placeText) placeText.innerText = placemark.text || '';
                    if (placePhone) {
                        placePhone.innerText = placemark.phone || '';
                        placePhone.setAttribute('href', 'tel:' + (placemark.phone || ''));
                    }
                    if (mapInfoButton) mapInfoButton.setAttribute('href', placemark.site || '#');
                    if (mapInfoLogo) mapInfoLogo.setAttribute('src', placemark.image || '');

                    // Показать/скрыть элементы в зависимости от наличия данных
                    if (mapInfoButton) {
                        if(!placemark.site) mapInfoButton.style.display = 'none';
                        else mapInfoButton.style.display = 'block';
                    }
                    
                    if (placePhone) {
                        if(!placemark.phone) placePhone.style.display = 'none';
                        else placePhone.style.display = 'block';
                    }
                    
                    if (placeText) {
                        if(!placemark.text) placeText.style.display = 'none';
                        else placeText.style.display = 'block';
                    }
                    
                    if (placeMetroWrap) {
                        if(!placemark.metro) placeMetroWrap.style.display = 'none';
                        else placeMetroWrap.style.display = 'block';
                    }
                    
                    if (mapInfoLogo) {
                        if(!placemark.image) mapInfoLogo.style.display = 'none';
                        else mapInfoLogo.style.display = 'block';
                    }

                    // Показываем карточку с информацией (принудительно)
                    var mapInfoBlock = document.querySelector('.map-info');
                    if (mapInfoBlock) {
                        console.log('Найден элемент .map-info:', mapInfoBlock);
                        console.log('Текущие стили перед изменением:', {
                            display: mapInfoBlock.style.display,
                            visibility: mapInfoBlock.style.visibility,
                            opacity: mapInfoBlock.style.opacity,
                            zIndex: mapInfoBlock.style.zIndex
                        });
                        
                        // Удаляем классы, которые могут мешать
                        mapInfoBlock.classList.remove('hidden');
                        
                        // Устанавливаем стили напрямую
                        mapInfoBlock.style.setProperty('display', 'block', 'important');
                        
                        // Добавляем класс для показа
                        mapInfoBlock.classList.add('show');
                        
                        console.log('Стили после изменения:', {
                            display: mapInfoBlock.style.display,
                            visibility: mapInfoBlock.style.visibility,
                            opacity: mapInfoBlock.style.opacity,
                            zIndex: mapInfoBlock.style.zIndex,
                            classList: mapInfoBlock.classList.toString()
                        });
                        
                        console.log('Карточка с информацией отображена!');
                    } else {
                        console.error('Элемент .map-info не найден!');
                        // Попробуем найти все элементы с map-info
                        var allMapInfos = document.querySelectorAll('*[class*="map-info"]');
                        console.log('Найдено элементов с map-info:', allMapInfos.length, allMapInfos);
                    }
                });

                window.mapInstance.geoObjects.add(myPlacemark);
                window.mapPlacemarks.push(myPlacemark);
                
                return myPlacemark;
            }

            // Добавляем все маркеры на карту
            if (window.placemarks && window.placemarks.length) {
                window.placemarks.forEach(window.addPlacemark);
            }

            // Функция для получения параметра search из URL
            function getSearchParam() {
                var urlParams = new URLSearchParams(window.location.search);
                return urlParams.get('search') || ''; // Если параметр не найден, возвращаем пустую строку
            }

            // Получаем значение search из URL и ищем среди маркеров
            var searchQuery = getSearchParam();
            if (searchQuery) {
                // Заполняем поле поиска значением из URL
                var searchInput = document.querySelector('.map-search');
                if (searchInput) {
                    searchInput.value = searchQuery;
                    // Ищем среди существующих маркеров
                    searchInExistingMarkers(searchQuery);
                }
            }

            // Поиск и центрирование карты по адресу
            var searchInput = document.querySelector('.map-search');
            console.log('Поле поиска найдено:', searchInput);
            
            if (!searchInput) {
                console.error('Поле поиска не найдено!');
                return;
            }
            
            var searchTimeout;
            var lastSearchQuery = '';
            
            // Debounce функция для предотвращения спама API
            function debounce(func, delay) {
                return function() {
                    var context = this;
                    var args = arguments;
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function() {
                        func.apply(context, args);
                    }, delay);
                };
            }
            
            // Функция поиска по существующим маркерам
            function searchInExistingMarkers(query) {
                // Проверяем, не тот ли же запрос мы уже обрабатывали
                if (query === lastSearchQuery) {
                    console.log('Запрос уже обработан:', query);
                    return;
                }
                
                lastSearchQuery = query;
                console.log('Ищем среди существующих маркеров:', query);
                console.log('Доступные маркеры:', window.placemarks);
                
                var foundMarkers = [];
                var lowerQuery = query.toLowerCase();
                
                // Ищем среди существующих маркеров
                if (window.placemarks && window.placemarks.length) {
                    window.placemarks.forEach(function(placemark) {
                        var titleMatch = placemark.title && placemark.title.toLowerCase().includes(lowerQuery);
                        var addressMatch = placemark.address && placemark.address.toLowerCase().includes(lowerQuery);
                        var subtitleMatch = placemark.subtitle && placemark.subtitle.toLowerCase().includes(lowerQuery);
                        
                        if (titleMatch || addressMatch || subtitleMatch) {
                            foundMarkers.push(placemark);
                        }
                    });
                }
                
                if (foundMarkers.length > 0) {
                    console.log('Найдено маркеров:', foundMarkers.length);
                    
                    // Берем первый найденный маркер
                    var foundPlacemark = foundMarkers[0];
                    var coords = foundPlacemark.coordinates;
                    
                    // Центрируем карту на найденном маркере
                    map.setCenter(coords, 15);
                    
                    // Добавляем маркер поиска
                    var searchPlacemark = new ymaps.Placemark(coords, {
                        hintContent: 'Найдено: ' + foundPlacemark.title,
                        balloonContent: foundPlacemark.title + '<br>' + foundPlacemark.address
                    }, {
                        preset: 'islands#redDotIcon'
                    });
                    
                    if (window.searchPlacemark) {
                        map.geoObjects.remove(window.searchPlacemark);
                    }
                    
                    map.geoObjects.add(searchPlacemark);
                    window.searchPlacemark = searchPlacemark;
                    
                    // Показываем информацию о найденном месте
                    document.querySelector('.place-title').innerText = foundPlacemark.title || '';
                    document.querySelector('.place-subtitle').innerText = foundPlacemark.subtitle || '';
                    document.querySelector('.place-address').innerText = foundPlacemark.address || '';
                    document.querySelector('.place-metro').innerText = foundPlacemark.metro || '';
                    document.querySelector('.place-text').innerText = foundPlacemark.text || '';
                    document.querySelector('.place-phone').innerText = foundPlacemark.phone || '';
                    
                    if (foundPlacemark.site) {
                        document.querySelector('.map-info-button').setAttribute('href', foundPlacemark.site);
                        document.querySelector('.map-info-button').style.display = 'block';
                    } else {
                        document.querySelector('.map-info-button').style.display = 'none';
                    }
                    
                    if (foundPlacemark.image) {
                        document.querySelector('.map-info-logo').setAttribute('src', foundPlacemark.image);
                        document.querySelector('.map-info-logo').style.display = 'block';
                    } else {
                        document.querySelector('.map-info-logo').style.display = 'none';
                    }
                    
                    // Показываем карточку с информацией
                    var mapInfoBlock = document.querySelector('.map-info');
                    if (mapInfoBlock) {
                        mapInfoBlock.style.setProperty('display', 'block', 'important');
                        mapInfoBlock.classList.add('show');
                    }
                    
                } else {
                    console.log('Среди существующих маркеров не найдено');
                    // Показываем сообщение пользователю
                    alert('Адрес не найден среди аптек. Попробуйте другой запрос.');
                }
            }
            
            // Создаем debounced версию функции поиска
            var debouncedSearch = debounce(function(query) {
                if (query.length >= 2) {
                    console.log('Начинаем поиск для:', query);
                    searchInExistingMarkers(query);
                } else if (query.length === 0) {
                    console.log('Очищаем поиск');
                    lastSearchQuery = '';
                    // Если поле пустое, удаляем маркер поиска и скрываем карточку
                    if (window.searchPlacemark) {
                        map.geoObjects.remove(window.searchPlacemark);
                        window.searchPlacemark = null;
                    }
                    var mapInfoBlock = document.querySelector('.map-info');
                    if (mapInfoBlock) {
                        mapInfoBlock.classList.remove('show');
                        mapInfoBlock.style.setProperty('display', 'none', 'important');
                    }
                }
            }, 1000);
            
            searchInput.addEventListener('input', function() {
                var query = searchInput.value.trim();
                console.log('Поиск (input):', query);
                
                // Используем debounced функцию
                debouncedSearch(query);
            });

            // Закрытие карточки с информацией
            var closeButton = document.querySelector('.map-info-close-button');
            if (closeButton) {
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Закрываем карточку с информацией');
                    var mapInfoBlock = document.querySelector('.map-info');
                    if (mapInfoBlock) {
                        mapInfoBlock.classList.remove('show');
                        mapInfoBlock.style.setProperty('display', 'none', 'important');
                        mapInfoBlock.style.setProperty('visibility', 'hidden', 'important');
                        mapInfoBlock.style.setProperty('opacity', '0', 'important');
                    }
                });
            } else {
                console.warn('Кнопка закрытия не найдена');
            }
        });
    </script>
@endsection
