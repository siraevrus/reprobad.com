@extends('site.layouts.base')

@section('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "{{ config('app.url') }}",
        "name": "Главная"
      }
    },
    {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "{{ route('site.articles.index') }}",
        "name": "Статьи"
      }
    },
    {
      "@type": "ListItem",
      "position": 3,
      "item": {
        "@id": "{{ route('site.articles.show', $resource->alias) }}",
        "name": "{{ strip_tags($resource->title) }}"
      }
    }
  ]
}
</script>
@php
    $articleImage = $resource->image ?? null;
    if ($articleImage && !str_starts_with($articleImage, 'http')) {
        $articleImage = config('app.url') . '/' . ltrim($articleImage, '/');
    }
@endphp
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": {!! json_encode(strip_tags($resource->title)) !!},
  "description": {!! json_encode(strip_tags($resource->description ?? '')) !!},
  @if($articleImage)"image": {!! json_encode($articleImage) !!},
  @endif
  "datePublished": "{{ $resource->created_at->toIso8601String() }}",
  "dateModified": "{{ $resource->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Organization",
    "name": "Система РЕПРО"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Система РЕПРО",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ config('app.url') }}/images/lgog-gold.svg"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ route('site.articles.show', $resource->alias) }}"
  }
}
</script>
@php
    $medicalWebPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'MedicalWebPage',
        '@id' => route('site.articles.show', $resource->alias),
        'about' => [
            '@type' => 'MedicalCondition',
            'name' => 'Нарушения репродуктивной функции',
        ],
        'audience' => [
            '@type' => 'Patient',
        ],
        'reviewedBy' => [
            '@type' => 'Organization',
            'name' => 'Медицинское бюро АО «Р-Фарм»',
            'url' => rtrim(config('app.url'), '/') . '/editorial-policy',
        ],
        'lastReviewed' => '2026-04-01',
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($medicalWebPageSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')
    <section class="section article-section">
        <div class="container">
            <div class="breadcrumbs">
                <a href="{{ route('site.articles.index') }}" nav="back" class="breadcrumb">&lt;- Статьи</a>
            </div>
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
                <h1 class="article-h1"><strong>{{ $resource->title }}</strong></h1>
                <p class="big-paragraph article-short">{!! strip_tags($resource->description ?? '', '<strong><em><b><i><a><br>') !!}</p>
                <div class="article-options">
                    <div class="article-date">{{ $resource->published_at }}</div>
                    <div class="article-read-time"><img src="images/sm-clock.svg" loading="lazy" alt="часы" class="clock-icon">
                        <div>{{ $resource->time }}</div>
                    </div>
                </div>
            </div>
            <div class="article-wrap">
                <div class="article-content">
                    <div class="w-richtext">
                        @if($resource->image)
                        <figure class="w-richtext-align-center w-richtext-figure-type-image">
                            <div><img src="{{ $resource->image }}" loading="lazy" alt="{{ $resource->image_alt ?? strip_tags($resource->title) }}" class="image"></div>
                        </figure>
                        @endif
                        {!! $resource->content ?? '' !!}
                    </div>
                    <div class="article-actions" style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e5e5; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                        <div class="article-like" style="display: flex; align-items: center; gap: 0.5rem;">
                            <button type="button" 
                                    id="like-button" 
                                    data-article-alias="{{ $resource->alias }}"
                                    style="background: none; border: none; cursor: pointer; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem; transition: transform 0.2s;"
                                    onmouseover="this.style.transform='scale(1.1)'"
                                    onmouseout="this.style.transform='scale(1)'">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" id="like-icon">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" 
                                          fill="none" 
                                          stroke="#999" 
                                          stroke-width="2"
                                          style="transition: all 0.2s;"/>
                                </svg>
                                <span id="like-count" style="font-size: 1rem; color: #333; font-weight: 500;">{{ $resource->likes_count ?? 0 }}</span>
                            </button>
                        </div>
                        <div class="article-share" style="flex: 1;">
                            <div class="ya-share2" data-theme="white" data-size="l" data-shape="round" data-services="vkontakte,telegram,odnoklassniki"></div>
                        </div>
                    </div>
                </div>
                <div class="side">
                    <div class="side-promo">
                        <a href="//www.eapteka.ru/search/?q=репро" target="_blank">
                            <img src="{{ asset('images/banner.png') }}" style="width:100%" alt="Купить в Eapteka">
                        </a>
                    </div>
                    @if(!empty($other))
                    <div class="side-head">
                        <div class="side-h">Другие статьи по этой теме:</div>
                        @foreach($other as $item)
                        <div class="card side-card">
                            @if(isset($item->icon))
                            <div class="card-head"><img src="{{ $item->icon ?? '' }}" loading="lazy" alt="" class="card-icon"></div>
                            @endif
                            <div class="card-body">
                                <a href="{{ route('site.articles.show', $item->alias) }}" aria-current="page" class="card-title w--current">{{ $item->title }}</a>
                                <div class="card-text">{!! $item->description ?? '' !!}</div>
                            </div>
                            <div class="card-footer">
                                <div class="card-date">{{ $item->published_at }}</div>
                                <div class="card-read"><img loading="lazy" src="images/sm-clock.svg" alt="часы" class="clock-icon">
                                    <div>{{ $item->time }}</div>
                                </div>
                                <a href="{{ route('site.articles.show', $item->alias) }}" aria-current="page" class="card-link w-inline-block w--current">
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
                    <h2 class="big-section-h"><strong>События</strong> и&nbsp;мероприятия</h2>
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
    <script src="https://yastatic.net/share2/share.js"></script>
    <style>
        .input-error {
            border: 1px solid red;
        }
    </style>
    <script>
        const promoData = [
            { href: '//www.eapteka.ru/search/?q=репро', img: @json(asset('images/banner1.png')) },
            { href: '//www.eapteka.ru/search/?q=репро', img: @json(asset('images/banner2.png')) },
            { href: '//www.eapteka.ru/search/?q=репро', img: @json(asset('images/banner3.png')) },
            { href: '//www.eapteka.ru/search/?q=репро', img: @json(asset('images/banner4.png')) }
        ];

        let current = 0;
        const container = document.querySelector('.side-promo a');
        const img = container.querySelector('img');

        setInterval(() => {
            current = (current + 1) % promoData.length;
            container.href = promoData[current].href;
            img.src = promoData[current].img;
        }, 4000);
    </script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButton = document.getElementById('like-button');
            const likeIcon = document.getElementById('like-icon');
            const likeCount = document.getElementById('like-count');
            let isLiked = false;

            if (likeButton) {
                likeButton.addEventListener('click', async function() {
                    if (isLiked) {
                        return; // Предотвращаем повторные клики
                    }

                    const articleAlias = likeButton.getAttribute('data-article-alias');
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        const response = await fetch(`/articles/${articleAlias}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            }
                        });

                        const data = await response.json();
                        if (data.success) {
                            isLiked = true;
                            likeCount.textContent = data.likes_count;
                            
                            // Анимация иконки - заливка красным
                            const path = likeIcon.querySelector('path');
                            path.style.fill = '#e74c3c';
                            path.style.stroke = '#e74c3c';
                            
                            // Анимация кнопки
                            likeButton.style.transform = 'scale(1.2)';
                            setTimeout(() => {
                                likeButton.style.transform = 'scale(1)';
                            }, 200);
                        }
                    } catch (e) {
                        console.error('Ошибка при отправке лайка:', e);
                    }
                });
            }
        });
    </script>
@endsection
