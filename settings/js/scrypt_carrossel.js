new Swiper('.card-wrapper', {
  loop: true,
  spaceBetween: 20, // Espaço entre os slides

  // Paginação
  pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true
  },

  // Navegação
  navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
  },

  breakpoints: {
      0: {
          slidesPerView: 1
      },
      768: {
          slidesPerView: 2
      },
      1024: {
          slidesPerView: 3
      },
  }
});

  /* AOS */  

  AOS.init({
    duration: 1000,
    easing: 'ease-in-out',
    once: false
  });