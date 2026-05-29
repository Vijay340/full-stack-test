

$(document).ready(function () {

    /* =========================================
       DESKTOP SLIDER
    ========================================= */

    function initDesktopSlider(){

        $('.desktop-slider').each(function(){

            // already initialized
            if($(this).hasClass('slick-initialized')){
                return;
            }

            $(this).slick({
                slidesToShow:1,
                slidesToScroll:1,
                arrows:false,
                dots:true,
                infinite:true,
                autoplay:true,
                autoplaySpeed:3000,
                fade:true,
                adaptiveHeight:true
            });

        });

    }

    function destroyDesktopSlider(){

        $('.desktop-slider.slick-initialized').slick('unslick');

    }

    function updateDesktopImage(slider){

        let currentSlide = $(slider).find('.slick-current');

        let image = currentSlide.attr('data-image');

        if(image){
            $('#desktop-preview').attr('src', image);
        }

    }

    /* =========================================
       MOBILE SLIDER
    ========================================= */

    function initMobileSlider(){

        $('.mobile-slider').each(function(){

            if($(this).hasClass('slick-initialized')){
                return;
            }

            $(this).slick({
                slidesToShow:1,
                slidesToScroll:1,
                arrows:true,
                dots:true,
                infinite:true,
                adaptiveHeight:true
            });

        });

    }

    function destroyMobileSlider(){

        $('.mobile-slider.slick-initialized').slick('unslick');

    }

    /* =========================================
       DEVICE CHECK
    ========================================= */

    function handleResponsiveSlider(){

        if($(window).width() <= 768){

            // MOBILE

            destroyDesktopSlider();

            initMobileSlider();

        } else {

            // DESKTOP

            destroyMobileSlider();

            initDesktopSlider();

            setTimeout(function(){

                $('.desktop-slider').slick('setPosition');

                let firstDesktopSlider = $('.tab-pane.active .desktop-slider');

                updateDesktopImage(firstDesktopSlider);

            },300);

        }

    }

    /* FIRST LOAD */
    handleResponsiveSlider();

    /* RESIZE */
    $(window).on('resize', function(){

        handleResponsiveSlider();

    });

    /* DESKTOP AFTER CHANGE */
    $(document).on('afterChange', '.desktop-slider', function(){

        updateDesktopImage(this);

    });

    /* TAB CLICK */
   $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
    let target = $(e.target).attr("data-bs-target");
    let activeSlider = $(target).find('.desktop-slider');
    if(activeSlider.hasClass('slick-initialized')){
        activeSlider.slick('setPosition');
        activeSlider.slick('refresh');
    }
    updateDesktopImage(activeSlider);
});

    /* ACCORDION OPEN */
    $('.accordion-collapse').on('shown.bs.collapse', function(){

        let slider = $(this).find('.mobile-slider');

        setTimeout(function(){

            slider.slick('setPosition');

        },300);

    });

});

