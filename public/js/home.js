var Webflow = Webflow || [];
Webflow.push(function() {
  $('.map-widget-button').on('tap', function(event) {
    event.preventDefault();
    const inputValue = $('input[name="search"]').val();
    if(inputValue?.length > 0) {
      window.location.href = `/map?search=${inputValue}`;
    }
  })
});


(() => {
  const swiperConfig = {
    slidesPerView: 'auto',
    grabCursor: true,
    spaceBetween: 0,
    centeredSlides: true,
    mousewheel: {
      forceToAxis: true,
      releaseOnEdges: true,
    },
  }

  function getNavigation(el) {
    return {
      nextEl: el.querySelector('.next-slider-button'),
      prevEl: el.querySelector('.prev-slider-button')
    }
  }

  const top5widget = document.querySelector('.top-5-widget');
  if(top5widget) {
    const slider = top5widget.querySelector('.top-5-slider');
    new Swiper(slider, { 
      ...swiperConfig,
      wrapperClass: "top-5-slider-wrap",
      slideClass: "top-5-slide",
      loop: true,
      navigation: getNavigation(top5widget),
      pagination: {
        el: top5widget.querySelector('.top-5-slider-pagination'),
        bulletClass: 'top-5-slider-dot',
        bulletActiveClass: 'active',
        clickable: true,
        renderBullet: (index, className) => '<div class="' + className + '">' + (index + 1) + "</div>"
      },
      autoplay: {
        delay: 3000,
        pauseOnMouseEnter: true,
        disableOnInteraction: true
      },
    });
  }

  const questionsWidget = document.querySelector('.questions-widget');
  if(questionsWidget) {
    const slider = questionsWidget.querySelector('.questions-slider');

    function sideSlide(translate, rotate) {
      return {
        translate: [translate, "0.25rem", 0],
        rotate: [0, 0, rotate],
        scale: 0.9,
        shadow: true,
      }
    }

    new Swiper(slider, {
      ...swiperConfig,
      wrapperClass: "questions-slider-wrap",
      slideClass: "questions-slide",
      activeClass: "active",
      navigation: getNavigation(questionsWidget),
      effect: "creative",
      creativeEffect: {
        limitProgress: 2,
        shadowPerProgress: true,
        prev: sideSlide("-2rem", -3),
        next: sideSlide("2rem", 3),
      },
      speed: 300,
    });
  }
})();
