
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.7.1/dist/dotlottie-wc.js" type="module"></script>
<a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank"
    id="lottie-banner"
>
    <dotlottie-wc 
        src="https://lottie.host/d479cfd5-9ee2-4029-8c33-89d45691b62d/weUkdnuK0x.lottie" 
        speed="1" 
        style="width:100%;aspect-ratio:1440 / 120;" 
        mode="forward" 
        loop 
        autoplay>
    </dotlottie-wc>
</a>

<a href="https://www.eapteka.ru/goods/brand/repro/" target="_blank"
    id="lottie-banner-mobile"
>
    <dotlottie-wc
        src="https://lottie.host/c1dd3267-9b5c-4011-bcd5-51b3c7e01be1/qk8EQOxYwW.lottie"
        style="margin:auto"
        speed="1"
        autoplay
        loop
    ></dotlottie-wc>
</a>

<style>
    #lottie-banner {
        display:block;
        position:fixed;
        bottom:20px;
        left:20px;
        right:20px;
        z-index:1000;
        width:calc(100% - 40px);
        opacity:0;
        transition:opacity 0.3s ease;
    }
    #lottie-banner-mobile {
        display: none;
        position:fixed;
        bottom:20px;
        left:20px;
        right:20px;
        margin:auto;
        z-index:1000;
        width:calc(100% - 40px);
        opacity:0;
        transition:opacity 0.3s ease;
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
    
    function checkScroll() {
        const documentHeight = document.documentElement.scrollHeight;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const windowHeight = window.innerHeight;
        const shouldShow = scrollTop >= 1000;
        const isMobile = window.innerWidth <= 768;
        
        if (shouldShow) {
            if (isMobile) {
                bannerMobile.style.opacity = '1';
                bannerDesktop.style.opacity = '0';
            } else {
                bannerDesktop.style.opacity = '1';
                bannerMobile.style.opacity = '0';
            }
        } else {
            bannerDesktop.style.opacity = '0';
            bannerMobile.style.opacity = '0';
        }
    }
    
    checkScroll();
    window.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
});
</script>