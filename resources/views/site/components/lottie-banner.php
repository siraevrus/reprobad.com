
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.7.1/dist/dotlottie-wc.js" type="module"></script>
<div id="lottie-banner">
    <div class="close"><img src="images/bad-close.svg" /></div>
    <a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank">
        <dotlottie-wc 
            src="https://lottie.host/d479cfd5-9ee2-4029-8c33-89d45691b62d/weUkdnuK0x.lottie" 
            speed="1" 
            style="width:100%;aspect-ratio:1440 / 120;" 
            mode="forward" 
            loop 
            autoplay>
        </dotlottie-wc>
    </a>
</div>

<div id="lottie-banner-mobile">
    <div class="close"><img src="images/bad-close.svg" /></div>
    <a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank">
        <dotlottie-wc
            src="https://lottie.host/c1dd3267-9b5c-4011-bcd5-51b3c7e01be1/qk8EQOxYwW.lottie"
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
    #lottie-banner {
        display: block;
    }
    #lottie-banner-mobile {
        display: none;
    }
    #lottie-banner,
    #lottie-banner-mobile {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        margin: auto;
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
            display: none;
        }
        #lottie-banner-mobile {
            display: block;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bannerDesktop = document.getElementById('lottie-banner');
    const bannerMobile = document.getElementById('lottie-banner-mobile');
    const closeDesktop = bannerDesktop.querySelector('.close');
    const closeMobile = bannerMobile.querySelector('.close');
    
    function hideBanners() {
        bannerDesktop.style.opacity = '0';
        bannerMobile.style.opacity = '0';
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

        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const shouldShow = scrollTop >= 1000;
        const isMobile = window.innerWidth <= 768;
        
        if (shouldShow) {
            if (isMobile) {
                bannerMobile.style.display = 'block';
                bannerDesktop.style.display = 'none';
            } else {
                bannerDesktop.style.display = 'block';
                bannerMobile.style.display = 'none';
            }
        } else {
            bannerDesktop.style.display = 'none';
            bannerMobile.style.display = 'none';
        }
    }
    
    checkScroll();
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
});
</script>