<!DOCTYPE html><!--  This site was created in Webflow. https://webflow.com  --><!--  Last Published: Mon Feb 02 2026 10:40:57 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="697729df64c8f65c7ff4c2e1" data-wf-site="67040316492967a9326aebb1">
<head>
  <meta charset="utf-8">
  <title>Тест «Репродуктивное здоровье»</title>
  <meta content="Тест «Репродуктивное здоровье»" property="og:title">
  <meta content="Тест «Репродуктивное здоровье»" property="twitter:title">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="{{ asset("css/normalize.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("css/webflow.css") }}" rel="stylesheet" type="text/css">
  <link href="{{ asset("css/sistema-repro.webflow.css") }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Inter:300,400,500,600,700","Raleway:300,400,500,600,700"]  }});</script>
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.jpg" rel="apple-touch-icon">
  <style>
  :focus-visible { outline: var(--mandarin) auto 1px; }
  .bad-wrap { position: fixed; visibility: hidden; }
  .search-input:placeholder-shown ~ .search-button { display: none; }
  .cookies-banner { display: none; }
</style>
  <script async="" src="https://files.raketadesign.ru/files/sistema-repro/head.js" type="text/javascript"></script>
  <style>
	.reprotest-slides { display: block; }
  .reprotest-questions { display: none; }
  .reprotest-final { display: none; }
  .reprotest-arrow-button.disabled {
    opacity: 0.3;
    cursor: not-allowed;
    pointer-events: none;
  }
  .reprotest-arrow-button:not(.disabled) {
    cursor: pointer;
  }
  /* Убираем тень у изображений продуктов на странице теста */
  .reprotest-products .sache-image-element,
  .reprotest-products .sache-image {
    box-shadow: none !important;
  }
  .reprotest-products .product-item-image-shadow {
    display: none !important;
  }
</style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
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
  .w-richtext figure div, .w-richtext figure img { width: 100% !important; !important; max-width: 100% !important; }
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
      <a href="{{ url('/') }}" class="brand w-nav-brand"><img src="{{ asset("images/lgog-gold.svg") }}" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="navbar-logo">
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
          <div class="nav-arrow-up w-embed"><svg width="100%" height="100%" viewbox="0 0 16 7.17157288" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <path d="M9.41421356,0.585786438 L16,7.17157288 L16,7.17157288 L0,7.17157288 L6.58578644,0.585786438 C7.36683502,-0.195262146 8.63316498,-0.195262146 9.41421356,0.585786438 Z" id="Rectangle" fill="#8577B7"></path>
            </svg></div>
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
          <div class="nav-family-line"><img src="{{ asset("images/nav-family-line.svg") }}" loading="lazy" alt="СИСТЕМА РЕПРО" class="nav-family-image"></div>
          <div class="nav-contacts">
            <a href="tel:+74959567937" class="nav-contacts-phone">+7 495 956 79 37</a>
            <a href="mailto:info@reproapotheka.ru" class="nav-contacts-email">info@reproapotheka.ru</a>
            <a href="/privacy" target="_blank" class="nav-contacts-legal">Политика конфиденциальности <br>в отношении персональных данных</a>
          </div>
        </div>
      </nav>
      <div class="menu-button w-nav-button">
        <div class="menu-button-icon w-icon-nav-menu"></div>
      </div>
    </div>
    <div class="navbar-background"></div>
  </div>
  <div class="w-embed">
    <style>
.reprotest-selected::after {
	content: ' ';
  display: block;
  position: absolute;
  background: url('https://cdn.prod.website-files.com/67040316492967a9326aebb1/69776df8fcdec6127c9d4f67_reprotest-white-check.svg');
  background-repeat: no-repeat;
  background-size: contain;
  background-position: center;
  width: 1.5rem;
  height: 1.5rem;
  right: 0.375rem;
  top: 0.375rem;
}
@media screen and (max-width: 767px) {
	.reprotest-selected::after {
  width: 1.25rem;
  height: 100%;
  top: 0px;
  right: 0.5rem;
  left: auto;
  bottom: 0px;
  }
}
</style>
  </div>
  <section class="section">
    <div class="container">
      <div class="reprotest-intro-block">
        <div class="reprotest-intro">
          <h1 class="reprotest-h"><span class="inline-text-block">Пройдите тест </span>«Репродуктивное здоровье»</h1>
          <p class="reprotest-big-p">Ответьте на 24 вопроса, получите оценку по важным категориям вашего здоровья:</p>
          <div class="reprotest-list">
            <div class="reprotest-list-item"><img src="{{ asset("images/test/reprotest-check.svg") }}" loading="lazy" alt="" class="reprotest-check">
              <p class="reprotest-list-p">Психоэмоциональное состояние</p>
            </div>
            <div class="reprotest-list-item"><img src="{{ asset("images/test/reprotest-check.svg") }}" loading="lazy" alt="" class="reprotest-check">
              <p class="reprotest-list-p"><strong>Микрофлора кишечника и детоксикация</strong></p>
            </div>
            <div class="reprotest-list-item"><img src="{{ asset("images/test/reprotest-check.svg") }}" loading="lazy" alt="" class="reprotest-check">
              <p class="reprotest-list-p"><strong>Метаболизм и энергия</strong></p>
            </div>
            <div class="reprotest-list-item"><img src="{{ asset("images/test/reprotest-check.svg") }}" loading="lazy" alt="" class="reprotest-check">
              <p class="reprotest-list-p"><strong>Репродуктивное здоровье</strong></p>
            </div>
          </div><img src="{{ asset("images/test/test-cover.webp") }}" loading="lazy" sizes="100vw" srcset="{{ asset("images/test/test-cover-p-500.webp") }} 500w, {{ asset("images/test/test-cover-p-800.webp") }} 800w, {{ asset("images/test/test-cover.webp") }} 1036w" alt="" class="reprotest-cover-image">
          <a href="#" class="reproptest-button w-button"><strong>Пройти тест</strong> —&gt;</a>
        </div>
      </div>
      <div class="reprotest-questions">
        <div class="reprotest-block">
          <div class="reprotest-block-h">
            <h2 class="reprotest-h">Тест «Репродуктивное здоровье»</h2>
            <a href="#" class="reprotest-arrow-button reprotest-arrow-left w-inline-block"><img src="{{ asset("images/l-arr.svg") }}" loading="lazy" alt="" class="slider-arrow"></a>
            <a href="#" class="reprotest-arrow-button reprotest-arrow-right w-inline-block"><img src="{{ asset("images/r-arr.svg") }}" loading="lazy" alt="" class="slider-arrow"></a>
          </div>
          <div class="reprotest-progress">
            <div class="reprotest-progress-bar"></div>
          </div>
          <div class="reprotest-slides">
            @if(isset($questions) && $questions->count() > 0)
              @foreach($questions as $index => $question)
                <div class="reprotest-question-slide" data-question="{{ $index }}">
                  <div class="reprotest-question-counter">{{ str_pad($question->order, 2, '0', STR_PAD_LEFT) }}/{{ $questions->count() }}</div>
                  <div class="reprotest-question-content">
                    <p class="reprotest-question-text">{!! $question->question_text !!}</p>
                    <div class="reprotest-slide-buttons">
                      @if(is_array($question->answers))
                        @foreach($question->answers as $answerIndex => $answer)
                          <a href="#" class="reprotest-slide-button w-inline-block {{ $answerIndex === 0 && $index === 0 ? 'reprotest-selected' : '' }}" data-value="{{ $answer['value'] ?? 0 }}">
                            <div class="reprotest-button-text">{{ $answer['text'] ?? '' }}</div>
                          </a>
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            @else
              <div class="reprotest-question-slide">
                <div class="reprotest-question-content">
                  <p class="reprotest-question-text">Вопросы теста не настроены. Пожалуйста, добавьте вопросы в админ-панели.</p>
                </div>
              </div>
            @endif
        </div>
      </div>
    </div>
  </section>
  <section class="reprotest-final">
    <div class="section">
      <div class="container reprotest-result-container">
        <div class="reprotest-result">
          <div class="reprotest-block">
            <h2 class="reprotest-h">Тест «Репродуктивное здоровье» пройден</h2>
            <div class="reprotest-progress rp-full"></div>
            <div class="reprotest-block-message">
              <p class="reprotest-big-p">Ознакомьтесь с рекомендациями:</p>
              <p class="reprotest-p">Основываясь на ваших ответах, мы подготовили для вас персональные рекомендации. Они помогут понять, какие добавки могут быть полезны именно вам.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="reprotest-cta" style="margin-top: 40px;">
          <div class="reprotest-subscribe-wrap w-form">
            <form id="wf-form-Subscribe-Form" name="wf-form-Subscribe-Form" data-name="Subscribe Form" method="POST" action="{{ route('site.test.subscribe') }}" class="reprotest-form" data-wf-page-id="697729df64c8f65c7ff4c2e1" data-wf-element-id="b0b44bde-be5e-77b8-b20d-3dd8764fe2ad">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="subscribe-head-label"><strong>Получите расширенный ответ на вашу электронную почту:</strong></div>
              <div class="reprotest-form-fields"><input class="text-field w-input" autocomplete="off" maxlength="256" name="subscribe_email" data-name="subscribe_email" placeholder="Ваш Email*" type="email" id="subscribe_email"><input type="submit" data-wait="Секундочку..." class="reprotest-form-button w-button" value="Получить результат"></div><label class="w-checkbox reprotest-subscribe-checkbox">
                <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div><input type="checkbox" name="agree" id="agree" data-name="agree" required="" style="opacity:0;position:absolute;z-index:-1" checked=""><span class="subscribe-checkbox-label w-form-label" for="agree">Даю согласие на получение рассылки с сайта «Репробад» и соглашаюсь с <a href="/privacy" target="_blank" class="checkbox-link">правилами политики конфиденциальности в отношении персональных данных</a></span>
              </label>
            </form>
            <div class="subscribe-success w-form-done" style="display: none;">
              <div class="reprotest-succes"><img loading="lazy" src="{{ asset("images/success-icon.svg") }}" alt="" class="success-icon">
                <div>Результаты теста отправлены!</div>
              </div>
            </div>
            <div class="error-message reprotest-error-message w-form-fail" style="display: none;">
              <div>Произошла непредвиденная ошибка во время отправки формы!</div>
            </div>
          </div>
          <div class="share">
            <a href="#" class="reprotest-reset w-button"><strong>Пройти тест ещё раз —&gt;</strong></a>
            <div class="reprotest-share-buttons">
              <div class="a2a-code-embed w-embed w-script">
                <script async="" src="https://static.addtoany.com/menu/page.js"></script>
              </div>
              <div class="reprotest-share-label">Поделиться:</div>
              <div class="share-buttons a2a_kit">
                <a href="#" class="reprotest-share-button a2a_button_vk w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_odnoklassniki w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                      <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm2.88 16.586a5.597 5.597 0 0 1-5.76 0 1.278 1.278 0 0 0-1.727.38 1.185 1.185 0 0 0 .392 1.668 8.188 8.188 0 0 0 2.484.993l-2.391 2.308a1.18 1.18 0 0 0 0 1.71c.245.237.565.355.886.355.32 0 .642-.118.887-.354L16 21.377l2.35 2.269a1.284 1.284 0 0 0 1.772 0 1.18 1.18 0 0 0 0-1.71l-2.391-2.31a8.175 8.175 0 0 0 2.483-.992 1.185 1.185 0 0 0 .393-1.668 1.279 1.279 0 0 0-1.728-.38zM15.99 8c-2.36 0-4.278 1.852-4.278 4.13 0 2.275 1.918 4.127 4.277 4.127 2.36 0 4.277-1.852 4.277-4.128C20.266 9.852 18.348 8 15.99 8zm0 2.42c.976 0 1.77.766 1.77 1.71 0 .941-.794 1.708-1.77 1.708-.977 0-1.772-.767-1.772-1.709 0-.943.795-1.71 1.771-1.71z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_telegram w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                      <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_whatsapp w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                      <path d="M27.314 4.686c6.248 6.249 6.248 16.38 0 22.628-6.249 6.248-16.38 6.248-22.628 0-6.248-6.249-6.248-16.38 0-22.628 6.249-6.248 16.38-6.248 22.628 0zm-10.787 1.18c-5.244 0-9.512 4.268-9.514 9.514 0 1.677.437 3.314 1.27 4.757l-1.35 4.93 5.044-1.323a9.506 9.506 0 0 0 4.546 1.158c5.25-.002 9.516-4.27 9.518-9.514a9.456 9.456 0 0 0-2.784-6.731 9.453 9.453 0 0 0-6.73-2.79zm.003 1.608c2.113 0 4.098.824 5.591 2.319a7.86 7.86 0 0 1 2.314 5.594c-.002 4.36-3.55 7.908-7.908 7.908a7.899 7.899 0 0 1-4.028-1.102l-.288-.172-2.993.785.798-2.918-.188-.299a7.889 7.889 0 0 1-1.209-4.208c.002-4.36 3.55-7.907 7.911-7.907zm-3.371 3.512a.873.873 0 0 0-.634.298l-.17.185c-.269.307-.662.862-.662 1.798 0 1.024.652 2.017.895 2.356l.325.453c.543.736 1.916 2.421 3.812 3.24.567.245 1.01.391 1.355.5.57.182 1.088.156 1.497.095.457-.068 1.407-.575 1.605-1.13.198-.556.198-1.032.138-1.13-.033-.058-.1-.101-.195-.15l-1.15-.564a13.69 13.69 0 0 0-.735-.338c-.217-.08-.376-.119-.534.119-.159.238-.614.773-.753.932-.123.141-.247.172-.44.094l-.075-.034c-.238-.12-1.004-.37-1.912-1.18-.707-.63-1.184-1.41-1.322-1.647-.111-.19-.054-.311.034-.412l.07-.073c.107-.107.238-.278.356-.417.12-.139.159-.238.238-.396a.415.415 0 0 0 .004-.365l-.085-.19c-.149-.352-.507-1.23-.672-1.627-.141-.34-.284-.397-.408-.406l-.126-.002a9.442 9.442 0 0 0-.456-.009z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg></div>
                </a>
                <a href="#" class="reprotest-share-button a2a_button_copy_link w-inline-block">
                  <div class="card-social-icon reprotest-size w-embed"><svg width="100%" height="100%" viewbox="0 0 47.99996 47.99996" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                      <path d="M40.97054,7.02942 C50.3431,16.40198 50.3431,31.59798 40.97054,40.97054 C31.59798,50.3431 16.40198,50.3431 7.02942,40.97054 C-2.34314,31.59798 -2.34314,16.40198 7.02942,7.02942 C16.40198,-2.34314 31.59798,-2.34314 40.97054,7.02942 Z M26.7297122,21.6573315 C24.4382627,18.5908384 20.0966443,17.9643212 17.0329817,20.2582837 C16.7678212,20.4568261 16.5172292,20.6741414 16.2831332,20.9085578 L12.8136987,24.381487 C10.1425928,27.1496298 10.2187854,31.5379328 12.9699932,34.1978064 C15.6544564,36.793151 19.910824,36.7931509 22.5952871,34.1978062 L24.5871262,32.2042053 C25.0337839,31.7570977 25.0334192,31.0325577 24.5863116,30.5859 C24.1392039,30.1392423 23.414664,30.139607 22.9680063,30.5867146 L20.9903454,32.5663675 C19.2071679,34.2901071 16.3581124,34.2901071 14.5607565,32.5524197 C12.7176388,30.7704896 12.6665805,27.8297937 14.4467514,25.9847862 L17.902399,22.5259024 C18.0593226,22.368764 18.2271409,22.2232307 18.4047096,22.0902738 C20.4557829,20.5545024 23.3619805,20.9738813 24.896395,23.0272852 C25.2746973,23.5335418 25.9917739,23.6372692 26.4980305,23.258967 C27.004287,22.8806647 27.1080145,22.163588 26.7297122,21.6573315 Z M34.0300068,12.8021936 C31.3455436,10.2068489 27.0891759,10.2068491 24.4047129,12.8021941 L22.4036698,14.7934382 C21.9557105,15.2392417 21.9539629,15.9637796 22.3997664,16.4117389 C22.8455699,16.8596982 23.5701078,16.8614459 24.0180671,16.4156424 L26.0072933,14.4359895 C27.7928321,12.7098929 30.6418876,12.7098928 32.4392435,14.4475802 C34.2823612,16.2295103 34.3334195,19.1702063 32.5532484,21.0152139 L29.0976009,24.4740977 C28.9406773,24.6312361 28.772859,24.7767694 28.5952902,24.9097263 C26.544217,26.4454977 23.6380194,26.0261188 22.1036049,23.972715 C21.7253026,23.4664584 21.008226,23.362731 20.5019694,23.7410333 C19.9957129,24.1193356 19.8919855,24.8364122 20.2702877,25.3426688 C22.5617372,28.4091617 26.9033556,29.0356789 29.9670182,26.7417164 C30.2321787,26.543174 30.4827706,26.3258587 30.7168667,26.0914423 L34.1863012,22.6185131 C36.8574072,19.8503702 36.7812147,15.4620672 34.0300068,12.8021936 Z" id="Shape" fill="currentColor"></path>
                    </svg></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    <section class="section reprotest-about">
      <div class="heart-bg reprotest-section"><img sizes="100vw" srcset="{{ asset("images/heart_1-p-500.webp 500w, images/heart_1-p-800.webp 800w, images/heart_1-p-1080.webp 1080w, images/heart_1-p-1600.webp 1600w, images/heart_1.webp 2000w") }}" alt="" src="{{ asset("images/heart_1.webp") }}" loading="lazy" class="heart-bg-image"></div>
      <div class="container">
        <div class="reprotest-block rtb-advs">
          <div class="reprotest-adv-wrap">
            <h2 class="reprotest-adv-h2">Позаботьтесь о вашем организме с Системой РЕПРО!</h2>
            <p class="reprotest-big-p-2">Программа подойдет и тем, кто не планирует беременность, но хочет понимать, что организм работает как часы.</p>
            <p class="reprotest-big-p-2">Система рекомендаций от линейки продуктов РЕПРО – это программа, которая нормализует дефициты и помогает восстановить важные функции в организме женщины и мужчины, может повысить шансы на успешное зачатие, в том числе методом ЭКО (с применением вспомогательных репродуктивных технологий).</p>
            <p class="reprotest-big-p-2">Программа подойдет и тем, кто не планирует беременность, но хочет понимать, что организм работает как часы.</p>
            <p class="reprotest-p">Восстановление проходит на нескольких этапах:</p>
          </div>
          <div class="reprotest-adv-grid">
            <div class="div-block"><img src="{{ asset("images/test/reprotest-ic-1.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Психоэмоциональное равновесие</h3>
              <p class="reprotest-p">Защита от стресса и нормализация сна</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-2.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Очищение организма</h3>
              <p class="reprotest-p">Нормализация кишечной микрофлоры и поддержка печени</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-3.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Общий метаболизм и углеводный обмен</h3>
              <p class="reprotest-p">Коррекция энергетического обмена и нормализация метаболизма</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-4.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h"><strong>Репродуктивное здоровье</strong></h3>
              <p class="reprotest-p">Поддержка репродуктивной функции</p>
            </div>
          </div>
          <div style="margin-top: 2rem; text-align: left;">
            <a href="https://reprobad.com/" class="button short-event-button w-button">Подробнее о продуктах</a>
          </div>
        </div>
      </div>
    </section>
  </section>
  <div class="spacer desktop-3-rem"></div>
  <section class="footer-section">
    <div class="footer-container">
      <a href="/" class="footer-logo-link w-inline-block"><img src="{{ asset("images/logo-black.svg") }}" loading="lazy" alt="РЕПРО АПОТЕКА • REPRO APOTHEKA" class="footer-logo"></a>
      <div class="footer-contacts">
        <div>
          <a href="tel:+74959567937" class="footer-phone">+7 495 956 79 37</a>
          <a href="mailto:info@reproapotheka.ru" class="footer-email">info@reproapotheka.ru</a>
        </div>
        <div class="social-icons">
          <a href="https://rutube.ru/channel/48557140/" target="_blank" class="social-link w-inline-block">
            <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path d="M16,0 C24.8365333,0 32,7.16346667 32,16 C32,24.8365333 24.8365333,32 16,32 C7.16346667,32 0,24.8365333 0,16 C0,7.16346667 7.16346667,0 16,0 Z M17.3874716,11.1336625 L8,11.1336625 L8,22 L10.6670977,22 L10.6670977,18.4647589 L15.5822937,18.4647589 L17.9145854,22 L20.9011635,22 L18.3298027,18.4481815 C19.2778351,18.3046561 19.7034381,18.0081168 20.0546093,17.5191924 C20.4056724,17.0303334 20.5816907,16.2487305 20.5816907,15.205619 L20.5816907,14.3908285 C20.5816907,13.7721859 20.5175365,13.283316 20.4056724,12.908612 C20.2937,12.533919 20.1024275,12.2080094 19.8307729,11.9152655 C19.5437559,11.6381501 19.2241749,11.4429839 18.840548,11.3122296 C18.5118176,11.214373 18.1127443,11.1523653 17.6337017,11.1366459 L17.3874716,11.1336625 Z M16.9560265,13.5292178 C17.3233715,13.5292178 17.5787983,13.5945895 17.7069877,13.7087555 C17.835177,13.8229324 17.9145854,14.034676 17.9145854,14.3439973 L17.9145854,15.2563545 C17.9145854,15.5822642 17.835177,15.7940078 17.7069877,15.9081738 C17.597111,16.0060397 17.3937539,16.0558614 17.1065633,16.0680989 L16.9560265,16.0701634 L10.6670977,16.0701634 L10.6670977,13.5292178 L16.9560265,13.5292178 Z M22.9510686,7 C21.8193366,7 20.9020289,7.92512727 20.9020289,9.06631813 C20.9020289,10.2075199 21.8193366,11.1326374 22.9510686,11.1326374 C24.0826923,11.1326374 25,10.2075199 25,9.06631813 C25,7.92512727 24.0826923,7 22.9510686,7 Z" fill="currentColor"></path>
              </svg></div>
          </a>
          <a href="https://t.me/reprobad" target="_blank" class="social-link w-inline-block">
            <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path d="m15.788 21.065-2.45-1.81 7.42-6.696c.326-.289-.071-.43-.503-.167l-9.157 5.776-3.955-1.234c-.854-.262-.86-.849.192-1.27L22.747 9.72c.704-.32 1.383.169 1.114 1.246l-2.624 12.368c-.184.88-.715 1.09-1.45.684l-3.999-2.954zM16 32c8.837 0 16-7.163 16-16S24.837 0 16 0 0 7.163 0 16s7.163 16 16 16z" fill="currentColor" fill-rule="evenodd"></path>
              </svg></div>
          </a>
          <a href="https://ok.ru/group/70000030861851" class="social-link w-inline-block">
            <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm2.88 16.586a5.597 5.597 0 0 1-5.76 0 1.278 1.278 0 0 0-1.727.38 1.185 1.185 0 0 0 .392 1.668 8.188 8.188 0 0 0 2.484.993l-2.391 2.308a1.18 1.18 0 0 0 0 1.71c.245.237.565.355.886.355.32 0 .642-.118.887-.354L16 21.377l2.35 2.269a1.284 1.284 0 0 0 1.772 0 1.18 1.18 0 0 0 0-1.71l-2.391-2.31a8.175 8.175 0 0 0 2.483-.992 1.185 1.185 0 0 0 .393-1.668 1.279 1.279 0 0 0-1.728-.38zM15.99 8c-2.36 0-4.278 1.852-4.278 4.13 0 2.275 1.918 4.127 4.277 4.127 2.36 0 4.277-1.852 4.277-4.128C20.266 9.852 18.348 8 15.99 8zm0 2.42c.976 0 1.77.766 1.77 1.71 0 .941-.794 1.708-1.77 1.708-.977 0-1.772-.767-1.772-1.709 0-.943.795-1.71 1.771-1.71z" fill="currentColor" fill-rule="evenodd"></path>
              </svg></div>
          </a>
          <a href="https://vk.com/club228615718" target="_blank" class="social-link w-inline-block">
            <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm-2.456 11.95c-.292.14-.518.452-.38.47.17.022.554.102.757.374.197.262.241.768.251 1.008l.019.475c.019.624.009 1.897-.37 2.1-.334.178-.788-.17-1.741-1.758l-.097-.163a15.532 15.532 0 0 1-.814-1.622l-.102-.242s-.076-.182-.212-.28c-.164-.12-.394-.156-.394-.156l-2.438.015s-.366.01-.5.167c-.096.11-.045.317-.02.395l.04.1c.254.568 2.04 4.479 4.041 6.525 1.62 1.655 3.419 1.87 4.023 1.892h1.23l.07-.011c.101-.02.285-.072.396-.188.113-.12.135-.324.138-.405l.002-.098.004-.116c.02-.372.12-1.21.611-1.362.626-.195 1.43 1.298 2.283 1.873.645.434 1.134.339 1.134.339l2.295-.033c.135-.012 1.065-.125.664-.898l-.14-.241c-.152-.245-.535-.78-1.47-1.65l-.48-.44c-1.016-.947-.756-.977.714-2.884l.112-.146c1.048-1.372 1.468-2.21 1.336-2.567-.124-.343-.895-.252-.895-.252l-2.566.016-.068-.004a.535.535 0 0 0-.264.061c-.137.081-.227.27-.227.27l-.096.241a13.935 13.935 0 0 1-.851 1.724l-.195.317c-1 1.598-1.415 1.68-1.591 1.57-.435-.276-.327-1.108-.327-1.699 0-1.846.286-2.615-.555-2.814l-.175-.04c-.195-.04-.417-.067-.877-.075l-.146-.003c-.915-.009-1.69.004-2.13.214z" fill="currentColor" fill-rule="evenodd"></path>
              </svg></div>
          </a>
          <a href="https://dzen.ru/reprobad" target="_blank" class="social-link w-inline-block">
            <div class="social-icon w-embed"><svg width="100%" height="100%" viewbox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <path d="m0 16.48.69.01c6.056.105 9.528.602 11.873 2.947C14.996 21.87 15.44 25.515 15.52 32 7.061 31.75.25 24.939 0 16.48zM16.48 32l.01-.69c.105-6.056.602-9.528 2.947-11.873C21.87 17.004 25.515 16.561 32 16.48 31.75 24.939 24.939 31.75 16.48 32zm-.96-32-.01.69c-.105 6.056-.602 9.528-2.947 11.873C10.13 14.996 6.485 15.44 0 15.52.25 7.061 7.061.25 15.52 0zM32 15.52l-.69-.01c-6.056-.105-9.528-.602-11.873-2.947C17.004 10.13 16.561 6.485 16.48 0 24.939.25 31.75 7.061 32 15.52z" fill="currentColor" fill-rule="evenodd"></path>
              </svg></div>
          </a>
        </div>
        <div class="footer-slogan"><strong>Мы стараемся для вас, чтобы вы старались для них!</strong></div>
      </div>
      <div class="footer-menu">
        <div class="footer-menu-column">
          <a href="{{ route('site.text.about') }}" class="footer-menu-link">Система РЕПРО</a>
          <a href="{{ route('site.products.index') }}" class="footer-menu-link">Продукты</a>
          <a href="{{ route('site.events.index') }}" class="footer-menu-link">События</a>
          <a href="{{ route('site.advises.index') }}" class="footer-menu-link">Полезные советы</a>
          <a href="{{ route('site.articles.index') }}" class="footer-menu-link">Статьи</a>
        </div>
        <div class="footer-menu-column">
          <a href="{{ route('site.text.company') }}" class="footer-menu-link">О компании</a>
          <a href="{{ route('site.text.company') }}" class="footer-menu-link">Вопросы-ответы</a>
          <a href="{{ route('site.text.contacts') }}" class="footer-menu-link">Контакты</a>
        </div>
        <a href="/privacy" target="_blank" class="footer-terms-link">Политика конфиденциальности в отношении персональных данных</a>
      </div>
      <div class="r-farm-footer">
        <a href="https://www.r-pharm.com/ru" target="_blank" class="r-farm-footer-link w-inline-block"><img src="{{ asset("images/RFarm-footer.png") }}" loading="lazy" alt="Р-Фарм" class="r-farm-image"></a>
        <div>Поставщик АО &quot;Р-Фарм&quot;. Почтовый адрес: 119421, г. Москва, Ленинский проспект, д.111, корп.1, этаж 5, ком.128.</div>
        <div>Владелец сайта: АО «Р-Фарм» 123154, Москва, ул. Берзарина, д. 19, корп. 1Организация, уполномоченная принимать претензии от потребителей: ООО «Р-Фарм Косметикс»<br> Тел: +7 (495) 165 10 75<br>Адрес электронной почты для направления заявления о нарушении авторских и (или) смежных прав (ч. 2, ст. 10, 149-ФЗ &quot;Об информации, информационных технологиях и о защите информации&quot;) reproapotheka@rpharm.ru</div>
        <div>БАД. НЕ ЯВЛЯЕТСЯ ЛЕКАРСТВЕННЫМ СРЕДСТВОМ. ИМЕЮТСЯ ПРОТИВОПОКАЗАНИЯ. НЕОБХОДИМО ПРОКОНСУЛЬТИРОВАТЬСЯ СО СПЕЦИАЛИСТОМ.</div>
      </div>
    </div>
    <div class="bad-wrap">
      <div class="bad-container">
        <div class="bad-text"></div>
        <a href="#" class="bad-close w-inline-block"><img src="{{ asset("images/bad-close.svg") }}" loading="lazy" alt="" class="bad-close-image"></a>
      </div>
    </div>
    <div class="cookies-banner">
      <div class="cookies-wrap">
        <div class="cookies">
          <div class="cookies-text">Этот веб-сайт использует файлы cookies, чтобы обеспечить удобную работу пользователей с ним и функционаые возможности сайта. Нажимая &quot;Я принимаю&quot; вы соглашаетесь с <a href="/privacy" target="_blank" class="cookies-text-link">условиями использования файлов cookies</a>
          </div>
          <a href="#" class="accept-cookies w-button">Принимаю</a>
        </div>
      </div>
    </div>
  </section>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=67040316492967a9326aebb1" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="{{ asset("js/webflow.js") }}" type="text/javascript"></script>
  <script type="text/javascript">
var Webflow = Webflow || [];
Webflow.push(function() {
  const CLICK_TIMEOUT = 750; // задержка при клике на кнопку в миллисекундах
  const $questions = $('.reprotest-question-slide');
  let index = 0;
  let len = $questions.length;
  const totalQuestions = {{ isset($questions) && $questions->count() > 0 ? $questions->count() : 0 }};
  function reset(event) { // функция (событие) сброса теста
    if(event) event.preventDefault();
    $('.reprotest-intro-block').show();
    $('.reprotest-intro-block').closest('.section').show();
    $('.reprotest-questions').hide();
    $('.reprotest-final').hide();
    $questions.hide();
    index = 0;
    showSlide(index);
    $('.reprotest-selected').each(function() {
      $(this).removeClass('reprotest-selected');
    });
    $questions.css('pointer-events', 'all');
    setProgress();
    updateArrowVisibility(); // обновляем видимость стрелок после сброса
    // НЕ ЗАБУДЬ СБРОСИТЬ СОСТОЯНИЯ РЕЗУЛЬАТАТОВ ЗДЕСЬ
  }
  reset();
  
  // Проверка, отвечен ли вопрос
  function isQuestionAnswered(questionIndex) {
    if (questionIndex < 0 || questionIndex >= len) return false;
    const slide = $questions[questionIndex];
    return $(slide).find('.reprotest-slide-button.reprotest-selected').length > 0;
  }
  
  // Обновление состояния стрелок навигации
  function updateArrowVisibility() {
    const $leftArrow = $('.reprotest-arrow-left');
    const $rightArrow = $('.reprotest-arrow-right');
    
    // Стрелка влево: активна, если не первый вопрос
    if (index > 0) {
      $leftArrow.removeClass('disabled').css('opacity', '1').css('pointer-events', 'auto');
    } else {
      $leftArrow.addClass('disabled').css('opacity', '0.3').css('pointer-events', 'none');
    }
    
    // Стрелка вправо: активна, если текущий вопрос отвечен и есть следующий вопрос
    if (index < len - 1 && isQuestionAnswered(index)) {
      $rightArrow.removeClass('disabled').css('opacity', '1').css('pointer-events', 'auto');
    } else {
      $rightArrow.addClass('disabled').css('opacity', '0.3').css('pointer-events', 'none');
    }
  }
  
  function showSlide(number) { // показ слайда по номеру
    if (number < 0 || number >= len) return;
    index = number;
    const slide = $questions[index];
    $questions.hide(); // спрятать все
    $(slide).show(); // показать текущий
    setProgress(); // обновляем прогресс
    updateArrowVisibility(); // обновляем видимость стрелок
    // Если переходим на уже отвеченный вопрос, разрешаем изменение ответа
    if (isQuestionAnswered(index)) {
      $(slide).css('pointer-events', 'all');
    }
  }
  
  function setProgress() { // прогрессбар теста
    const progress = index / len * 100;
    $('.reprotest-progress-bar').css('width', progress + '%');
  }
  
  // Навигация назад
  function prevSlide(event) {
    if (event) event.preventDefault();
    // Проверяем, что стрелка активна
    if ($(this).hasClass('disabled')) return;
    if (index > 0) {
      // Разрешаем события на всех слайдах при переходе назад, чтобы можно было изменять ответы
      $questions.css('pointer-events', 'all');
      showSlide(index - 1);
    }
  }
  
  // Навигация вперед
  function goNextSlide(event) {
    if (event) event.preventDefault();
    // Проверяем, что стрелка активна
    if ($(this).hasClass('disabled')) return;
    // Можно перейти вперед только если текущий вопрос отвечен
    if (index < len - 1 && isQuestionAnswered(index)) {
      showSlide(index + 1);
    }
  }
  function nextSlide(event) { // функция события при клике на кнопку
    event.preventDefault();
    const currentSlide = $($questions[index]);
    const wasAnswered = isQuestionAnswered(index);
    
    // убираем выделение с других кнопок в этом вопросе
    currentSlide.find('.reprotest-slide-button').removeClass('reprotest-selected');
    // добавляем класс для выделения кнопки
    $(this).addClass('reprotest-selected');
    
    // Если вопрос уже был отвечен (изменение ответа), просто обновляем видимость стрелок
    if (wasAnswered) {
      updateArrowVisibility();
      return;
    }
    
    // Если вопрос не был отвечен, переходим на следующий
    // запрещаем события на текущем слайде, чтобы не ткнули ещё раз
    currentSlide.css('pointer-events', 'none');
    // Обновляем видимость стрелок после ответа
    updateArrowVisibility();
    index ++; // следующий слайд
    setProgress(); // анимация прогресса
    setTimeout(() => { // через паузу зовем следующий слайд
      if(index >= len) {
        // если индекс текущего слайда больше или равно общему количеству,
        // то показываем результат
        showResult();
      } else {
        showSlide(index);
      }
    }, CLICK_TIMEOUT);
  }
  // Переменная для хранения ID созданного результата теста
  let testResultId = null;
  
  function showResult() {
    // Собираем ответы
    const answers = [];
    $('.reprotest-question-slide').each(function() {
      const selected = $(this).find('.reprotest-slide-button.reprotest-selected');
      if (selected.length) {
        const value = parseInt(selected.data('value')) || 0;
        answers.push(value);
      } else {
        answers.push(0);
      }
    });
    
    // Получаем email из формы подписки, если он уже введен
    const email = $('#subscribe_email').val() || null;
    
    // Отправляем на сервер
    $.ajax({
      url: '{{ route("site.test.calculate") }}',
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        answers: answers,
        email: email
      },
      success: function(response) {
        if (response.success) {
          // Сохраняем ID созданного результата
          if (response.result_id) {
            testResultId = response.result_id;
          }
          // Рендерим результаты
          renderResults(response.data);
          // Показываем результат
          $('.reprotest-questions').hide(); 
          $('.reprotest-intro-block').closest('.section').hide();
          $('.reprotest-final').show();
        }
      },
      error: function(xhr) {
        console.error('Ошибка при расчете результатов', xhr);
        alert('Произошла ошибка при расчете результатов');
      }
    });
  }
  
  function renderResults(data) {
    // Очищаем существующие результаты
    $('.reprotest-recommend').not(':first').remove();
    
    // Отладка
    console.log('Results data:', data);
    
    // Проверяем наличие результатов
    const hasResults = data.results && data.results.length > 0;
    
    if (!hasResults) {
      // Скрываем блок подписки
      $('.reprotest-cta').hide();
      
      // Изменяем текст сообщения
      $('.reprotest-block-message p.reprotest-big-p').hide();
      $('.reprotest-block-message p.reprotest-p').text('Ваши результаты на высоте, это говорит о вашем внимании к себе и отличных привычках. Продолжайте в том же духе: поддерживайте баланс, прислушивайтесь к своему организму и не забывайте о поддержке.');
    } else {
      // Показываем блок подписки
      $('.reprotest-cta').show();
      
      // Восстанавливаем оригинальный текст
      $('.reprotest-block-message p.reprotest-big-p').show().text('Ознакомьтесь с рекомендациями:');
      $('.reprotest-block-message p.reprotest-p').text('Основываясь на ваших ответах, мы подготовили для вас персональные рекомендации. Они помогут понять, какие добавки могут быть полезны именно вам.');
      
      // Рендерим результаты
      data.results.forEach(function(result) {
        console.log('Result:', result);
        console.log('image1:', result.image1, 'link1:', result.link1);
        console.log('image2:', result.image2, 'link2:', result.link2);
        
        // Создаем блок рекомендации
        const blockClass = result.color ? 'rtrb-' + result.color : '';
        
        // Формируем продукты
        let productsHtml = '';
        const baseUrl = '{{ url("/") }}';
        
        if (result.image1 && result.image1.trim() !== '') {
          // Обрабатываем путь к изображению
          let image1Url = result.image1;
          if (!image1Url.startsWith('http')) {
            // Если путь начинается с /, добавляем baseUrl
            if (image1Url.startsWith('/')) {
              image1Url = baseUrl + image1Url;
            } else {
              // Если путь относительный, добавляем baseUrl и /
              image1Url = baseUrl + '/' + image1Url;
            }
          }
          const link1 = result.link1 || '#';
          console.log('Image1 URL:', image1Url);
          productsHtml += `
            <a href="${link1}" class="product-item-link test-product-link w-inline-block">
              <div class="sache-image-element">
                <img src="${image1Url}" loading="lazy" alt="Product 1" class="sache-image" onerror="this.style.display='none';">
              </div>
            </a>
          `;
        }
        if (result.image2 && result.image2.trim() !== '') {
          // Обрабатываем путь к изображению
          let image2Url = result.image2;
          if (!image2Url.startsWith('http')) {
            // Если путь начинается с /, добавляем baseUrl
            if (image2Url.startsWith('/')) {
              image2Url = baseUrl + image2Url;
            } else {
              // Если путь относительный, добавляем baseUrl и /
              image2Url = baseUrl + '/' + image2Url;
            }
          }
          const link2 = result.link2 || '#';
          console.log('Image2 URL:', image2Url);
          productsHtml += `
            <a href="${link2}" class="product-item-link test-product-link w-inline-block">
              <div class="sache-image-element">
                <img src="${image2Url}" loading="lazy" alt="Product 2" class="sache-image" onerror="this.style.display='none';">
              </div>
            </a>
          `;
        }
        
        // Формируем HTML только если есть хоть один продукт
        let html = '';
        if (productsHtml) {
          html = `
            <div class="container">
              <div class="reprotest-recommend">
                <div class="reprotest-recommend-block ${blockClass}">
                  <div class="reprotest-block-message">
                    <p class="reprotest-p">${result.description}</p>
                    <a href="https://reprobad.com" class="button w-button" target="_blank">
                      Подробные рекомендации
                    </a>
                  </div>
                  <div class="reprotest-products">
                    ${productsHtml}
                  </div>
                </div>
              </div>
            </div>
          `;
        } else {
          // Если нет продуктов, показываем только текст
          html = `
            <div class="container">
              <div class="reprotest-recommend">
                <div class="reprotest-recommend-block ${blockClass}">
                  <div class="reprotest-block-message">
                    <p class="reprotest-p">${result.description}</p>
                    <a href="https://reprobad.com" class="button w-button" target="_blank">
                      Подробные рекомендации
                    </a>
                  </div>
                </div>
              </div>
            </div>
          `;
        }
        $('.reprotest-result-container').parent().append(html);
      });
    }
  }
  // нажали на кнопку ПРОЙТИ ТЕСТ:
  $('.reproptest-button').on('tap', function(event) {
    event.preventDefault();
    $('.reprotest-intro-block').hide();
    $('.reprotest-questions').show();
    showSlide(0);
    // Инициализируем состояние стрелок при старте теста
    updateArrowVisibility();
  });
  // нажали на кнопку ответа в вопросе:
  $('.reprotest-slide-button').on('tap', nextSlide);
  // Обработка стрелок навигации
  $('.reprotest-arrow-left').on('click', prevSlide);
  $('.reprotest-arrow-right').on('click', goNextSlide);
  // событие reset
  $('.reprotest-reset').on('tap', reset);
  
  // Обработка формы подписки
  $('#wf-form-Subscribe-Form').on('submit', function(e) {
    e.preventDefault();
    const form = $(this);
    const email = form.find('[name="subscribe_email"]').val();
    const agree = form.find('[name="agree"]').is(':checked');
    
    if (!agree) {
      alert('Необходимо согласие на обработку персональных данных');
      return;
    }
    
    // Сначала обновляем email в результате теста, если он был создан
    if (testResultId && email) {
      $.ajax({
        url: '{{ route("site.test.update-email") }}',
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          result_id: testResultId,
          email: email
        },
        success: function() {
          // После обновления email в результате, отправляем форму подписки
          sendSubscribeForm(form, email, agree);
        },
        error: function() {
          // Если не удалось обновить, все равно отправляем форму подписки
          sendSubscribeForm(form, email, agree);
        }
      });
    } else {
      // Если результата нет, просто отправляем форму подписки
      sendSubscribeForm(form, email, agree);
    }
  });
  
  function sendSubscribeForm(form, email, agree) {
    $.ajax({
      url: form.attr('action'),
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        email: email,
        agree: agree,
        result_id: testResultId || null
      },
      success: function(response) {
        if (response.success) {
          $('.subscribe-success').show();
          $('.reprotest-error-message').hide();
          form.hide();
        }
      },
      error: function(xhr) {
        $('.reprotest-error-message').show();
        $('.subscribe-success').hide();
        console.error('Ошибка при отправке формы', xhr);
      }
    });
  }
});
</script>
</body>
</html>