@php
    //$cities = App\Models\Point::active()->get()->pluck('city')->unique()->sort()->values();   
    $cities = explode(PHP_EOL, file_get_contents(public_path('cities.txt')));
    $cities = array_unique($cities);
    $selectedCity = '';

    // Обработка параметра ?city= для обратной совместимости (без редиректа)
    if(request()->get('city')) {
        foreach($cities as $city) {
            if(trim($city) == trim(request()->get('city'))) {
                $selectedCity = $city;
                break;
            }
        }

        if($selectedCity != '') {
            session()->put('city', $selectedCity);
            app(\App\Services\CityStatsService::class)->recordCitySelection($selectedCity);
            // Не делаем return, чтобы страница продолжала загружаться
        }
    }

    // Если город не был передан в URL, берем из сессии
    if($selectedCity == '' && session()->get('city')) {
        $selectedCity = session()->get('city') ?? '';
    }
@endphp

<div id="select-city" class="modal">
    <div class="wrap">
        <div class="modal-title">
            Выберите ваш город
        </div>
        <div class="modal-content">
            <input name="search" placeholder="Поиск города" class="map-search">
            <div class="cities-list">
                @foreach($cities as $city)
                    <label for="city-{{ $loop->index }}">
                        <input type="radio" name="city" value="{{ $city }}" id="city-{{ $loop->index }}">
                        <span>{{ $city }}</span>
                    </label>
                @endforeach
                <div id="no-results" class="no-results" style="display: none;">
                    <p>Город не найден</p>
                </div>
            </div>
            <button class="button short-event-button w-button" id="select-city-btn" disabled>
                Выбрать
            </button>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('select-city');
    const selectBtn = document.getElementById('select-city-btn');
    const searchInput = document.querySelector('.map-search');
    const citiesList = document.querySelector('.cities-list');
    let allCityLabels = Array.from(document.querySelectorAll('.cities-list label'));

    if(localStorage.getItem('cityModalShowed') == null) {
        modal.classList.add('show');
    }

    localStorage.setItem('cityModalShowed', 1);

    function filterCities(searchTerm) {
        const term = searchTerm.toLowerCase().trim();
        let visibleCount = 0;
        
        allCityLabels.forEach(label => {
            const cityName = label.querySelector('span').textContent.toLowerCase();
            const isVisible = cityName.includes(term);
            
            label.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });

        const noResults = document.getElementById('no-results');
        if (visibleCount === 0 && term.length > 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }

        const checkedInput = document.querySelector('input[name="city"]:checked');
        if (checkedInput) {
            checkedInput.checked = false;
            selectBtn.disabled = true;
            selectBtn.style.opacity = '0.5';
        }
    }

    searchInput.addEventListener('input', function() {
        filterCities(this.value);
    });

    document.addEventListener('change', function(e) {
        if (e.target.name === 'city') {
            if (e.target.checked) {
                selectBtn.disabled = false;
                selectBtn.style.opacity = '1';
            }
        }
    });

    selectBtn.addEventListener('click', function() {
        const selectedCity = document.querySelector('input[name="city"]:checked');
        if (selectedCity) {
            const cityValue = selectedCity.value;
            
            // Отправляем AJAX запрос для сохранения города
            fetch('/forms/city', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    city: cityValue
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Убираем параметр ?city= из URL без перезагрузки страницы
                    const url = new URL(window.location.href);
                    url.searchParams.delete('city');
                    window.history.replaceState({}, '', url.toString());
                    
                    // Закрываем модальное окно
                    modal.classList.remove('show');
                } else {
                    console.error('Ошибка сохранения города:', data.errors);
                    alert('Произошла ошибка при сохранении города');
                }
            })
            .catch(error => {
                console.error('Ошибка запроса:', error);
                alert('Произошла ошибка при сохранении города');
            });
        }
    });

    // Убираем параметр ?city= из URL при загрузке страницы (если он есть)
    if (window.location.search.includes('city=')) {
        const url = new URL(window.location.href);
        url.searchParams.delete('city');
        window.history.replaceState({}, '', url.toString());
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            searchInput.value = '';
            filterCities('');
        }
    });
});
</script>