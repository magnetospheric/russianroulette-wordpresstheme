/* =============================================================================

   Main js file associated with RussianRoulette theme

   ========================================================================= =*/
/* ********* */
/* ********* */
/* functions */
/* ********* */
/* ********* */

// this sets the height to match the width of targeted element
var squareRatioHeight = function(target) {
    console.log('made it inside');
    $(target).height( $(target).width() );
}

var articleHeight = 0;
var titleHeight = 0;

// this slides up contents of targeted element
var revealIntro = function(target) {
    articleHeight = $( target ).height();
    titleHeight = $( target ).children('.titles').height();

    heightOffset = (articleHeight - titleHeight) + 24;

    $( target ).children('.titles').children().addClass('hovered');
    $( target ).children('.titles').animate({
            bottom: heightOffset,
        }, 400, function() {
            // Animation complete.
    });
    $( target ).children('.text').removeClass('hidden').animate({
        top: "-=50%",
    }, 400, function() { // Animation complete.
    });
}

// animates sliding intro back down
var hideIntro = function(target) {
    $( target ).children('.titles').children().removeClass('hovered');
    $( target ).children('.titles').animate({
            bottom: 0
        }, 400, function() {
            // Animation complete.
            $( target ).removeClass('hovered', {duration:1500});
    });
    $( target ).children('.text').animate({
        top: "+=50%",
    }, 400, function() { // Animation complete.
        $( this ).addClass('hidden');
    });
}


/* *************** */
/* *************** */
/* implementations */
/* *************** */
/* *************** */

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

    // calculate height of blogroll articles
    squareRatioHeight("#blogroll article");

    // slide up and reveal introduction on blogroll articles
    $('#blogroll article').mouseenter( function(){
        revealIntro(this);
    });

    // slide down and hide introduction on blogroll articles
    $('#blogroll article').mouseleave( function(){
        hideIntro(this);
    });

});

// add actions to window resize
if(window.addEventListener) {
    window.addEventListener('resize', function() {
        squareRatioHeight("#blogroll article")
    }, true);
}
