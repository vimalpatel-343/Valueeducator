document.addEventListener('DOMContentLoaded', function() {
    // Initialize Swiper for mobile view
    const swiper = new Swiper('.sc-choose-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
});