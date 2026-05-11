<!DOCTYPE html>
<html data-wf-page="697729df64c8f65c7ff4c2e1" data-wf-site="67040316492967a9326aebb1">
<head>
  <meta charset="utf-8">
  <title>{{ strip_tags($resource->title ?? 'Результаты теста') }}</title>
  <meta content="{{ strip_tags($resource->title ?? '') }}" property="og:title">
  <meta content="{{ strip_tags($resource->title ?? '') }}" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="{{ asset('css/normalize.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/webflow.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/sistema-repro.webflow.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Inter:300,400,500,600,700","Raleway:300,400,500,600,700"]  }});</script>
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="{{ asset('images/favicon.png') }}" rel="shortcut icon" type="image/x-icon">
  <style>
  :focus-visible { outline: var(--mandarin) auto 1px; }
  .bad-wrap { position: fixed; visibility: hidden; }
  .search-input:placeholder-shown ~ .search-button { display: none; }
  .cookies-banner { display: none; }
  </style>
  <script async="" src="https://files.raketadesign.ru/files/sistema-repro/head.js" type="text/javascript"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@php
  $r = $resultsForView ?? ($testResult->results ?? []);
  $calcService = app(\App\Services\TestCalculationService::class);
  $hasCodings = !empty($r['has_codings']);
  $blockHasContent = $calcService->blocksWithRecommendationContent($r);
  $hasRecommendationsToShow = in_array(true, $blockHasContent, true);
  $answersRaw = $testResult->answers ?? [];
  $answersRaw = is_array($answersRaw) ? array_values($answersRaw) : [];
  $scoreExcellentProfile = count($answersRaw) === 24
      ? $calcService->isExcellentScoreProfile($answersRaw)
      : false;
  // Персональные абзацы важнее: при их наличии — аналитический вводный текст. Иначе — «на высоте» (при заполненной админке совпадает с $scoreExcellentProfile).
  $showPositiveHeroText = ! $hasRecommendationsToShow;
  $ibhb = $calcService->displayIbhbForResults($r);
  $allClearPhrases = $calcService->pickRandomAllClearPhrases();
  $icons = (array) (config('repro_test.block_icons') ?? []);
  $img = static function (?string $path): string {
      if (!$path) {
          return '';
      }
      if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
          return $path;
      }
      return asset($path);
  };
  $complexUrl = static function (string $alias, ?string $hash = null): string {
      $u = route('site.complex.show', ['alias' => $alias]);
      return $hash ? $u.'#'.$hash : $u;
  };
@endphp
  <div class="w-embed">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
  html { font-size: 1.333125rem; }
  @media screen and (max-width:1920px) { html { font-size: calc(0.0009480702515177741rem + 1.1101474414570685vw); } }
  @media screen and (max-width:767px) { html { font-size: calc(-0.0026705287206266314rem + 4.27284595300261vw); } }
  html { overflow-y: scroll; overflow-x: hidden; height: -webkit-fill-available; }
  @supports (scrollbar-gutter: stable) { html { overflow-y: auto; scrollbar-gutter: stable; } }
  body { min-height: 100vh; min-height: -webkit-fill-available; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
  @supports (font: -apple-system-body) and (-webkit-appearance: none) { img[loading="lazy"] { clip-path: inset(0.6px); } }
  .w-richtext > *:first-child { margin-top: 0; }
  .w-richtext > *:last-child { margin-bottom: 0; }
  .w-richtext figure img { border-radius: 1rem; }
  .w-richtext figure { --figure-width: 100%; width: var(--figure-width); max-width: var(--figure-width); }
  .w-richtext figure div, .w-richtext figure img { width: 100% !important; max-width: 100% !important; }
  ul li::marker { color: var(--lavender); }
  .o-span{ visibility: hidden; }
  .o-span::after {
		position: absolute;
    display: inline;
    content: ' ';
    left: 0.05em;
    top: 0em;
    background-color: currentColor;
    visibility: visible;
    height: 0.765em;
    width: auto;
    aspect-ratio: 70 / 47;
    mask-image: url('https://cdn.prod.website-files.com/67040316492967a9326aebb1/6704221050c6b216a7dee2a7_O.svg');
    mask-size: 100% 100%;
  }
  .search-input:focus ~ .search-icon, .search-input:not(:placeholder-shown)  ~ .search-icon { opacity: 1; }
  .search-input:not(:placeholder-shown)  ~ .search-button { display: block; }
  .tags::-webkit-scrollbar { display: none; }
  .tags { -ms-overflow-style: none;   scrollbar-width: none; }
	.events-card:last-child { border-bottom: none; }
  .white-cards .card, .white-cards .socials-card { background-color: var(--white); }
  input[name="search"]::placeholder { color: rgba(78, 81, 92, 0.4); }
  .step-item:hover .step-item-overlay { opacity: 0 !important; }
  .desktop-hyphen::after { content: '-'; }
  .home-buy-button:hover .home-buy-eapteka-logo { transform: scale(1.1); }
  .product-options-list .product-options-list-item:first-child { padding-top: 0; }
  .product-options-list .product-options-list-item:last-child { padding-bottom: 0; border-bottom: none;}
  .product-options-content > *:first-child { margin-top: 0; }
  .product-options-content > *:last-child { margin-bottom: 0; }
  .product-table .product-table-row:last-child{ border-bottom: none;}
  @media screen and (max-width:767px) {
  	.events-card-city::after { content: ', '; }
    .events-card-address-2::before { content: ', '; }
    .w-richtext figure { --figure-width: calc(100% + 2rem); }
    .desktop-hyphen::after { content: ''; }
    .mobile-hyphen::after { content: '-'; }
  }
</style>
  </div>
  <div data-animation="default" data-collapse="small" data-duration="400" data-easing="ease" data-easing2="ease" data-doc-height="1" role="banner" class="navbar w-nav">
    <div class="navbar-container w-container">
      <a href="{{ url('/') }}" class="brand w-nav-brand"><img src="{{ asset('images/lgog-gold.svg') }}" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
        <div>готовимся <br>к беременности <br>вместе</div>
      </a>
      <div class="nav-desktop-links">
        <a href="{{ route('site.text.about') }}" class="nav-quick-link">О системе РЕПРО</a>
        <a href="{{ route('site.products.index') }}" class="nav-quick-link">Продукты</a>
        <a href="{{ route('site.advises.index') }}" class="nav-quick-link">Полезные советы</a>
        <a href="{{ route('site.articles.index') }}" class="nav-quick-link">Статьи</a>
        <a href="{{ route('site.events.index') }}" class="nav-quick-link">События</a>
      </div>
      <a href="#" class="navbar-buy-button w-button">Купить</a>
      <div data-hover="true" data-delay="200" class="nav-dropdown w-dropdown">
        <div class="nav-dropdown-toggle w-dropdown-toggle">
          <div class="menu-button-icon w-icon-nav-menu"></div>
        </div>
        <nav class="nav-dropdown-list w-dropdown-list">
          <div class="nav-arrow-up w-embed"><svg width="100%" height="100%" viewbox="0 0 16 7.17157288" xmlns="http://www.w3.org/2000/svg"><path d="M9.41421356,0.585786438 L16,7.17157288 L16,7.17157288 L0,7.17157288 L6.58578644,0.585786438 C7.36683502,-0.195262146 8.63316498,-0.195262146 9.41421356,0.585786438 Z" fill="#8577B7"></path></svg></div>
          <div class="nav-menu-links">
            <a href="{{ route('site.products.index') }}" class="nav-link hide-desktop">Продукты</a>
            <a href="{{ route('site.events.index') }}" class="nav-link hide-desktop">События</a>
            <a href="{{ route('site.advises.index') }}" class="nav-link hide-desktop">Полезные советы</a>
            <a href="{{ route('site.articles.index') }}" class="nav-link hide-desktop">Статьи</a>
            <a href="{{ route('site.map') }}" class="nav-link">Где купить</a>
            <div class="nav-link-divider"></div>
            <a href="{{ route('site.text.company') }}" class="nav-link">О компании</a>
            <div class="nav-link-divider"></div>
            <a href="{{ route('site.text.contacts') }}" class="nav-link">Контакты</a>
          </div>
        </nav>
      </div>
      <nav role="navigation" class="nav-menu w-nav-menu">
        <div class="nav-menu-wrap">
          <div class="nav-menu-links">
            <a href="{{ route('site.products.index') }}" class="nav-link hide-desktop">Продукты</a>
            <a href="{{ route('site.events.index') }}" class="nav-link hide-desktop">События</a>
            <a href="{{ route('site.advises.index') }}" class="nav-link hide-desktop">Полезные советы</a>
            <a href="{{ route('site.articles.index') }}" class="nav-link hide-desktop">Статьи</a>
            <a href="{{ route('site.map') }}" class="nav-link">Где купить</a>
            <div class="nav-link-divider"></div>
            <a href="{{ route('site.text.company') }}" class="nav-link">О компании</a>
            <div class="nav-link-divider"></div>
            <a href="{{ route('site.text.contacts') }}" class="nav-link">Контакты</a>
          </div>
          <div class="nav-family-line"><img src="{{ asset('images/nav-family-line.svg') }}" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
          <div class="nav-contacts">
            <a href="tel:+74959567937" class="nav-contacts-phone">+7 495 956 79 37</a>
            <a href="mailto:info@reproapotheka.ru" class="nav-contacts-email">info@reproapotheka.ru</a>
            <a href="{{ url('/privacy') }}" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
          </div>
        </div>
      </nav>
      <div class="menu-button w-nav-button">
        <div class="menu-button-icon w-icon-nav-menu"></div>
      </div>
    </div>
    <div class="navbar-background"></div>
  </div>

  <section class="reprotest-results">
    <section class="section results-grad-section">
      <div class="container test-res-head">
        <img src="{{ asset('images/test-results/test-p.webp') }}" loading="lazy" alt="" class="test-res-head-img">
        <div class="test-res-hero-content">
          <h1 class="test-res-h1">Ваши персональные результаты</h1>
          @if (! $showPositiveHeroText)
          <p class="test-res-p">Мы проанализировали ваши ответы в&nbsp;тесте «Репродуктивное здоровье». Вот&nbsp;что происходит с&nbsp;вашим организмом, на что важно обратить внимание и&nbsp;какие шаги мы рекомендуем для&nbsp;улучшения вашего самочувствия.</p>
          @else
          <p class="test-res-p">Ваши результаты на&nbsp;высоте, это говорит о&nbsp;вашем внимании к&nbsp;себе и&nbsp;отличных привычках. Продолжайте в&nbsp;том же духе: поддерживайте баланс, прислушивайтесь к&nbsp;своему организму и&nbsp;не забывайте о&nbsp;поддержке.</p>
          @endif
        </div>
        <div class="test-score">
          <img src="{{ asset('images/test-results/test-heart.webp') }}" loading="lazy" alt="" class="test-score-img">
          <div class="test-score-description">{{ $ibhb }}%</div>
          <div class="test-score-value">индекс биоэнергетического и&nbsp;гормонального баланса </div>
        </div>
      </div>

      @for ($bn = 1; $bn <= 4; $bn++)
        @php
          $block = \Illuminate\Support\Arr::get($r, 'blocks.'.$bn, []);
          $block = is_array($block) ? $block : [];
          $blockIdx = (int) ($block['idx'] ?? \Illuminate\Support\Arr::get($r, 'IDX.'.$bn, 0));
          $hasPersonalText = ! empty($blockHasContent[$bn]);

          // Если ни у одного блока нет персонального текста — режим «всё в норме»: 100% и торжественные заголовки.
          if (! $hasRecommendationsToShow) {
              $idx = 100;
              $title = trim((string) config('repro_test.block_all_clear_titles.'.$bn, ''));
              if ($title === '') {
                  $title = (string) config('repro_test.block_titles.'.$bn, '');
              }
          } else {
              $idx = $blockIdx;
              $title = trim((string) ($block['title'] ?? ''));
              if ($title === '') {
                  $title = (string) config('repro_test.block_titles.'.$bn, '');
              }
          }
          $bcss = $block['css'] ?? config('repro_test.block_css.'.$bn, 'psih');
          $paragraphs = $block['paragraphs'] ?? [];
          $paragraphs = is_array($paragraphs) ? $paragraphs : [];
          $fields = $block['fields'] ?? [];
          $fields = is_array($fields) ? $fields : [];
          $phraseAllClear = ! $hasPersonalText
              ? trim((string) (\Illuminate\Support\Arr::get($allClearPhrases, $bn, \Illuminate\Support\Arr::get($allClearPhrases, (string) $bn, ''))))
              : '';
        @endphp
        <div class="container test-score-container">
          <img src="{{ $img(\Illuminate\Support\Arr::get($icons, $bn) ?: \Illuminate\Support\Arr::get($icons, (string) $bn)) }}" loading="lazy" alt="" class="test-score-icon">
          <div class="test-score-content">
            <div class="test-score-c-head">
              <h2 class="test-score-h">{{ $title }}</h2>
              <h2 class="test-score-percent {{ $bcss }}">{{ $idx }}%</h2>
            </div>
            <div class="test-score-progress">
              <div class="test-score-bar {{ $bcss }}" style="width: {{ min(100, max(0, $idx)) }}%;"></div>
            </div>
            @if($hasPersonalText && $hasCodings && count($paragraphs) > 0)
            <div class="test-score-decription">
              @foreach($paragraphs as $para)
                @php $para = trim((string) $para); @endphp
                @if($para !== '')
                <div class="test-res-p w-richtext">{!! $para !!}</div>
                @endif
              @endforeach
            </div>
            @elseif($hasPersonalText && $hasCodings && count($fields) > 0)
            <div class="test-score-decription">
              @foreach($fields as $fld)
                @php $para = trim((string) ($fld['description'] ?? '')); if ($para === '') { $para = trim((string) ($fld['email_description'] ?? '')); } @endphp
                @if($para !== '')
                <div class="test-res-p w-richtext">{!! $para !!}</div>
                @endif
              @endforeach
            </div>
            @elseif($phraseAllClear !== '')
            <div class="test-score-decription">
              <div class="test-res-p">{{ $phraseAllClear }}</div>
            </div>
            @endif
          </div>
        </div>
      @endfor
    </section>

    <div class="section">
      <div class="container reprotest-result-container">
        <div class="reprotest-cta">
          @if(!empty($preview))
            @if($hasRecommendationsToShow)
          <div class="reprotest-subscribe-wrap w-form">
            <p class="test-res-p" style="margin:0;opacity:0.75;">Предпросмотр вёрстки: форма подписки и отправка на почту отключены.</p>
          </div>
            @endif
          @elseif($hasRecommendationsToShow)
          <div class="reprotest-subscribe-wrap w-form">
            <form id="wf-form-Subscribe-Form" name="wf-form-Subscribe-Form" method="post" class="reprotest-form" action="{{ route('site.test.subscribe') }}">
              @csrf
              <div class="subscribe-head-label"><strong>Получите расширенный отчет на вашу электронную почту:</strong></div>
              <div class="reprotest-form-fields">
                <input class="text-field w-input" autocomplete="off" maxlength="256" name="subscribe_email" placeholder="Ваш Email*" type="email" id="subscribe_email" required>
                <input type="submit" data-wait="Секундочку..." class="reprotest-form-button w-button" value="Получить результат">
              </div>
              <label class="w-checkbox reprotest-subscribe-checkbox">
                <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                <input type="checkbox" name="agree" id="agree" required checked style="opacity:0;position:absolute;z-index:-1">
                <span class="subscribe-checkbox-label w-form-label" for="agree">Даю согласие на получение рассылки с&nbsp;сайта «Репробад» и соглашаюсь с&nbsp;<a href="{{ url('/privacy') }}" target="_blank" class="checkbox-link">правилами политики конфиденциальности в&nbsp;отношении персональных&nbsp;данных</a></span>
              </label>
              <input type="hidden" name="result_id" value="{{ $testResult->id }}">
            </form>
            <div class="subscribe-success w-form-done" style="display:none;">
              <div class="reprotest-succes"><img loading="lazy" src="{{ asset('images/success-icon.svg') }}" alt="" class="success-icon">
                <div>Результаты теста отправлены!</div>
              </div>
            </div>
            <div class="error-message reprotest-error-message w-form-fail" style="display:none;">
              <div>Произошла непредвиденная ошибка во время отправки формы!</div>
            </div>
          </div>
          @endif
          <div class="share">
            <a href="{{ route('site.test.reset') }}" class="reprotest-reset w-button"><strong>Пройти тест ещё раз —&gt;</strong></a>
            <div class="reprotest-share-buttons">
              <div class="a2a-code-embed w-embed w-script">
                <script async="" src="https://static.addtoany.com/menu/page.js"></script>
              </div>
              <div class="reprotest-share-label">Поделиться:</div>
              <div class="share-buttons a2a_kit" data-a2a-url="{{ url()->current() }}" data-a2a-title="{{ strip_tags($resource->title ?? '') }}">
                <a href="#" class="reprotest-share-button a2a_button_vk w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path></svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_odnoklassniki w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm2.88 16.586a5.597 5.597 0 0 1-5.76 0 1.278 1.278 0 0 0-1.727.38 1.185 1.185 0 0 0 .392 1.668 8.188 8.188 0 0 0 2.484.993l-2.391 2.308a1.18 1.18 0 0 0 0 1.71c.245.237.565.355.886.355.32 0 .642-.118.887-.354L16 21.377l2.35 2.269a1.284 1.284 0 0 0 1.772 0 1.18 1.18 0 0 0 0-1.71l-2.391-2.31a8.175 8.175 0 0 0 2.483-.992 1.185 1.185 0 0 0 .393-1.668 1.279 1.279 0 0 0-1.728-.38zM15.99 8c-2.36 0-4.278 1.852-4.278 4.13 0 2.275 1.918 4.127 4.277 4.127 2.36 0 4.277-1.852 4.277-4.128C20.266 9.852 18.348 8 15.99 8zm0 2.42c.976 0 1.77.766 1.77 1.71 0 .941-.794 1.708-1.77 1.708-.977 0-1.772-.767-1.772-1.709 0-.943.795-1.71 1.771-1.71z" fill="currentColor" fill-rule="evenodd"></path></svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_telegram w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path></svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_whatsapp w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M27.314 4.686c6.248 6.249 6.248 16.38 0 22.628-6.249 6.248-16.38 6.248-22.628 0-6.248-6.249-6.248-16.38 0-22.628 6.249-6.248 16.38-6.248 22.628 0zm-10.787 1.18c-5.244 0-9.512 4.268-9.514 9.514 0 1.677.437 3.314 1.27 4.757l-1.35 4.93 5.044-1.323a9.506 9.506 0 0 0 4.546 1.158c5.25-.002 9.516-4.27 9.518-9.514a9.456 9.456 0 0 0-2.784-6.731 9.453 9.453 0 0 0-6.73-2.79zm.003 1.608c2.113 0 4.098.824 5.591 2.319a7.86 7.86 0 0 1 2.314 5.594c-.002 4.36-3.55 7.908-7.908 7.908a7.899 7.899 0 0 1-4.028-1.102l-.288-.172-2.993.785.798-2.918-.188-.299a7.889 7.889 0 0 1-1.209-4.208c.002-4.36 3.55-7.907 7.911-7.907zm-3.371 3.512a.873.873 0 0 0-.634.298l-.17.185c-.269.307-.662.862-.662 1.798 0 1.024.652 2.017.895 2.356l.325.453c.543.736 1.916 2.421 3.812 3.24.567.245 1.01.391 1.355.5.57.182 1.088.156 1.497.095.457-.068 1.407-.575 1.605-1.13.198-.556.198-1.032.138-1.13-.033-.058-.1-.101-.195-.15l-1.15-.564a13.69 13.69 0 0 0-.735-.338c-.217-.08-.376-.119-.534.119-.159.238-.614.773-.753.932-.123.141-.247.172-.44.094l-.075-.034c-.238-.12-1.004-.37-1.912-1.18-.707-.63-1.184-1.41-1.322-1.647-.111-.19-.054-.311.034-.412l.07-.073c.107-.107.238-.278.356-.417.12-.139.159-.238.238-.396a.415.415 0 0 0 .004-.365l-.085-.19c-.149-.352-.507-1.23-.672-1.627-.141-.34-.284-.397-.408-.406l-.126-.002a9.442 9.442 0 0 0-.456-.009z" fill="currentColor" fill-rule="evenodd"></path></svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_copy_link w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 47.99996 47.99996" xmlns="http://www.w3.org/2000/svg"><path d="M40.97054,7.02942 C50.3431,16.40198 50.3431,31.59798 40.97054,40.97054 C31.59798,50.3431 16.40198,50.3431 7.02942,40.97054 C-2.34314,31.59798 -2.34314,16.40198 7.02942,7.02942 C16.40198,-2.34314 31.59798,-2.34314 40.97054,7.02942 Z M26.7297122,21.6573315 C24.4382627,18.5908384 20.0966443,17.9643212 17.0329817,20.2582837 C16.7678212,20.4568261 16.5172292,20.6741414 16.2831332,20.9085578 L12.8136987,24.381487 C10.1425928,27.1496298 10.2187854,31.5379328 12.9699932,34.1978064 C15.6544564,36.793151 19.910824,36.7931509 22.5952871,34.1978062 L24.5871262,32.2042053 C25.0337839,31.7570977 25.0334192,31.0325577 24.5863116,30.5859 C24.1392039,30.1392423 23.414664,30.139607 22.9680063,30.5867146 L20.9903454,32.5663675 C19.2071679,34.2901071 16.3581124,34.2901071 14.5607565,32.5524197 C12.7176388,30.7704896 12.6665805,27.8297937 14.4467514,25.9847862 L17.902399,22.5259024 C18.0593226,22.368764 18.2271409,22.2232307 18.4047096,22.0902738 C20.4557829,20.5545024 23.3619805,20.9738813 24.896395,23.0272852 C25.2746973,23.5335418 25.9917739,23.6372692 26.4980305,23.258967 C27.004287,22.8806647 27.1080145,22.163588 26.7297122,21.6573315 Z M34.0300068,12.8021936 C31.3455436,10.2068489 27.0891759,10.2068491 24.4047129,12.8021941 L22.4036698,14.7934382 C21.9557105,15.2392417 21.9539629,15.9637796 22.3997664,16.4117389 C22.8455699,16.8596982 23.5701078,16.8614459 24.0180671,16.4156424 L26.0072933,14.4359895 C27.7928321,12.7098929 30.6418876,12.7098928 32.4392435,14.4475802 C34.2823612,16.2295103 34.3334195,19.1702063 32.5532484,21.0152139 L29.0976009,24.4740977 C28.9406773,24.6312361 28.772859,24.7767694 28.5952902,24.9097263 C26.544217,26.4454977 23.6380194,26.0261188 22.1036049,23.972715 C21.7253026,23.4664584 21.008226,23.362731 20.5019694,23.7410333 C19.9957129,24.1193356 19.8919855,24.8364122 20.2702877,25.3426688 C22.5617372,28.4091617 26.9033556,29.0356789 29.9670182,26.7417164 C30.2321787,26.543174 30.4827706,26.3258587 30.7168667,26.0914423 L34.1863012,22.6185131 C36.8574072,19.8503702 36.7812147,15.4620672 34.0300068,12.8021936 Z" fill="currentColor"></path></svg></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="section reprotest-about">
      <div class="heart-bg reprotest-section"><img sizes="(max-width: 2000px) 100vw, 2000px" srcset="{{ asset('images/heart_1-p-500.webp') }} 500w, {{ asset('images/heart_1-p-800.webp') }} 800w, {{ asset('images/heart_1-p-1080.webp') }} 1080w, {{ asset('images/heart_1-p-1600.webp') }} 1600w, {{ asset('images/heart_1.webp') }} 2000w" alt="" loading="lazy" src="{{ asset('images/heart_1.webp') }}" class="heart-bg-image"></div>
      <div class="container">
        <div class="sr-heading-reprotest">
          <h2 class="sistema-repro-h1 srh1-reprotest"><span class="sistema-repro-semibold">СИСТЕМА РЕПР</span><span class="o-span"><strong>О</strong></span> </h2>
          <p class="sistema-repro-p">Система РЕПРО — это программа, которая нормализует дефициты и помогает восстановить важные функции в&nbsp;организме женщины и мужчины, может повысить шансы на успешное зачатие, в&nbsp;том числе методом ЭКО.</p>
          <p class="reprotest-small-p">(с применением вспомогательных репродуктивных технологий)</p>
        </div>
      </div>
      <div class="container">
        <div class="reprotest-block rtb-advs">
          <div class="reprotest-adv-wrap">
            <h2 class="reprotest-adv-h2">Позаботьтесь о вашем организме с системой РЕПРО!</h2>
            <p class="reprotest-big-p-2">Программа подойдет и тем, кто не&nbsp;планирует беременность, но хочет понимать, что&nbsp;организм работает как&nbsp;часы.</p>
            <p class="reprotest-p">Восстановление проходит на&nbsp;нескольких этапах:</p>
          </div>
          <div class="reprotest-adv-grid">
            <div class="div-block"><img src="{{ asset('images/test/reprotest-ic-1.svg') }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Психоэмоциональное состояние</h3>
              <p class="reprotest-p">Защита от стресса и&nbsp;нормализация&nbsp;сна</p>
            </div>
            <div><img src="{{ asset('images/test/reprotest-ic-2.svg') }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Микрофлора кишечника и детоксикация</h3>
              <p class="reprotest-p">Нормализация кишечной микрофлоры и поддержка печени</p>
            </div>
            <div><img src="{{ asset('images/test/reprotest-ic-3.svg') }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Метаболизм и энергия</h3>
              <p class="reprotest-p">Коррекция энергетического обмена и&nbsp;нормализация метаболизма</p>
            </div>
            <div><img src="{{ asset('images/test/reprotest-ic-4.svg') }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h"><strong>Репродуктивное здоровье</strong></h3>
              <p class="reprotest-p">Поддержка репродуктивной функции</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section test-res-prod-section">
      <div class="container">
        <div class="test-res-items">
          <div class="test-res-item"><img src="{{ asset('images/1.svg') }}" loading="lazy" alt="" class="step-item-number">
            <div class="step-item-content">
              <h2 class="step-h">Психоэмоциональное состояние</h2>
              <p class="step-description">Защита от стресса и&nbsp;нормализация сна</p>
              <div class="step-products">
                <a href="{{ $complexUrl('protect', 'first') }}" class="step-product-left w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-relax-1.webp') }}" loading="lazy" alt="РЕПРО РЕЛАКС" class="sache-image"></div>
                  <div class="step-product-shadow"></div>
                </a>
                <a href="{{ $complexUrl('protect', 'second') }}" class="step-product-right w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-relax-2.webp') }}" loading="lazy" alt="РЕПРО РЕЛАКС" class="sache-image"></div>
                  <div class="step-product-shadow gipokortizol"></div>
                </a>
              </div>
              <a href="{{ $complexUrl('protect') }}" class="step-button w-button">Подробнее —&gt;</a>
            </div>
            <div class="step-item-overlay"></div>
          </div>
          <div class="test-res-item _2"><img src="{{ asset('images/2.svg') }}" loading="lazy" alt="" class="step-item-number">
            <div class="step-item-content">
              <h2 class="step-h">Микрофлора кишечника и детоксикация</h2>
              <p class="step-description">Нормализация кишечной микрофлоры и поддержка печени</p>
              <div class="step-products">
                <a href="{{ $complexUrl('detoxi', 'first') }}" class="step-product-left w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-detoxi.webp') }}" loading="lazy" alt="РЕПРО ДЕТОКСИ" class="sache-image"></div>
                  <div class="step-product-shadow detoxi"></div>
                </a>
                <a href="{{ $complexUrl('detoxi', 'second') }}" class="step-product-right w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-biom.webp') }}" loading="lazy" alt="РЕПРО БИОМ" class="sache-image"></div>
                  <div class="step-product-shadow biom"></div>
                </a>
              </div>
              <a href="{{ $complexUrl('detoxi') }}" class="step-button _2 w-button">Подробнее —&gt;</a>
            </div>
            <div class="step-item-overlay _2"></div>
          </div>
          <div class="test-res-item _3"><img src="{{ asset('images/3.svg') }}" loading="lazy" alt="" class="step-item-number">
            <div class="step-item-content">
              <h2 class="step-h">Метаболизм и энергия</h2>
              <p class="step-description">Коррекция энергетического обмена и нормализация метаболизма</p>
              <div class="step-products">
                <a href="{{ $complexUrl('energy', 'first') }}" class="step-product-left w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-metabo.webp') }}" loading="lazy" alt="РЕПРО МЕТАБО" class="sache-image"></div>
                  <div class="step-product-shadow metabo"></div>
                </a>
                <a href="{{ $complexUrl('energy', 'second') }}" class="step-product-right w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-energy.webp') }}" loading="lazy" alt="РЕПРО ЭНЕРДЖИ" class="sache-image"></div>
                  <div class="step-product-shadow energy"></div>
                </a>
              </div>
              <a href="{{ $complexUrl('energy') }}" class="step-button _3 w-button">Подробнее —&gt;</a>
            </div>
            <div class="step-item-overlay _3"></div>
          </div>
          <div class="test-res-item _4"><img src="{{ asset('images/4.svg') }}" loading="lazy" alt="" class="step-item-number">
            <div class="step-item-content">
              <h2 class="step-h">Репродуктивное здоровье</h2>
              <p class="step-description">Поддержка репродуктивного здоровья</p>
              <div class="step-products">
                <a href="{{ $complexUrl('embrio', 'first') }}" class="step-product-left repro-embrio w-inline-block">
                  <div class="sache-image-element"><img src="{{ asset('images/sache.webp') }}" loading="lazy" alt="" class="sache-overlay"><img src="{{ asset('images/repro-embrio.webp') }}" loading="lazy" alt="РЕПРО ЭМБРИО" class="sache-image"></div>
                  <div class="step-product-shadow embrio"></div>
                </a>
                <a href="{{ $complexUrl('embrio', 'second') }}" class="step-product-right repro-genom w-inline-block">
                  <div class="bottle-image-element"><img loading="lazy" src="{{ asset('images/repro-genom.webp') }}" alt="" class="bottle-image"></div>
                </a>
              </div>
              <a href="{{ $complexUrl('embrio') }}" class="step-button _4 w-button">Подробнее —&gt;</a>
            </div>
            <div class="step-item-overlay _4"></div>
          </div>
        </div>
      </div>
    </section>
  </section>

  <div class="spacer desktop-3-rem"></div>
  @include('site.test._footer')

  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=67040316492967a9326aebb1" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/webflow.js') }}" type="text/javascript"></script>
  <script>
  (function($) {
    $('#wf-form-Subscribe-Form').on('submit', function(e) {
      e.preventDefault();
      var form = $(this);
      $.ajax({
        url: form.attr('action'),
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
          email: form.find('[name="subscribe_email"]').val(),
          agree: form.find('[name="agree"]').is(':checked') ? 1 : 0,
          result_id: form.find('[name="result_id"]').val()
        },
        success: function(response) {
          if (response.success) {
            $('.subscribe-success').show();
            $('.reprotest-error-message').hide();
            form.hide();
          }
        },
        error: function() {
          $('.reprotest-error-message').show();
        }
      });
    });
  })(jQuery);
  </script>
</body>
</html>
