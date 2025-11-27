
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.7.1/dist/dotlottie-wc.js" type="module"></script>
<div id="lottie-banner" style="visibility: hidden; position: fixed; bottom: -200px;">
    <div class="close"><img src="images/bad-close.svg" /></div>
    <a href="https://www.eapteka.ru/voronezh/goods/brand/repro/?utm_source=products&utm_medium=direct_link&utm_content=menu_futer_banner&utm_campaign=eapteka" target="_blank">
        <dotlottie-wc 
            id="lottie-desktop"
            src="images/weUkdnuK0x.lottie" 
            speed="1" 
            style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" 
            mode="forward" 
            loop 
            autoplay>
        </dotlottie-wc>
    </a>
</div>

<div id="lottie-banner-mobile" style="visibility: hidden; position: fixed; bottom: -200px;">
    <div class="close"><img src="images/bad-close.svg" /></div>
    <a href="https://www.eapteka.ru/voronezh/goods/brand/repro/?utm_source=products&utm_medium=direct_link&utm_content=menu_futer_banner&utm_campaign=eapteka" target="_blank">
        <dotlottie-wc
            id="lottie-mobile"
            src="images/qk8EQOxYwW.lottie"
            style="margin:auto"
            speed="1"
            autoplay
            loop
        ></dotlottie-wc>
    </a>
</div>

<style>
    #lottie-banner,
    #lottie-banner-mobile {
        z-index: 1000;
        width: calc(100% - 40px);
    }
    #lottie-banner a:hover,
    #lottie-banner-mobile a:hover {
        opacity: 1 !important;
    }
    #lottie-banner {
        pointer-events: none;
    }
    #lottie-banner-mobile {
        pointer-events: none;
    }
    #lottie-banner a {
        display: block;
        overflow: visible;
        aspect-ratio: 1440/120;
        width: 100%;
        position: relative;
        pointer-events: auto;
    }
    #lottie-banner-mobile a {
        display: block;
        width: 100%;
        position: relative;
        pointer-events: auto;
    }
    #lottie-banner,
    #lottie-banner-mobile {
        position: fixed;
        left: 0;
        right: 0;
        margin: auto;
        transition: bottom 0.3s ease, visibility 0.3s ease;
    }
    #lottie-banner .close,
    #lottie-banner-mobile .close {
        pointer-events: auto;
    }
    #lottie-banner .close,
    #lottie-banner-mobile .close {
        position: absolute;
        top: -50px;
        right: 15px;
        font-size: 40px;
        height: 40px;
        width: 40px;
        cursor: pointer;
        line-height: 80%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #lottie-banner .close img,
    #lottie-banner-mobile .close img {
        filter: invert(1);
        opacity: .5;
    }
    @media (max-width: 768px) {
        #lottie-banner {
            visibility: hidden !important;
            bottom: -200px !important;
        }
    }
</style>

<script>
// Начинаем загрузку Lottie файлов сразу при загрузке страницы
(function() {
    // Предзагружаем файлы через fetch для кеширования
    if (typeof fetch !== 'undefined') {
        fetch('images/weUkdnuK0x.lottie', { method: 'HEAD' }).catch(() => {});
        fetch('images/qk8EQOxYwW.lottie', { method: 'HEAD' }).catch(() => {});
    }
})();

document.addEventListener('DOMContentLoaded', function() {
    const bannerDesktop = document.getElementById('lottie-banner');
    const bannerMobile = document.getElementById('lottie-banner-mobile');
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
        if(window.closedBanner) return;

        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const shouldShow = scrollTop >= 1000;
        const isMobile = window.innerWidth <= 768;
        
        if (shouldShow) {
            if (isMobile) {
                bannerMobile.style.visibility = 'visible';
                bannerMobile.style.bottom = '60px';
                bannerDesktop.style.visibility = 'hidden';
                bannerDesktop.style.bottom = '-200px';
            } else {
                bannerDesktop.style.visibility = 'visible';
                bannerDesktop.style.bottom = '60px';
                bannerMobile.style.visibility = 'hidden';
                bannerMobile.style.bottom = '-200px';
            }
        } else {
            bannerDesktop.style.visibility = 'hidden';
            bannerDesktop.style.bottom = '-200px';
            bannerMobile.style.visibility = 'hidden';
            bannerMobile.style.bottom = '-200px';
        }
    }
    
    checkScroll();
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
});
</script>