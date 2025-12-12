// home.js - JavaScript específico para la página principal

(function() {
  // INITIALIZATION OF HEADER
  // =======================================================
  new HSHeader('#header').init()


  // INITIALIZATION OF MEGA MENU
  // =======================================================
  new HSMegaMenu('.js-mega-menu', {
      desktop: {
        position: 'left'
      }
    })


  // INITIALIZATION OF SHOW ANIMATIONS
  // =======================================================
  new HSShowAnimation('.js-animation-link')


  // INITIALIZATION OF BOOTSTRAP VALIDATION
  // =======================================================
  HSBsValidation.init('.js-validate', {
    onSubmit: data => {
      data.event.preventDefault()
      alert('Submited')
    }
  })


  // INITIALIZATION OF BOOTSTRAP DROPDOWN
  // =======================================================
  HSBsDropdown.init()


  // INITIALIZATION OF GO TO
  // =======================================================
  new HSGoTo('.js-go-to')


  // INITIALIZATION OF AOS
  // =======================================================
  AOS.init({
    duration: 650,
    once: true
  });


  // INITIALIZATION OF SWIPER
  // =======================================================
  let activeIndex = 0
  var sliderThumbs = new Swiper('.js-swiper-thumbs', {
    slidesPerView: 1,
    autoplay: {
    delay: 7500,
    disableOnInteraction: true,
  },
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    followFinger: false,
    loop: true,
    on: {
      'slideChangeTransitionEnd': function (event) {
        if (sliderMain === undefined) return
        sliderMain.slideTo(event.activeIndex)
      }
    }
  });

  var sliderMain = new Swiper('.js-swiper-main', {
    effect: 'fade',
    autoplay: {
    delay: 7500,
    disableOnInteraction: true,
  },
    loop: true,
    navigation: {
      nextEl: '.js-swiper-main-button-next',
      prevEl: '.js-swiper-main-button-prev',
    },
    thumbs: {
      swiper: sliderThumbs
    },
    on: {
      'slideChangeTransitionEnd': function (event) {
        if (sliderThumbs === undefined) return
        sliderThumbs.slideTo(event.activeIndex)
      }
    }
  })

  // Clients
  var swiper = new Swiper('.js-swiper-clients',{
    slidesPerView: 2,
    breakpoints: {
      380: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      768: {
        slidesPerView: 4,
        spaceBetween: 15,
      },
      1024: {
        slidesPerView: 5,
        spaceBetween: 15,
      },
    },
  });

  // Card Grid
  var swiper = new Swiper('.js-swiper-card-blocks',{
    slidesPerView: 1,
    autoplay: {
      delay: 2500,
      disableOnInteraction: true,
    },
    pagination: {
      el: '.js-swiper-card-blocks-pagination',
      dynamicBullets: true,
      clickable: true,
    },
    breakpoints: {
      620: {
        slidesPerView: 2,
        spaceBetween: 15,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
    },
  });
  
})()
