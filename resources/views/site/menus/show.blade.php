@extends('site.layouts.base')

@section('head')
<link href="/menu-css/normalize.css" rel="stylesheet" type="text/css">
<link href="/menu-css/webflow.css" rel="stylesheet" type="text/css">
<link href="/menu-css/sistema-repro.webflow.css" rel="stylesheet" type="text/css">
<style>
  p + .expandable {
    margin-top: 1.5rem;
  }
  .expandable { overflow: hidden; }
  .expander {
    display: grid;
    grid-template-rows: 0fr;
    overflow: hidden;
    transition: grid-template-rows 0.3s ease;
  }
  .expander-content { min-height: 0; }
  .expandable.open .expander { grid-template-rows: 1fr; }
  .expandable.open .expandable-plus { transform: rotateZ(45deg); }
  .expander-content *:last-child { margin-bottom: 0; }
  .menu-table + .menu-table { margin-top: 0.5rem; }
  .menu-table .menu-table-row:last-child { border-bottom: none; }
  .side-menu-link.w--current .side-menu-title::after { content: ' —>'; }
  /* Отступ для якорей при прокрутке */
  .menu-part[id] {
    scroll-margin-top: 20px;
  }
  .side-menu-image {
    width: 55px !important;
    height: 55px !important;
    object-fit: cover;
    flex-shrink: 0;
    background-color: #e5e5e5;
  }
  .menu-card-image {
    background-color: #e5e5e5;
  }
  .menu-card-image.mci-big {
    background-color: #e5e5e5;
  }
  .menu-card-name {
    margin-top: 15px !important;
  }
  .menu-card-title {
    font-size: calc(1.375rem - 4px) !important;
    margin-top: calc(0.5rem - 3px) !important;
  }
</style>
@endsection

@section('content')
@php
    $menuData = is_string($menu->menu_data) ? json_decode($menu->menu_data, true) : $menu->menu_data;
    $dailyKbju = $menuData['daily_kbju']['with_snack'] ?? null;
    $withoutSnackKbju = $menuData['daily_kbju']['without_snack'] ?? null;
    // Определяем якоря для каждого приема пищи (из JSON или дефолтные)
    $breakfastAnchor = $menuData['breakfast']['anchor'] ?? 'breakfast';
    $snackAnchor = $menuData['snack']['anchor'] ?? 'snack';
    $dinnerAnchor = $menuData['dinner']['anchor'] ?? 'dinner';
    $lunchAnchor = $menuData['lunch']['anchor'] ?? 'lunch';
@endphp

<section class="section menu-head-section">
    <div class="container">
        <div class="menu-head">
            <div class="menu-head-content">
                <h1 class="inner-h1"><strong>РЕПРО</strong>меню <span class="mob-inline-block">на семь дней</span></h1>
                <p class="menu-head-p">{{ $menu->description ?? 'Описание меню' }}</p>
                <div class="tags pb-0">
                    @foreach($allMenus as $m)
                        <a href="{{ route('site.menus.show', $m->alias) }}" 
                           class="tag {{ $m->id === $menu->id ? 'active w--current' : '' }} w-inline-block">
                            <div class="tag-label">{{ $m->day }} день</div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="menu-share">
                <div class="menu-subscribe-head-label">Поделиться <span class="hide-on-mobile">РЕПРОменю:</span></div>
                <div class="menu-share-buttons a2a_kit">
                    <a href="#" class="menu-share-button a2a_button_vk w-inline-block">
                        <div class="card-social-icon menu-icon-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg></div>
                    </a>
                    <a href="#" class="menu-share-button a2a_button_telegram w-inline-block">
                        <div class="card-social-icon menu-icon-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg></div>
                    </a>
                    <a href="#" class="menu-share-button a2a_button_whatsapp w-inline-block">
                        <div class="card-social-icon menu-icon-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.314 4.686c6.248 6.249 6.248 16.38 0 22.628-6.249 6.248-16.38 6.248-22.628 0-6.248-6.249-6.248-16.38 0-22.628 6.249-6.248 16.38-6.248 22.628 0zm-10.787 1.18c-5.244 0-9.512 4.268-9.514 9.514 0 1.677.437 3.314 1.27 4.757l-1.35 4.93 5.044-1.323a9.506 9.506 0 0 0 4.546 1.158c5.25-.002 9.516-4.27 9.518-9.514a9.456 9.456 0 0 0-2.784-6.731 9.453 9.453 0 0 0-6.73-2.79zm.003 1.608c2.113 0 4.098.824 5.591 2.319a7.86 7.86 0 0 1 2.314 5.594c-.002 4.36-3.55 7.908-7.908 7.908a7.899 7.899 0 0 1-4.028-1.102l-.288-.172-2.993.785.798-2.918-.188-.299a7.889 7.889 0 0 1-1.209-4.208c.002-4.36 3.55-7.907 7.911-7.907zm-3.371 3.512a.873.873 0 0 0-.634.298l-.17.185c-.269.307-.662.862-.662 1.798 0 1.024.652 2.017.895 2.356l.325.453c.543.736 1.916 2.421 3.812 3.24.567.245 1.01.391 1.355.5.57.182 1.088.156 1.497.095.457-.068 1.407-.575 1.605-1.13.198-.556.198-1.032.138-1.13-.033-.058-.1-.101-.195-.15l-1.15-.564a13.69 13.69 0 0 0-.735-.338c-.217-.08-.376-.119-.534.119-.159.238-.614.773-.753.932-.123.141-.247.172-.44.094l-.075-.034c-.238-.12-1.004-.37-1.912-1.18-.707-.63-1.184-1.41-1.322-1.647-.111-.19-.054-.311.034-.412l.07-.073c.107-.107.238-.278.356-.417.12-.139.159-.238.238-.396a.415.415 0 0 0 .004-.365l-.085-.19c-.149-.352-.507-1.23-.672-1.627-.141-.34-.284-.397-.408-.406l-.126-.002a9.442 9.442 0 0 0-.456-.009z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg></div>
                    </a>
                </div>
                <div class="a2a-code-embed w-embed w-script">
                    <script async="" src="https://static.addtoany.com/menu/page.js"></script>
                </div>
            </div>
        </div>
        <div class="menu-cards">
            @if(isset($menuData['breakfast']))
                <a href="#{{ $breakfastAnchor }}" class="menu-card-link w-inline-block">
                    <div class="menu-card">
                        @php
                            $breakfastImg = $menuData['breakfast']['image'] ?? null;
                            $breakfastImgSrc = $breakfastImg ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
                        @endphp
                        <img src="{{ $breakfastImgSrc }}" loading="lazy" alt="" class="menu-card-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
                        <div class="menu-card-info">
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/belki.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-belki">
                                    <div>белки</div>
                                </div>
                                <div class="menu-card-value"><strong>{{ formatMenuNumber($menuData['breakfast']['kbju']['proteins'] ?? 0) }}</strong></div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/zhiry.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-zhiry">
                                    <div>жиры</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['breakfast']['kbju']['fats'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/uglevody.svg" loading="lazy" width="14" alt="" class="menu-card-icon">
                                    <div>углеводы</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['breakfast']['kbju']['carbs'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/ckal.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-ckal">
                                    <div>ккал</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['breakfast']['kbju']['calories'] ?? $menuData['breakfast']['kbju']['kcal'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card-name">Завтрак —&gt;</div>
                    <div class="menu-card-title">{{ $menuData['breakfast']['title'] ?? 'Завтрак' }}</div>
                </a>
            @endif

            @if(isset($menuData['snack']))
                <a href="#{{ $snackAnchor }}" class="menu-card-link w-inline-block">
                    <div class="menu-card">
                        @php
                            $snackImg = $menuData['snack']['image'] ?? null;
                            $snackImgSrc = $snackImg ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
                        @endphp
                        <img src="{{ $snackImgSrc }}" loading="lazy" alt="" class="menu-card-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
                        <div class="menu-card-info">
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/belki.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-belki">
                                    <div>белки</div>
                                </div>
                                <div class="menu-card-value"><strong>{{ formatMenuNumber($menuData['snack']['kbju']['proteins'] ?? 0) }}</strong></div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/zhiry.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-zhiry">
                                    <div>жиры</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['snack']['kbju']['fats'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/uglevody.svg" loading="lazy" width="14" alt="" class="menu-card-icon">
                                    <div>углеводы</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['snack']['kbju']['carbs'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/ckal.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-ckal">
                                    <div>ккал</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['snack']['kbju']['calories'] ?? $menuData['snack']['kbju']['kcal'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card-name">Перекус —&gt;</div>
                    <div class="menu-card-title">{{ $menuData['snack']['title'] ?? 'Перекус' }}</div>
                </a>
            @endif

            @if(isset($menuData['dinner']))
                <a href="#{{ $dinnerAnchor }}" class="menu-card-link w-inline-block">
                    <div class="menu-card">
                        @php
                            $dinnerImg = $menuData['dinner']['image'] ?? null;
                            $dinnerImgSrc = $dinnerImg ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
                        @endphp
                        <img src="{{ $dinnerImgSrc }}" loading="lazy" alt="" class="menu-card-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
                        <div class="menu-card-info">
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/belki.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-belki">
                                    <div>белки</div>
                                </div>
                                <div class="menu-card-value"><strong>{{ formatMenuNumber($menuData['dinner']['kbju']['proteins'] ?? 0) }}</strong></div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/zhiry.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-zhiry">
                                    <div>жиры</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['dinner']['kbju']['fats'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/uglevody.svg" loading="lazy" width="14" alt="" class="menu-card-icon">
                                    <div>углеводы</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['dinner']['kbju']['carbs'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/ckal.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-ckal">
                                    <div>ккал</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['dinner']['kbju']['calories'] ?? $menuData['dinner']['kbju']['kcal'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card-name">Обед —&gt;</div>
                    <div class="menu-card-title">{{ $menuData['dinner']['title'] ?? 'Обед' }}</div>
                </a>
            @endif

            @if(isset($menuData['lunch']))
                <a href="#{{ $lunchAnchor }}" class="menu-card-link w-inline-block">
                    <div class="menu-card">
                        @php
                            $lunchImg = $menuData['lunch']['image'] ?? null;
                            $lunchImgSrc = $lunchImg ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
                        @endphp
                        <img src="{{ $lunchImgSrc }}" loading="lazy" alt="" class="menu-card-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';">
                        <div class="menu-card-info">
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/belki.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-belki">
                                    <div>белки</div>
                                </div>
                                <div class="menu-card-value"><strong>{{ formatMenuNumber($menuData['lunch']['kbju']['proteins'] ?? 0) }}</strong></div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/zhiry.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-zhiry">
                                    <div>жиры</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['lunch']['kbju']['fats'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/uglevody.svg" loading="lazy" width="14" alt="" class="menu-card-icon">
                                    <div>углеводы</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['lunch']['kbju']['carbs'] ?? 0) }}</div>
                            </div>
                            <div class="menu-card-info-item">
                                <div class="menu-card-label"><img src="/menu-images/ckal.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-ckal">
                                    <div>ккал</div>
                                </div>
                                <div class="menu-card-value">{{ formatMenuNumber($menuData['lunch']['kbju']['calories'] ?? $menuData['lunch']['kbju']['kcal'] ?? 0) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="menu-card-name">Ужин —&gt;</div>
                    <div class="menu-card-title">{{ $menuData['lunch']['title'] ?? 'Ужин' }}</div>
                </a>
            @endif
        </div>
    </div>
</section>

<section class="section menu-section">
    <div class="container menu-container">
        <div class="menu-sticky">
            <div class="menu-sticky-content">
                <div class="side-menu-items">
                    <div class="side-menu-h"><strong>{{ $menu->title }}</strong></div>
                    @if(isset($menuData['breakfast']))
                        <a href="#{{ $breakfastAnchor }}" class="side-menu-link w-inline-block">
                            @php
                                $breakfastImageSmall = $menuData['breakfast']['image_small'] ?? $menuData['breakfast']['small_image'] ?? null;
                                $breakfastImage = $breakfastImageSmall ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';
                            @endphp
                            <img src="{{ $breakfastImage }}" loading="lazy" alt="Завтрак" class="side-menu-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';">
                            <div class="side-menu-item-content">
                                <div class="side-menu-title">Завтрак</div>
                                <div>{{ $menuData['breakfast']['title'] ?? '' }}</div>
                            </div>
                        </a>
                    @endif
                    @if(isset($menuData['snack']))
                        <a href="#{{ $snackAnchor }}" class="side-menu-link w-inline-block">
                            @php
                                $snackImageSmall = $menuData['snack']['image_small'] ?? $menuData['snack']['small_image'] ?? null;
                                $snackImage = $snackImageSmall ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';
                            @endphp
                            <img src="{{ $snackImage }}" loading="lazy" alt="Перекус" class="side-menu-image">
                            <div class="side-menu-item-content">
                                <div class="side-menu-title">Перекус</div>
                                <div>{{ $menuData['snack']['title'] ?? '' }}</div>
                            </div>
                        </a>
                    @endif
                    @if(isset($menuData['dinner']))
                        <a href="#{{ $dinnerAnchor }}" class="side-menu-link w-inline-block">
                            @php
                                $dinnerImageSmall = $menuData['dinner']['image_small'] ?? $menuData['dinner']['small_image'] ?? null;
                                $dinnerImage = $dinnerImageSmall ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';
                            @endphp
                            <img src="{{ $dinnerImage }}" loading="lazy" alt="Обед" class="side-menu-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';">
                            <div class="side-menu-item-content">
                                <div class="side-menu-title">Обед</div>
                                <div>{{ $menuData['dinner']['title'] ?? '' }}</div>
                            </div>
                        </a>
                    @endif
                    @if(isset($menuData['lunch']))
                        <a href="#{{ $lunchAnchor }}" class="side-menu-link w-inline-block">
                            @php
                                $lunchImageSmall = $menuData['lunch']['image_small'] ?? $menuData['lunch']['small_image'] ?? null;
                                $lunchImage = $lunchImageSmall ?: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';
                            @endphp
                            <img src="{{ $lunchImage }}" loading="lazy" alt="Ужин" class="side-menu-image" onerror="this.style.backgroundColor='#e5e5e5'; this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTUiIGhlaWdodD0iNTUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHJlY3Qgd2lkdGg9IjU1IiBoZWlnaHQ9IjU1IiBmaWxsPSIjZTVlNWU1Ii8+PC9zdmc+';">
                            <div class="side-menu-item-content">
                                <div class="side-menu-title">Ужин</div>
                                <div>{{ $menuData['lunch']['title'] ?? '' }}</div>
                            </div>
                        </a>
                    @endif
                </div>
                @if($dailyKbju)
                    <div class="side-kbzhu">
                        <div class="kbzhu-title"><strong>Дневной КБЖУ</strong></div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/belki-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($dailyKbju['proteins'] ?? 0) }}</div>
                                <div>белки</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/zhiry-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($dailyKbju['fats'] ?? 0) }}</div>
                                <div>жиры</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/uglevody-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($dailyKbju['carbs'] ?? 0) }}</div>
                                <div>углеводы</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/ckal-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($dailyKbju['calories'] ?? $dailyKbju['kcal'] ?? 0) }}</div>
                                <div>ккал</div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($withoutSnackKbju)
                    <div class="side-kbzhu kbzhu-lavender">
                        <div class="kbzhu-title"><strong>Без перекуса</strong></div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/belki-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($withoutSnackKbju['proteins'] ?? 0) }}</div>
                                <div>белки</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/zhiry-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($withoutSnackKbju['fats'] ?? 0) }}</div>
                                <div>жиры</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/uglevody-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($withoutSnackKbju['carbs'] ?? 0) }}</div>
                                <div>углеводы</div>
                            </div>
                        </div>
                        <div class="menu-card-info-item mci-small">
                            <div class="mci-lavender"><img src="/menu-images/ckal-white.svg" loading="lazy" width="14" alt="" class="menu-card-icon mci-white-small"></div>
                            <div class="menu-card-label mcl-big">
                                <div class="menu-card-value mcv-small">{{ formatMenuNumber($withoutSnackKbju['calories'] ?? $withoutSnackKbju['kcal'] ?? 0) }}</div>
                                <div>ккал</div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="tags side-menu-tags">
                    @foreach($allMenus as $m)
                        <a href="{{ route('site.menus.show', $m->alias) }}" 
                           class="tag {{ $m->id === $menu->id ? 'active w--current' : '' }} w-inline-block">
                            <div class="tag-label">{{ $m->day }} день</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="menu-content">
            @if(isset($menuData['breakfast']))
                @include('site.menus.partials.meal', ['meal' => $menuData['breakfast'], 'mealId' => $breakfastAnchor, 'mealTitle' => 'Завтрак'])
            @endif

            @if(isset($menuData['snack']))
                @include('site.menus.partials.meal', ['meal' => $menuData['snack'], 'mealId' => $snackAnchor, 'mealTitle' => 'Перекус'])
            @endif

            @if(isset($menuData['dinner']))
                @include('site.menus.partials.meal', ['meal' => $menuData['dinner'], 'mealId' => $dinnerAnchor, 'mealTitle' => 'Обед'])
            @endif

            @if(isset($menuData['lunch']))
                @include('site.menus.partials.meal', ['meal' => $menuData['lunch'], 'mealId' => $lunchAnchor, 'mealTitle' => 'Ужин'])
            @endif
        </div>
    </div>
</section>

@if(isset($menuData['next_day_recommendations']))
    <section class="section">
        <div class="container next-day-container">
            <div class="next-day-content">
                <div class="rich-text-block w-richtext">
                    <h3>{{ $menuData['next_day_recommendations']['title'] ?? 'Рекомендации по заготовкам продуктов на следующий день' }}</h3>
                    @if(isset($menuData['next_day_recommendations']['description']))
                        {!! nl2br(e($menuData['next_day_recommendations']['description'])) !!}
                    @endif
                </div>
                @php
                    $nextMenu = $allMenus->where('day', $menu->day + 1)->first();
                @endphp
                @if($nextMenu)
                    <a href="{{ route('site.menus.show', $nextMenu->alias) }}" class="button w-button">
                        <strong>Меню {{ $nextMenu->day }}-го дня —&gt;</strong>
                    </a>
                @endif
            </div>
            @if(isset($menuData['next_day_recommendations']['meals']))
                <div class="next-day-items">
                    @foreach($menuData['next_day_recommendations']['meals'] as $nextMeal)
                        <div class="next-day-item">
                            <img src="{{ $nextMeal['image'] ?? '/menu-images/next-day-1.webp' }}" loading="lazy" alt="" class="next-day-image">
                            <div class="next-day-title"><strong>{{ $nextMeal['title'] ?? '' }}</strong></div>
                            <div class="next-day-description">{{ $nextMeal['description'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
@endsection

@section('scripts')
<script type="text/javascript">
// Обработка ошибок загрузки изображений - показываем серую подложку
document.querySelectorAll('.menu-card-image, .side-menu-image').forEach(img => {
    img.addEventListener('error', function() {
        this.style.backgroundColor = '#e5e5e5';
        this.style.display = 'block';
        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgZmlsbD0iI2U1ZTVlNSIvPjwvc3ZnPg==';
    });
});

document.querySelectorAll('.expandable-head').forEach(head => {
    head.addEventListener('click', () => {
        const expandable = head.closest('.expandable');
        expandable.classList.toggle('open');
    });
});

// Плавная прокрутка к якорям с отступом
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href.startsWith('#')) {
            e.preventDefault();
            const targetId = href.substring(1);
            const target = document.querySelector('#' + targetId);
            if (target) {
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Обработка прямого перехода по URL с якорем (при загрузке страницы)
if (window.location.hash) {
    window.addEventListener('load', () => {
        const targetId = window.location.hash.substring(1);
        const target = document.querySelector('#' + targetId);
        if (target) {
            setTimeout(() => {
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 20;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }, 100);
        }
    });
}
</script>
@endsection
