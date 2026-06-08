<div class="widgets-row">
    <div class="widgets-column">
        <div data-w-id="12a03ebd-965c-d2e2-5604-69d6e4ecd1be" class="widget">
            <div class="widget-content">
                <h2 class="widget-heading">Пройдите тест «<strong>Репродуктивное здоровье</strong>»</h2>
                <p class="widget-p">Ответьте на 24 вопроса, получите оценку по важным категориям вашего здоровья</p>
                <div class="flex-spacer"></div>
                <a href="{{ route('site.test.index') }}" class="button w-button">ПРОЙТИ ТЕСТ —&gt;</a>
            </div>
            <img src="{{ asset('images/test/test-cover.webp') }}" loading="lazy" sizes="(max-width: 767px) 100vw, 50vw" srcset="{{ asset('images/test/test-cover-p-500.webp') }} 500w, {{ asset('images/test/test-cover-p-800.webp') }} 800w, {{ asset('images/test/test-cover.webp') }} 1036w" alt="счастливая семейная пара" class="opros-widget-img">
        </div>
    </div>
    <div class="widgets-column">
        <div data-w-id="8f4e031f-1a14-8225-f62f-dd5b11c6253e" class="widget widget-repro-menu">
            <div class="widget-content">
                <h2 class="widget-heading"><strong>РЕПРО</strong>меню</h2>
                <p class="widget-p">Ваше репродуктивное здоровье начинается&nbsp;с тарелки: мы подготовили рецепты на всю&nbsp;неделю</p>
                <div class="flex-spacer"></div>
                <a href="{{ route('site.menus.index') }}" class="button w-button">Смотреть —&gt;</a>
            </div>
            <div class="repromenu-widget-images">
                <img src="{{ asset('images/repromenu-widget.png') }}" loading="lazy" alt="стакан смузи" class="repromenu-widget-img">
            </div>
        </div>
    </div>
</div>
