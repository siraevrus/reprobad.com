{{--
  Статичные баннеры (PNG в public/images). Интерактивный Lottie сохранён в
  lottie-banner-lottie-legacy.blade.php — см. комментарий в том файле для возврата.
--}}
<div id="floating-banner-desktop" style="visibility: hidden; position: fixed; bottom: -200px;">
    <div class="close"><img src="{{ asset('images/bad-close.svg') }}" alt="Закрыть" /></div>
    <a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank" rel="noopener noreferrer">
        <img
            src="{{ asset('images/floating-banner-desktop.png') }}"
            alt="Система Репро — скидка 30%, купить"
            width="1024"
            height="86"
            decoding="async"
            class="floating-banner-img"
        />
    </a>
</div>

<div id="floating-banner-mobile" style="visibility: hidden; position: fixed; bottom: -200px;">
    <div class="close"><img src="{{ asset('images/bad-close.svg') }}" alt="Закрыть" /></div>
    <a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank" rel="noopener noreferrer">
        <img
            src="{{ asset('images/floating-banner-mobile.png') }}"
            alt="Система Репро — скидка 30%, купить"
            width="780"
            height="192"
            decoding="async"
            class="floating-banner-img"
        />
    </a>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bannerDesktop = document.getElementById('floating-banner-desktop');
    const bannerMobile = document.getElementById('floating-banner-mobile');
    const closeDesktop = bannerDesktop.querySelector('.close');
    const closeMobile = bannerMobile.querySelector('.close');

    function hideBanners() {
        bannerDesktop.style.opacity = '0';
        bannerDesktop.style.visibility = 'hidden';
        bannerDesktop.style.bottom = '-200px';
        bannerMobile.style.opacity = '0';
        bannerMobile.style.visibility = 'hidden';
        bannerMobile.style.bottom = '-200px';
        window.closedBanner = true;
    }

    closeDesktop.addEventListener('click', function(e) {
        e.preventDefault();
        hideBanners();
    });

    closeMobile.addEventListener('click', function(e) {
        e.preventDefault();
        hideBanners();
    });

    function checkScroll() {
        if (window.closedBanner) return;

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const shouldShow = scrollTop >= 1000;
        const isMobile = window.innerWidth <= 768;

        requestAnimationFrame(() => {
            if (!shouldShow) {
                bannerDesktop.style.visibility = 'hidden';
                bannerDesktop.style.bottom = '-200px';
                bannerMobile.style.visibility = 'hidden';
                bannerMobile.style.bottom = '-200px';
                return;
            }

            if (isMobile) {
                bannerDesktop.style.visibility = 'hidden';
                bannerDesktop.style.bottom = '-200px';
                bannerMobile.style.visibility = 'visible';
                bannerMobile.style.bottom = '60px';
            } else {
                bannerMobile.style.visibility = 'hidden';
                bannerMobile.style.bottom = '-200px';
                bannerDesktop.style.visibility = 'visible';
                bannerDesktop.style.bottom = '60px';
            }
        });
    }

    let scrollTimeout = null;
    function throttledCheckScroll() {
        if (!scrollTimeout) {
            scrollTimeout = requestAnimationFrame(() => {
                checkScroll();
                scrollTimeout = null;
            });
        }
    }

    checkScroll();
    window.addEventListener('scroll', throttledCheckScroll, { passive: true });
    window.addEventListener('resize', throttledCheckScroll, { passive: true });
});
</script>
