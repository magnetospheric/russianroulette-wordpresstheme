/* =============================================================================

   Main js file associated with RussianRoulette theme

   ========================================================================= =*/

/* *********** */
/* *********** */
/* global vars */
/* *********** */
/* *********** */

// vars for scroll animation
var pos1 = 0;
var navOffset = jQuery("#site-navigation").offset();
var pos2 = (Math.floor(navOffset["top"])) - 10;
var eventListenerPaused = false;
var scrolledToPos2 = false;
var currentScroll = 0;

var viewportHeight = $(window).height();
var scrollDownHeight = ( viewportHeight / 100) * 10;



/* ********* */
/* ********* */
/* functions */
/* ********* */
/* ********* */

function scrollBetween(pos1, pos2, scrolledToPos2) {
    if ( scrolledToPos2 == true ) {
        jQuery('html, body').animate({
            scrollTop: pos1
        }, 500);
        jQuery('.scrollDown i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
    } else {
        jQuery('html, body').animate({
            scrollTop: pos2
        }, 500);
        jQuery('.scrollDown i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
    }
}


// this sets the height to match the width of targeted element
var squareRatioHeight = function(target) {
    jQuery(target).height( jQuery(target).width() );
}

// this stops height from being fixed if width : height ratio is less than 2:1
var shortHeightCarouselAdjuster = function(target) {
    var windowHeight = $(window).height();
    var windowWidth = $(window).width();
    if ( windowHeight < ( windowWidth / 2.2 )  ) {
        jQuery(target).addClass('naturalHeight');
    } else {
        jQuery(target).removeClass('naturalHeight');
        if ( target == '#carousel' ) {
            // add height offset for carousel
            var mainNavHeight = jQuery('#mainnav').height();
            var heightOffsetCarousel = 140 + mainNavHeight;
            // console.log(heightOffsetCarousel);
            jQuery('#carousel').css('height', 'calc(100vh - ' + heightOffsetCarousel + 'px)');
        }
    }
}

var changeHamburgerOffset = function(target) {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        jQuery(target).animate({
            top: "0px"
        }, 400);
    } else {
        jQuery(target).animate({
            top: "100px"
        }, 400);
    }
}

// this slides up contents of targeted element
var articleHeight = 0;
var titleHeight = 0;

var revealIntro = function( target ) {

    $( target ).addClass( 'informationVisible' );

    articleHeight = jQuery( target ).height();
    titleHeight = jQuery( target ).children('.titles').height();

    heightOffset = (articleHeight - titleHeight) + 50;

    jQuery( target ).children('.titles').children().addClass('hovered');
    jQuery( target ).children('.titles').animate({
        bottom: heightOffset,
    }, 400, function() {
        // Animation complete.
    });

    jQuery( target ).children('.text').removeClass('hidden').animate({
        top: "-=50%",
    }, 400, function() {
        // Animation complete.
    });
}

// animates sliding intro back down
var hideIntro = function( target ) {
    $( target ).removeClass( 'informationVisible' );

    jQuery( target ).children('.titles').children().removeClass('hovered');
    jQuery( target ).children('.titles').animate({
        bottom: 0
    }, 400, function() {
        // Animation complete.
        jQuery( target ).removeClass('hovered', {duration:1500});
    });
    jQuery( target ).children('.text').animate({
        top: "+=50%",
    }, 400, function() { // Animation complete.
        jQuery( this ).addClass('hidden');
    });

}

var enqueueBlurbTransition = function( currentArticle, isMouseEnter, delay ) {
    var secondaryCount = isMouseEnter ? 'leaveCount' : 'enterCount';
    var focusCount = isMouseEnter ? 'enterCount' : 'leaveCount';

    var currentSecondaryCount = parseInt(jQuery( currentArticle ).attr(secondaryCount));
    currentSecondaryCount += 1;
    jQuery( currentArticle ).attr(secondaryCount, currentSecondaryCount);


    var currentFocusCount = parseInt(jQuery( currentArticle ).attr(focusCount));
    currentFocusCount += 1;
    jQuery( currentArticle ).attr(focusCount, currentFocusCount);

    setTimeout( function() {
        var isVisible = jQuery( currentArticle ).hasClass( 'informationVisible' );
        var anim = isMouseEnter ? revealIntro : hideIntro;
        if ( ( isMouseEnter && !isVisible ) || ( !isMouseEnter && isVisible ) ) {
            if ( jQuery( currentArticle ).attr(focusCount) == currentFocusCount ) {
                anim(currentArticle);
            }
        }
    }, delay );
}

var hamburgerInit = function(button, menu) {

    if ( jQuery('body').hasClass('hide-overlay') ) {
        currentScroll = jQuery('body').scrollTop();
    }

    var overlay = document.querySelector("body");
    overlay.classList.toggle('hide-overlay');

    var base = document.querySelector("html");
    base.classList.toggle('stopScroll'); // fixes height:100% scrollTop conflict

    jQuery('body').scrollTop(currentScroll);

}




/* ************************************************************************** */
/* ************************************************************************** */
/* ************************************************************************** */
/* ************************************************************************** */
/* ************************************************************************** */


/* *************** */
/* *************** */
/* implementations */
/* *************** */
/* *************** */

jQuery( document ).ready(function() {

    // move sidebar out of dom tree to below main content
    var sidebar = jQuery('#sidebar').detach();
    jQuery('body').append(sidebar);

    jQuery('.search-field').click(function() {
        console.log('search clicked');
        //clearTimeout(jQuery(this).data('timeout'));
        jQuery('#search').addClass('reveal');
        jQuery('#search').animate({
            width: "33.3%"
        }, {
            duration: 500,
            complete: function () {
            }
        });
    });

    /* initialise slick slider for CAROUSEL */
    jQuery('.carousel-init').slick({
         dots: true,
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 4000,
         pauseOnFocus: true
    });

    // add hover state for carousel articles
    jQuery('#carousel .titles').hover( function(){
        jQuery("#carousel").find('.featuredImage img').addClass('blur-focus');
    });
    jQuery('#carousel .titles').mouseleave( function(){
        jQuery("#carousel").find('.featuredImage img').removeClass('blur-focus');
    });

    // set natural heights id width/height ratio too low
    if ( jQuery('#carousel').length ) {
        shortHeightCarouselAdjuster('#carousel');
    } else {
        // determine whether feature image should be natural height or vh
        shortHeightCarouselAdjuster('.featuredImage');
    }

    if ( jQuery("#main").hasClass('page1') ) {
        if ( document.body.scrollTop >= pos2 || document.documentElement.scrollTop >= pos2 ) {
            jQuery('.scrollDown i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
            scrolledToPos2 = true;
        }
        // scroll to nav area
        jQuery('.scrollDown').on('click', function(e) {
            e.preventDefault();
            scrollBetween(pos1, pos2, scrolledToPos2);
        });
    }

    jQuery('.hamburger').on('click', function() {
        jQuery(this).toggleClass('is-active');
        hamburgerInit(this, "#sidebar");
    });

    // calculate height of blogroll articles
    squareRatioHeight("#blogroll article");

    jQuery('#blogroll article').each( function () {
        jQuery(this).attr('enterCount', 0);
        jQuery(this).attr('leaveCount', 0);
    });

    // slide up and reveal introduction on blogroll articles
    jQuery('#blogroll article').mouseenter( function(){
        var currentArticle = this;
        enqueueBlurbTransition( currentArticle, true, 200);

    }).mouseleave( function(){
        var currentArticle = this;
        enqueueBlurbTransition( currentArticle, false, 200);
    });

    // append triangle inside of prev and next links
    jQuery('.pagination .triangle-right').detach().appendTo('.next');
    jQuery('.pagination .triangle-left').detach().appendTo('.prev');

    // append class to containing elements of all iframes, to allow centering
    jQuery('body').find('iframe').parent().addClass('iframe-container');

    if (document.body.scrollTop > 69 || document.documentElement.scrollTop > 69) {
        $("#mainnav").addClass('sticky');
        $("#content").addClass('sticky');
    } else {
        $("#mainnav").removeClass('sticky');
        $("#content").removeClass('sticky');
    }

});




// add actions to window resize

if(window.addEventListener) {
    window.addEventListener('resize', function() {
        // determine whether feature image should be natural height or vh
        if ( jQuery('#carousel').length ) {
            shortHeightCarouselAdjuster('#carousel');
        } else {
            // determine whether feature image should be natural height or vh
            shortHeightCarouselAdjuster('.featuredImage');
        }
        navOffset = jQuery("#site-navigation").offset();
        pos2 = (Math.floor(navOffset["top"])) - 10;
        viewportHeight = $(window).height();
        scrollDownHeight = ( viewportHeight / 100) * 10;
        squareRatioHeight("#blogroll article");
        squareRatioHeight(".relatedposts article");
        $('#carousel').css("height", ( viewportHeight - 140 ) + "px");
    }, true);

    // scroll animation between two positions
    // make navbar sticky if scrolled more than 70px from top
    window.addEventListener('scroll', function() {

        if ( jQuery("#main").hasClass('page1') ) {
            if ( eventListenerPaused == false ) {
                if ( scrolledToPos2 == true ) {
                    if ( ( document.body.scrollTop > pos1 || document.documentElement.scrollTop > pos1 )  && ( document.body.scrollTop < pos2 || document.documentElement.scrollTop < pos2 ) ) {
                        // jQuery('html, body').animate({
                        //     scrollTop: pos1
                        // }, 500);
                        eventListenerPaused = true;
                        jQuery('.scrollDown i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
                    }
                } else {
                    if ( ( document.body.scrollTop > pos1 || document.documentElement.scrollTop > pos1)  && ( document.body.scrollTop < pos2 || document.documentElement.scrollTop < pos2) ) {
                        // jQuery('html, body').animate({
                        //     scrollTop: pos2
                        // }, 500);
                        eventListenerPaused = true;
                        jQuery('.scrollDown i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
                    }
                }
            } else {
                if ( scrolledToPos2 == true ) {
                    if ( document.body.scrollTop === pos1 || document.documentElement.scrollTop === pos1 ) {
                        eventListenerPaused = false;
                        scrolledToPos2 = false;
                    }
                } else {
                    if ( document.body.scrollTop === pos2 || document.documentElement.scrollTop === pos2 ) {
                        eventListenerPaused = false;
                        scrolledToPos2 = true;
                    }
                }
            }
            if (document.body.scrollTop == 0 || document.documentElement.scrollTop == 0) {
                jQuery('.scrollDown i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            }
        }

        if (document.body.scrollTop > 69 || document.documentElement.scrollTop > 69) {
            $("#mainnav").addClass('sticky');
            $("#content").addClass('sticky');
            $(".hamburger").addClass('sticky');
        } else {
            $("#mainnav").removeClass('sticky');
            $("#content").removeClass('sticky');
            $(".hamburger").removeClass('sticky');
        }

    });
}
