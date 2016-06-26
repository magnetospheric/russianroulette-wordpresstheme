/* =============================================================================

   Main js file associated with RussianRoulette theme

   ========================================================================= =*/

$( document ).ready(function() {


    /* initialise slick slider for CAROUSEL */
    $('.carousel-init').slick({
         dots: true,
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 3000000,
         pauseOnFocus: true
    });

    // add hover state for carousel articles
    $('#carousel').hover( function(){
        $(this).find('.featuredImage img').addClass('blur-focus');
    });
    $('#carousel').mouseleave( function(){
        $(this).find('.featuredImage img').removeClass('blur-focus');
    });


});
