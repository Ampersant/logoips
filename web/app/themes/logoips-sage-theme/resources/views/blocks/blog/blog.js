// /* 
//   Implementation of Slider with tags
// */

document.addEventListener('DOMContentLoaded', function () {
  const swiperEl = document.querySelector('.mySwiper');
  const swiper = new Swiper(swiperEl, {
    loop: true,
    slidesPerView: 4,
    spaceBetween: 30,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    scrollbar: {
      el: '.swiper-scrollbar',
    },
    breakpoints: {
      // Screen width  >= 1400px — 4 Slides
      1400: {
        slidesPerView: 4
      },
      // Screen width >= 1200px — 3 Slides
      1200: {
        slidesPerView: 3
      },
      // Screen width >= 992px — 2 Slides
      992: {
        slidesPerView: 2
      },
      // Screen width < 992px — 1 Slide
      0: {
        slidesPerView: 1
      }
    },
  });

  const slides = Array.from(swiperEl.querySelectorAll('.swiper-slide'));
  const checkboxes = Array.from(document.querySelectorAll('.btn-check'));

  function filterSlides() {
    const checkedTags = checkboxes
      .filter(cb => cb.checked)
      .map(cb => cb.dataset.tag);

    // Show All special case
    if (checkedTags.includes('all')) {
      slides.forEach(slide => slide.style.display = '');
    } else if (checkedTags.length === 0) {
      slides.forEach(slide => slide.style.display = 'none');
    } else {
      slides.forEach(slide => {
        const tags = (slide.dataset.tags || '').split(',').map(t => t.trim());
        const show = tags.some(t => checkedTags.includes(t));
        slide.style.display = show ? '' : 'none';
      });
    }

    // update swiper after DOM changes
    swiper.update();
    swiper.slideTo(0);
  }

  // logic for checkboxes
  checkboxes.forEach(cb => {
    cb.addEventListener('change', function () {
      if (this.dataset.tag === 'all' && this.checked) {
        checkboxes
          .filter(other => other.dataset.tag !== 'all')
          .forEach(other => other.checked = false);
      }
      if (this.dataset.tag !== 'all' && this.checked) {
        const allCb = document.querySelector('.btn-check[data-tag="all"]');
        if (allCb) allCb.checked = false;
      }
      const anyChecked = checkboxes.some(x => x.checked);
      if (!anyChecked) {
        const allCb = document.querySelector('.btn-check[data-tag="all"]');
        if (allCb) allCb.checked = true;
      }
      filterSlides();
    });
  });
  filterSlides();
});