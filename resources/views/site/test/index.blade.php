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
  .reprotest-config-warning { padding: 1rem; background: #fff3cd; border-radius: 0.5rem; margin-bottom: 1rem; color: #664d03; }
  .reprotest-config-disabled { opacity: 0.45 !important; pointer-events: none !important; cursor: not-allowed !important; }
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
          @if(empty($questionsConfigured))
          <div class="reprotest-config-warning">
            <p style="margin:0;">Для работы теста в админке должно быть ровно 24 активных вопроса. Сейчас активных: {{ $activeQuestionCount ?? 0 }}.</p>
          </div>
          @endif
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
          <a href="#" class="reproptest-button w-button {{ empty($questionsConfigured) ? 'reprotest-config-disabled' : '' }}"><strong>Пройти тест</strong> —&gt;</a>
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
                      @php $sortedAnswers = $question->sorted_answers; @endphp
                      @if(count($sortedAnswers) > 0)
                        @php $firstVisibleAnswer = true; @endphp
                        @foreach($sortedAnswers as $answerIndex => $answer)
                          @if((int) $question->order === 10 && ! in_array((int) ($answer['value'] ?? -1), [0, 3], true))
                            @continue
                          @endif
                          <a href="#" class="reprotest-slide-button w-inline-block {{ $index === 0 && $firstVisibleAnswer ? 'reprotest-selected' : '' }}" data-value="{{ $answer['value'] ?? 0 }}">
                            <div class="reprotest-button-text">{{ $answer['text'] ?? '' }}</div>
                          </a>
                          @php $firstVisibleAnswer = false; @endphp
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
              <h3 class="reprotest-adv-item-h">Психоэмоциональное состояние</h3>
              <p class="reprotest-p">Защита от стресса и нормализация сна</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-2.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Микрофлора кишечника и детоксикация</h3>
              <p class="reprotest-p">Нормализация кишечной микрофлоры и поддержка печени</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-3.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h">Метаболизм и энергия</h3>
              <p class="reprotest-p">Коррекция энергетического обмена и нормализация метаболизма</p>
            </div>
            <div><img src="{{ asset("images/test/reprotest-ic-4.svg") }}" loading="lazy" alt="" class="reprotest-adv-ic">
              <h3 class="reprotest-adv-item-h"><strong>Репродуктивное здоровье</strong></h3>
              <p class="reprotest-p">Поддержка репродуктивной функции</p>
            </div>
          </div>
          <div style="margin-top: 2rem; text-align: left;">
            <a href="https://reprobad.com/" class="button short-event-button w-button">Подробнее о продуктах  —></a>
          </div>
        </div>
      </div>
    </section>
  <div class="spacer desktop-3-rem"></div>
  @include('site.test._footer')
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=67040316492967a9326aebb1" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="{{ asset("js/webflow.js") }}" type="text/javascript"></script>
  <script type="text/javascript">
var Webflow = Webflow || [];
Webflow.push(function() {
  const CLICK_TIMEOUT = 750;
  const $questions = $('.reprotest-question-slide');
  let index = 0;
  let len = $questions.length;
  function reset(event) {
    if (event) event.preventDefault();
    $('.reprotest-intro-block').show();
    $('.reprotest-intro-block').closest('.section').show();
    $('.reprotest-questions').hide();
    $questions.hide();
    index = 0;
    showSlide(index);
    $('.reprotest-selected').each(function() {
      $(this).removeClass('reprotest-selected');
    });
    $questions.css('pointer-events', 'all');
    setProgress();
    updateArrowVisibility();
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
  function showResult() {
    const answers = [];
    $('.reprotest-question-slide').each(function() {
      const selected = $(this).find('.reprotest-slide-button.reprotest-selected');
      if (selected.length) {
        answers.push(parseInt(selected.data('value'), 10) || 0);
      } else {
        answers.push(0);
      }
    });
    const csrf = $('meta[name="csrf-token"]').attr('content') || '';
    $.ajax({
      url: '{{ route("site.test.calculate") }}',
      method: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': csrf
      },
      data: {
        _token: csrf,
        answers: answers,
        email: null
      },
      success: function(response) {
        if (response.success && response.redirect) {
          window.location.href = response.redirect;
        }
      },
      error: function(xhr) {
        var msg = 'Произошла ошибка при расчёте результатов.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          msg = xhr.responseJSON.message;
        }
        alert(msg);
      }
    });
  }

  $('.reproptest-button').on('tap', function(event) {
    event.preventDefault();
    if ($(this).hasClass('reprotest-config-disabled')) {
      return;
    }
    $('.reprotest-intro-block').hide();
    $('.reprotest-questions').show();
    showSlide(0);
    updateArrowVisibility();
  });
  $('.reprotest-slide-button').on('tap', nextSlide);
  $('.reprotest-arrow-left').on('click', prevSlide);
  $('.reprotest-arrow-right').on('click', goNextSlide);
});
</script>
</body>
</html>