@extends('site.layouts.base')

@section('head')
@if($resources && $resources->count() > 0)
@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => []
    ];
    
    foreach ($resources as $resource) {
        // Конвертируем HTML в текст с сохранением структуры
        $answerText = $resource->content ?? '';
        // Заменяем HTML теги на пробелы и переносы строк для читаемости
        $answerText = preg_replace('/<br\s*\/?>/i', "\n", $answerText);
        $answerText = preg_replace('/<\/p>/i', "\n\n", $answerText);
        $answerText = preg_replace('/<p[^>]*>/i', '', $answerText);
        $answerText = preg_replace('/<\/li>/i', "\n", $answerText);
        $answerText = preg_replace('/<li[^>]*>/i', '• ', $answerText);
        $answerText = preg_replace('/<[^>]+>/', '', $answerText); // Удаляем все остальные HTML теги
        $answerText = html_entity_decode($answerText, ENT_QUOTES | ENT_HTML5, 'UTF-8'); // Декодируем HTML сущности
        $answerText = trim($answerText); // Убираем лишние пробелы
        
        $faqSchema['mainEntity'][] = [
            '@type' => 'Question',
            'name' => strip_tags($resource->title),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $answerText
            ]
        ];
    }
@endphp
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
@endsection

@section('content')
    <section class="section article-section">
        <div class="container">
            <div class="article-head">
                <div class="article-icon">
                    <div class="article-icon-image">
                        <div class="w-embed">
                            <style>
                                .article-icon-image {
                                    mask-image: url('https://cdn.prod.website-files.com/67040316492967a9326aebb1/6704f8b64f300dd6400349c8_big-news-icon.svg');
                                    mask-size: contain;
                                    mask-repeat: no-repeat;
                                    mask-position: center;
                                }
                            </style>
                        </div>
                    </div>
                </div>
                <h1 class="article-h1"><strong>Вопрос-ответ</strong></h1>
            </div>
            <div class="article-wrap">
                <div class="article-content">
                    
                    <div class="article-accordion">
                        @foreach($resources as $resource)
                        <div class="accordion-item">
                          @php
                            $faqIndex = $loop->iteration;
                            $questionId = 'faq-q-' . $faqIndex;
                            $answerId = 'faq-a-' . $faqIndex;
                          @endphp
                          <h2 class="accordion-header">
                            <button
                              id="{{ $questionId }}"
                              class="accordion-title accordion-toggle"
                              type="button"
                              aria-expanded="false"
                              aria-controls="{{ $answerId }}"
                            >
                              {{ $resource->title }}
                              <img src="images/path_down.svg" alt="" aria-hidden="true" class="accordion-arrow">
                            </button>
                          </h2>
                          <div
                            class="accordion-content"
                            id="{{ $answerId }}"
                            role="region"
                            aria-labelledby="{{ $questionId }}"
                            hidden
                          >
                            {!! $resource->content !!}
                          </div>
                        </div>
                        @endforeach
                    </div>

                </div>
                <div class="side">
                    <div class="side-promo">
                        <a href="//www.eapteka.ru/search/?q=репро" target="_blank">
                            <img src="images/banner.png" style="width:100%" alt="Купить в Eapteka">
                        </a>
                    </div>
                    @if(!empty($other))
                    <div class="side-head">
                        <div class="side-h">Другие советы по этой теме:</div>
                        @foreach($other as $item)
                        <div class="card side-card">
                            @if(isset($item->ico->image))
                            <div class="card-head"><img src="{{ $item->ico->image ?? '' }}" loading="lazy" alt="" class="card-icon"></div>
                            @endif
                            <div class="card-body">
                                <a href="{{ route('site.articles.show', $item->id) }}" aria-current="page" class="card-title w--current">{{ $item->title }}</a>
                                <div class="card-text">{{ $item->description }}</div>
                            </div>
                            <div class="card-footer">
                                <div class="card-date">{{ $item->published_at }}</div>
                                <div class="card-read"><img loading="lazy" src="images/sm-clock.svg" alt="часы" class="clock-icon">
                                    <div>{{ $item->time }}</div>
                                </div>
                                <a href="{{ route('site.articles.show', $item->id) }}" aria-current="page" class="card-link w-inline-block w--current">
                                    <div class="text-block">Читать</div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="side-footer">
                        <div class="subscribe">
                            <div class="subscribe-body w-form" x-data="app()">
                                <form name="form wf-form-Subscribe-Form" method="post" @submit.prevent="submit" class="subscribe-form" action="{{ route('site.form.subscribe') }}" x-show="!success">
                                    <div class="subscribe-head-label">Подписаться на рассылку</div>
                                    <input class="text-field w-input" autocomplete="off" maxlength="256" x-model="form.email" placeholder="Ваш Email*" type="email" id="subscribe_email" :class="errors.email ? 'input-error' : ''">
                                    <label class="w-checkbox subscribe-checkbox">
                                        <div class="w-checkbox-input w-checkbox-input--inputType-custom subscribe-checkbox-input w--redirected-checked"></div>
                                        <input type="checkbox" value="1" x-model="form.agree" id="agree" data-name="agree" required="" style="opacity:0;position:absolute;z-index:-1" checked="">
                                        <span class="subscribe-checkbox-label w-form-label" for="agree">Даю согласие на получение рассылки с сайта «Репробад» и соглашаюсь с <a href="{{ route('site.text.privacy') }}" target="_blank" class="checkbox-link">правилами политики конфиденциальности в отношении персональных данных</a></span>
                                    </label>
                                    <input type="submit" data-wait="Секундочку..." class="purple-button w-button" value="Подписаться">
                                </form>

                                <div class="subscribe-success w-form-done" x-show="success">
                                    <img src="images/success-icon.svg" loading="lazy" alt="иконка письмо отправлено" class="success-icon">
                                    <div>Вы подписаны!</div>
                                    <a href="#" class="close-popup-button w-inline-block"><img src="images/x.svg" loading="lazy" alt="закрыть" class="x-icon"></a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section short-events-in-article">
        <div class="container">
            <div class="short-events"><img loading="lazy" src="images/bg-cal.svg" alt="иконка календарь" class="short-events-bg-image">
                <div class="section-head-with-detali-button short-events-section">
                    <h2 class="big-section-h">События и мероприятия</h2>
                    <a href="{{ route('site.events.index') }}" class="more-button w-button">все <span class="only-mobile-text">мероприятия </span>—&gt;</a>
                </div>
                @foreach($events as $item)
                    @include('site.components.events.item', ['item' => $item])
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <style>
    .article-accordion { 
        margin: 1.5rem 0; 
        padding: 0; 
    }
    .article-accordion .accordion-item { 
        border: none; 
        border-radius: 0.75rem; 
        padding: 0.75rem 3rem 0.75rem 1rem; 
        background-color: var(--white, #fff);
        position: relative; 
    }
    .article-accordion .accordion-header { 
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        gap: 1rem; 
        position: relative; 
    }
    .article-accordion .accordion-title { 
        color: #8577B7; 
        font-weight: 600; 
        background: none; 
        border: 0; 
        padding: 0; 
        margin: 0; 
        cursor: pointer; 
        text-align: left; 
        font-size: inherit; 
        font-family: inherit;
        position: relative; 
    }
    .article-accordion .accordion-toggle { 
        display: flex; 
        background: none; 
        border: 0; 
        padding: 0; 
        margin: 0; 
        line-height: 150%; cursor: pointer; 
        position: relative; 
    }
    .article-accordion .accordion-arrow { 
        width: 1rem; 
        height: 1rem; 
        transition: transform 0.2s ease;
        flex: 0 0 1rem;
        position: absolute;
        right: 1rem;
        top: 0;bottom: 0;margin: auto; 
    }
    .article-accordion .accordion-content { 
        padding-top: 0.5rem; 
    }
    .article-accordion .accordion-content[hidden] {
        display: none;
    }
    .article-accordion .accordion-item.open .accordion-arrow { 
        transform: rotate(180deg);
    }

    @media screen and (max-width: 767px) {
        .article-accordion .accordion-item {
            font-size: .8rem;
            margin-bottom: 1rem;
        }
    }
    </style>
    <script type="text/javascript">
        (function() {
          function initArticleAccordion() {
            var toggles = document.querySelectorAll('.article-accordion .accordion-toggle');
            if (!toggles || !toggles.length) return;
            toggles.forEach(function(toggle) {
              toggle.addEventListener('click', function(event) {
                var item = toggle.closest('.accordion-item');
                if (!item) return;
                var panelId = toggle.getAttribute('aria-controls');
                if (!panelId) return;
                var panel = document.getElementById(panelId);
                if (!panel) return;

                var expanded = toggle.getAttribute('aria-expanded') === 'true';
                var nextExpanded = !expanded;
                toggle.setAttribute('aria-expanded', nextExpanded.toString());

                if (nextExpanded) {
                  panel.hidden = false;
                  item.classList.add('open');
                } else {
                  panel.hidden = true;
                  item.classList.remove('open');
                }
              });
            });
          }
          if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initArticleAccordion);
          } else {
            initArticleAccordion();
          }
        })();
    </script>

    <style>
        .input-error {
            border: 1px solid red;
        }
    </style>
    <script>
        function app() {
            return {
                form: {
                    email: '',
                    agree: 1
                },
                errors: {

                },
                success: false,

                async submit() {
                    try {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch('/forms/subscribe', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();
                        if (data.success) {
                            this.errors = {};
                            this.success = true;
                        } else {
                            this.errors = data.errors;
                        }
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    </script>
@endsection
