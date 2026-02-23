<div id="{{ $mealId }}" class="menu-part">
    <h2 class="menu-h2">{{ $mealTitle }}</h2>
    
    @if(isset($meal['subtitle']))
        <p><strong>{!! $meal['subtitle'] !!}</strong></p>
    @endif

    @php
        // Поддержка массива изображений или одиночного изображения
        $images = [];
        if (isset($meal['images']) && is_array($meal['images']) && count($meal['images']) > 0) {
            // Если есть массив изображений, используем его
            foreach ($meal['images'] as $img) {
                if (is_array($img) && isset($img['url'])) {
                    $images[] = ['url' => $img['url']];
                } elseif (is_string($img)) {
                    $images[] = ['url' => $img];
                }
            }
        }
        // Если массива нет, используем одиночное изображение (image_big, big_image или image для карточки)
        if (empty($images)) {
            $bigImage = $meal['image_big'] ?? $meal['big_image'] ?? $meal['image'] ?? null;
            if ($bigImage) {
                $images[] = ['url' => $bigImage];
            } else {
                $images[] = ['url' => 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg=='];
            }
        }
        $galleryId = 'gallery-' . str_replace(['#', ' '], ['', '-'], $mealId);
        // Имя функции должно быть валидным JS-идентификатором (без дефисов и спецсимволов)
        $galleryFunction = 'menuGallery_' . preg_replace('/[^A-Za-z0-9_]/', '_', $galleryId);
    @endphp
    <div class="menu-content-card menu-gallery-container" x-data="{{ $galleryFunction }}()">
        <div class="menu-gallery-main">
            <div class="menu-gallery-track" :style="`transform: translateX(-${currentIndex * 100}%);`">
                <template x-for="(image, index) in slides" :key="index">
                    <img
                         :src="image.url" 
                         alt="" 
                         class="menu-card-image mci-big" 
                         style="cursor: default;"
                         onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
                </template>
            </div>
            
            @if(count($images) > 1)
                <div class="menu-gallery-prev" @click="prevImage" x-show="slides.length > 1">
                    <img src="/images/left-arrow.svg" alt="Предыдущее изображение">
                </div>
                <div class="menu-gallery-next" @click="nextImage" x-show="slides.length > 1">
                    <img src="/images/right-arrow.svg" alt="Следующее изображение">
                </div>
            @endif
        </div>

        @if(isset($meal['kbju']))
            <div class="menu-card-info mci-block">
                <div class="menu-card-info-item mci-big">
                    <div class="mci-orange"><img src="/menu-images/belki-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                    <div class="menu-card-label mcl-big">
                        <div class="menu-card-value mcv-big"><strong>{{ formatMenuNumber($meal['kbju']['proteins'] ?? 0) }} г</strong></div>
                        <div>белки</div>
                    </div>
                </div>
                <div class="menu-card-info-item mci-big">
                    <div class="mci-orange"><img src="/menu-images/zhiry-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                    <div class="menu-card-label mcl-big">
                        <div class="menu-card-value mcv-big"><strong>{{ formatMenuNumber($meal['kbju']['fats'] ?? 0) }} г</strong></div>
                        <div>жиры</div>
                    </div>
                </div>
                <div class="menu-card-info-item mci-big">
                    <div class="mci-orange"><img src="/menu-images/uglevody-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                    <div class="menu-card-label mcl-big">
                        <div class="menu-card-value mcv-big"><strong>{{ formatMenuNumber($meal['kbju']['carbs'] ?? 0) }} г</strong></div>
                        <div>углеводы</div>
                    </div>
                </div>
                <div class="menu-card-info-item mci-big">
                    <div class="mci-orange"><img src="/menu-images/ckal-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                    <div class="menu-card-label mcl-big">
                        <div class="menu-card-value mcv-big">{{ formatMenuNumber($meal['kbju']['calories'] ?? $meal['kbju']['kcal'] ?? 0) }}</div>
                        <div>ккал</div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(isset($meal['description']))
        @php
            $description = $meal['description'];
            // Декодируем HTML entities, если они есть
            $description = html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        @endphp
        <div>{!! $description !!}</div>
    @endif

    @if(isset($meal['recipe']))
        <h3 class="menu-h2" style="margin-top: 25px; margin-bottom: 15px;">Рецепт</h3>
        @php
            $recipe = $meal['recipe'];
            // Декодируем HTML entities, если они есть
            $recipe = html_entity_decode($recipe, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        @endphp
        <div>{!! $recipe !!}</div>
    @endif

    @php
        $mealRecipeTables = isset($meal['recipe_tables']) && is_array($meal['recipe_tables'])
            ? $meal['recipe_tables']
            : (isset($meal['recipe_table']) && is_array($meal['recipe_table']) ? [$meal['recipe_table']] : []);
    @endphp
    @foreach($mealRecipeTables as $recipeTable)
        @if(isset($recipeTable['rows']) && is_array($recipeTable['rows']) && count($recipeTable['rows']) > 0)
            <div class="menu-table" style="background-image: none !important; background-color: {{ $recipeTable['background_color'] ?? '' }} !important; margin-top: 20px; margin-bottom: 30px;">
                @if(!empty($recipeTable['title']))
                    <p><strong>{{ $recipeTable['title'] }}</strong></p>
                @endif
                <div class="menu-table-scroller">
                    <div class="menu-table-row mtr-head">
                        <div class="menu-table-cell first">продукт</div>
                        <div class="menu-table-cell">вес, гр</div>
                        <div class="menu-table-cell">бел, гр</div>
                        <div class="menu-table-cell">жир, гр</div>
                        <div class="menu-table-cell">угл, гр</div>
                        <div class="menu-table-cell">ккал</div>
                    </div>
                    @foreach($recipeTable['rows'] as $row)
                        <div class="menu-table-row">
                            <div class="menu-table-cell first">{{ $row['product'] ?? '' }}</div>
                            <div class="menu-table-cell">{{ formatMenuNumber($row['weight'] ?? 0) }}</div>
                            <div class="menu-table-cell">{{ formatMenuNumber($row['proteins'] ?? 0) }}</div>
                            <div class="menu-table-cell">{{ formatMenuNumber($row['fats'] ?? 0) }}</div>
                            <div class="menu-table-cell">{{ formatMenuNumber($row['carbs'] ?? 0) }}</div>
                            <div class="menu-table-cell">{{ formatMenuNumber($row['calories'] ?? $row['kcal'] ?? 0) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    @if(isset($meal['expandables']) && is_array($meal['expandables']))
        @foreach($meal['expandables'] as $expandable)
            <div class="expandable {{ $loop->first ? 'open' : '' }}">
                <div class="expandable-head">
                    <div>{!! $expandable['title'] ?? '' !!}<br></div>
                    <div class="expandable-plus w-embed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <div class="expander">
                    <div class="expander-content">
                        <div class="expander-content-wrap">
                            @if(isset($expandable['content']) && !empty($expandable['content']))
                                @php
                                    $expandableContent = html_entity_decode($expandable['content'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                @endphp
                                <div>{!! $expandableContent !!}</div>
                            @endif
                            @if(isset($expandable['note']) && !empty($expandable['note']))
                                <p class="menu-snoska">{!! nl2br(e($expandable['note'])) !!}</p>
                            @endif
                            
                            @php
                                $expandableTables = isset($expandable['tables']) && is_array($expandable['tables'])
                                    ? $expandable['tables']
                                    : (isset($expandable['table']) && is_array($expandable['table']) ? [$expandable['table']] : []);
                            @endphp
                            @foreach($expandableTables as $expTable)
                                @if(isset($expTable['rows']) && is_array($expTable['rows']) && count($expTable['rows']) > 0)
                                    <div class="menu-table" @if(isset($expTable['background_color']) && !empty($expTable['background_color'])) style="background-image: none !important; background-color: {{ $expTable['background_color'] }} !important;" @endif>
                                        @if(isset($expTable['title']) && !empty($expTable['title']))
                                            <p><strong>{!! $expTable['title'] !!}</strong></p>
                                        @endif
                                        @if(isset($expTable['description']) && !empty($expTable['description']))
                                            <p>{!! nl2br(e($expTable['description'])) !!}</p>
                                        @endif
                                        <div class="menu-table-scroller">
                                            <div class="menu-table-row mtr-head">
                                                <div class="menu-table-cell first">продукт</div>
                                                <div class="menu-table-cell">вес, гр</div>
                                                <div class="menu-table-cell">бел, гр</div>
                                                <div class="menu-table-cell">жир, гр</div>
                                                <div class="menu-table-cell">угл, гр</div>
                                                <div class="menu-table-cell">ккал</div>
                                            </div>
                                            @foreach($expTable['rows'] as $row)
                                                <div class="menu-table-row">
                                                    <div class="menu-table-cell first">{!! $row['product'] ?? '' !!}</div>
                                                    <div class="menu-table-cell">{{ formatMenuNumber($row['weight'] ?? 0) }}</div>
                                                    <div class="menu-table-cell">{{ formatMenuNumber($row['proteins'] ?? 0) }}</div>
                                                    <div class="menu-table-cell">{{ formatMenuNumber($row['fats'] ?? 0) }}</div>
                                                    <div class="menu-table-cell">{{ formatMenuNumber($row['carbs'] ?? 0) }}</div>
                                                    <div class="menu-table-cell">{{ formatMenuNumber($row['calories'] ?? $row['kcal'] ?? 0) }}</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if(isset($meal['note']))
        <p class="menu-snoska">{!! nl2br(e($meal['note'])) !!}</p>
    @endif
</div>

<script>
function {{ $galleryFunction }}() {
    return {
        slides: @json($images),
        currentIndex: 0,
        init() {
            // Инициализация при необходимости (без модального окна)
        },
        setCurrentIndex(index) {
            this.currentIndex = index;
        },
        prevImage() {
            this.currentIndex = (this.currentIndex === 0) ? this.slides.length - 1 : this.currentIndex - 1;
        },
        nextImage() {
            this.currentIndex = (this.currentIndex === this.slides.length - 1) ? 0 : this.currentIndex + 1;
        }
    };
}
</script>
