<div id="{{ $mealId }}" class="menu-part">
    <h2 class="menu-h2">{{ $mealTitle }}</h2>
    
    @if(isset($meal['subtitle']))
        <p><strong>{!! $meal['subtitle'] !!}</strong></p>
    @endif

    @if(isset($meal['big_image']))
        <div class="menu-content-card">
            <img src="{{ $meal['big_image'] }}" loading="lazy" sizes="(max-width: 767px) 100vw, 768px" alt="" class="menu-card-image mci-big">
            @if(isset($meal['kbju']))
                <div class="menu-card-info mci-block">
                    <div class="menu-card-info-item mci-big">
                        <div class="mci-orange"><img src="/menu-images/ckal-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                        <div class="menu-card-label mcl-big">
                            <div class="menu-card-value mcv-big">{{ number_format((float)($meal['kbju']['kcal'] ?? 0), 2, ',', '') }}</div>
                            <div>ккал</div>
                        </div>
                    </div>
                    <div class="menu-card-info-item mci-big">
                        <div class="mci-orange"><img src="/menu-images/belki-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                        <div class="menu-card-label mcl-big">
                            <div class="menu-card-value mcv-big"><strong>{{ number_format((float)($meal['kbju']['proteins'] ?? 0), 2, ',', '') }} г</strong></div>
                            <div>белки</div>
                        </div>
                    </div>
                    <div class="menu-card-info-item mci-big">
                        <div class="mci-orange"><img src="/menu-images/zhiry-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                        <div class="menu-card-label mcl-big">
                            <div class="menu-card-value mcv-big"><strong>{{ number_format((float)($meal['kbju']['fats'] ?? 0), 2, ',', '') }} г</strong></div>
                            <div>жиры</div>
                        </div>
                    </div>
                    <div class="menu-card-info-item mci-big">
                        <div class="mci-orange"><img src="/menu-images/uglevody-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white"></div>
                        <div class="menu-card-label mcl-big">
                            <div class="menu-card-value mcv-big"><strong>{{ number_format((float)($meal['kbju']['carbs'] ?? 0), 2, ',', '') }} г</strong></div>
                            <div>углеводы</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if(isset($meal['description']))
        <p>{!! nl2br(e($meal['description'])) !!}</p>
    @endif

    @if(isset($meal['recipe']))
        <p>{!! nl2br(e($meal['recipe'])) !!}</p>
    @endif

    @if(isset($meal['expandable_items']) && is_array($meal['expandable_items']))
        @foreach($meal['expandable_items'] as $expandable)
            <div class="expandable">
                <div class="expandable-head">
                    <div>{!! $expandable['title'] ?? '' !!}</div>
                    @if(isset($expandable['content']) && !empty($expandable['content']))
                        <div class="expandable-plus w-embed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </div>
                    @endif
                </div>
                @if(isset($expandable['content']) && !empty($expandable['content']))
                    <div class="expander">
                        <div class="expander-content">
                            <div class="expander-content-wrap">
                                @if(isset($expandable['content']))
                                    <p>{!! nl2br(e($expandable['content'])) !!}</p>
                                @endif
                                @if(isset($expandable['note']))
                                    <p class="menu-snoska">{!! nl2br(e($expandable['note'])) !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    @if(isset($meal['product_tables']) && is_array($meal['product_tables']))
        @foreach($meal['product_tables'] as $table)
            <div class="menu-table {{ isset($table['class']) ? $table['class'] : '' }}">
                @if(isset($table['title']))
                    <p><strong>{!! $table['title'] !!}</strong></p>
                @endif
                @if(isset($table['description']))
                    <p>{!! nl2br(e($table['description'])) !!}</p>
                @endif
                @if(isset($table['rows']) && is_array($table['rows']))
                    <div class="menu-table-scroller">
                        <div class="menu-table-row mtr-head">
                            <div class="menu-table-cell first">продукт</div>
                            <div class="menu-table-cell">вес, гр</div>
                            <div class="menu-table-cell">бел, гр</div>
                            <div class="menu-table-cell">жир, гр</div>
                            <div class="menu-table-cell">угл, гр</div>
                            <div class="menu-table-cell">ккал</div>
                        </div>
                        @foreach($table['rows'] as $row)
                            <div class="menu-table-row">
                                <div class="menu-table-cell first">{!! $row['product'] ?? '' !!}</div>
                                <div class="menu-table-cell">{{ number_format((float)($row['weight'] ?? 0), 2, ',', '') }}</div>
                                <div class="menu-table-cell">{{ number_format((float)($row['proteins'] ?? 0), 2, ',', '') }}</div>
                                <div class="menu-table-cell">{{ number_format((float)($row['fats'] ?? 0), 2, ',', '') }}</div>
                                <div class="menu-table-cell">{{ number_format((float)($row['carbs'] ?? 0), 2, ',', '') }}</div>
                                <div class="menu-table-cell">{{ number_format((float)($row['kcal'] ?? 0), 2, ',', '') }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    @if(isset($meal['note']))
        <p class="menu-snoska">{!! nl2br(e($meal['note'])) !!}</p>
    @endif
</div>
