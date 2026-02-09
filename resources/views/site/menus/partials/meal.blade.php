<div id="{{ $mealId }}" class="menu-part">
    <h2 class="menu-h2">{{ $mealTitle }}</h2>
    
    @if(isset($meal['subtitle']))
        <p><strong>{!! $meal['subtitle'] !!}</strong></p>
    @endif

    @php
        $bigImage = $meal['image_big'] ?? $meal['big_image'] ?? null;
        $bigImageSrc = $bigImage ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
    @endphp
    <div class="menu-content-card">
        <img src="{{ $bigImageSrc }}" loading="lazy" sizes="(max-width: 767px) 100vw, 768px" alt="" class="menu-card-image mci-big" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iNzY4IiBoZWlnaHQ9IjUxMiIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
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

    @if(isset($meal['recipe_table']) && isset($meal['recipe_table']['rows']) && count($meal['recipe_table']['rows']) > 0)
        <div class="menu-table" style="background-image: none !important; background-color: {{ $meal['recipe_table']['background_color'] ?? '' }} !important; margin-top: 20px; margin-bottom: 30px;">
            @if(!empty($meal['recipe_table']['title']))
                <p><strong>{{ $meal['recipe_table']['title'] }}</strong></p>
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
                @foreach($meal['recipe_table']['rows'] as $row)
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
                                <p>{!! nl2br(e($expandable['content'])) !!}</p>
                            @endif
                            @if(isset($expandable['note']) && !empty($expandable['note']))
                                <p class="menu-snoska">{!! nl2br(e($expandable['note'])) !!}</p>
                            @endif
                            
                            @if(isset($expandable['table']) && is_array($expandable['table']) && isset($expandable['table']['rows']) && is_array($expandable['table']['rows']) && count($expandable['table']['rows']) > 0)
                                <div class="menu-table" @if(isset($expandable['table']['background_color']) && !empty($expandable['table']['background_color'])) style="background-image: none !important; background-color: {{ $expandable['table']['background_color'] }} !important;" @endif>
                                    @if(isset($expandable['table']['title']) && !empty($expandable['table']['title']))
                                        <p><strong>{!! $expandable['table']['title'] !!}</strong></p>
                                    @endif
                                    @if(isset($expandable['table']['description']) && !empty($expandable['table']['description']))
                                        <p>{!! nl2br(e($expandable['table']['description'])) !!}</p>
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
                                        @foreach($expandable['table']['rows'] as $row)
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
