@php
    $cities = App\Models\Point::active()->get()->pluck('city')->unique()->sort()->values();    
    $selectedCity = session()->get('city') ?? '';
@endphp

<div id="select-city" class="modal">
    <div class="wrap">
        <div class="modal-title">
            Выберите ваш город
        </div>
        <div class="modal-content">
            <div class="cities-list">
                @foreach($cities as $city)
                    <a href="{{ request()->url() }}?city={{ $city }}">{{ $city }}</a>
                @endforeach
            </div>
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
        display: flex;
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
        border-bottom: 1px solid #e5e5e5;
        margin: 0;
        flex-shrink: 0;
    }
    .modal-content .cities-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 0;
        max-height: calc(70vh - 80px);
    }
    .modal-content a {
        display: block;
        padding: 12px 24px;
        color: #333;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.2s ease;
        border-bottom: 1px solid #f5f5f5;
    }
    .modal-content a:hover {
        background-color: #f8f9fa;
        color: #007bff;
    }
    .modal-content a:last-child {
        border-bottom: none;
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