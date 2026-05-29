$(document).ready(function () {

    $('.slider').each(function () {

        $(this).slick({
            arrows: true,
            dots: false,
            infinite: true
        });

    });

 

$('.accordion-collapse.show .mobile-slider').slick({
    arrows: true,
    dots: true,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1
});

$('.accordion-collapse').on('shown.bs.collapse', function () {

    let slider = $(this).find('.mobile-slider');

    if (!slider.hasClass('slick-initialized')) {

        slider.slick({
            arrows: true,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });

    } else {

        slider.slick('setPosition');

    }

});




    // Update Right Image
    function updateImage(slider) {

        let currentSlide = $(slider).find('.slick-current');

        let image = currentSlide.attr('data-image');

        $('#preview-image').attr('src', image);
    }

    // First Load
    let activeSlider = $('.tab-pane.active .slider');

    updateImage(activeSlider);

    // On Slide Change
    $('.slider').on('afterChange', function () {

        updateImage(this);

    });

    // On Tab Button Click
    $('button[data-bs-toggle="pill"]').on('click', function () {

        let tabId = $(this).attr('data-bs-target');

        let activeSlider = $(tabId).find('.slider');

        setTimeout(function () {

            activeSlider.slick('setPosition');

            updateImage(activeSlider);

        }, 200);

    });

});