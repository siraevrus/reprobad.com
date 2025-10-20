@php
    //$cities = App\Models\Point::active()->get()->pluck('city')->unique()->sort()->values();   
    $cities = explode(PHP_EOL, file_get_contents(public_path('cities.txt')));
    $cities = array_unique($cities);
    $selectedCity = '';

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
            
            return;
        }

    } elseif(session()->get('city')) {

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
<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        justify-content: center;
        align-items: center;
        background-color: rgb(0, 0, 0, .6);
    }
    .modal .map-search {
        width: calc(100% - 40px);
        margin: 0 20px 15px 20px;
    }
    .modal.show {
        display: flex;
    }
    .modal .wrap {
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border-radius: 12px;
        max-width: 400px;
        width: 90%;
        max-height: 70vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .modal-title {
        padding: 20px 24px 16px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin: 0;
        flex-shrink: 0;
    }
    .modal-content .cities-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 20px;
        max-height: calc(70vh - 230px);
    }
    .modal-content label input {
        display: none;
    }
    .modal-content label {
        display: block;
        padding: 12px 24px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.2s ease;
        cursor: pointer;
        border-radius: 6px;
        margin: 2px 0;
    }
    .modal-content label:hover {
        background-color: #f8f9fa;
        color: var(--mandarin);
    }
    .modal-content label input:checked + span {
        color: var(--mandarin);
        font-weight: 600;
    }
    .modal-content label:has(input:checked) {
        background-color: #fff3e0;
        color: var(--mandarin);
    }
    .modal-content button {
        width: calc(100% - 40px);
        margin: 20px;
        transition: all 0.2s ease;
    }
    .modal-content button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .no-results {
        padding: 20px;
        text-align: center;
        color: #6b7280;
        font-style: italic;
    }
    .modal-content .cities-list::-webkit-scrollbar {
        width: 6px;
    }
    .modal-content .cities-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    .modal-content .cities-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    .modal-content .cities-list::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    @media (max-width: 480px) {
        .modal-content {
            width: 95%;
            max-height: 80vh;
        }
        .modal-title {
            padding: 16px 20px 12px;
            font-size: 16px;
        }
        .modal-content a {
            padding: 10px 20px;
            font-size: 15px;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('select-city');
    const selectBtn = document.getElementById('select-city-btn');
    const searchInput = document.querySelector('.map-search');
    const citiesList = document.querySelector('.cities-list');
    let allCityLabels = Array.from(document.querySelectorAll('.cities-list label'));

    @if($selectedCity == '')
        modal.classList.add('show');
    @endif

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
            const currentUrl = window.location.href.split('?')[0];
            window.location.href = currentUrl + '?city=' + encodeURIComponent(cityValue);
        }
    });

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