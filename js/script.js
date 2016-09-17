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

var changeHamburgerOffset = function(target) {
    if (document.body.scrollTop > 100) {
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

var enqueueBlurbTransition = function( currentArticle, isMouseEnter, delay=200 ) {
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

    jQuery('#search').hover(function() {
        clearTimeout(jQuery(this).data('timeout'));
        jQuery('#search').addClass('reveal');
        jQuery('#search').animate({
            width: "33.3%"
        }, {
            duration: 500,
            complete: function () {
            }
        });
    }, function() {
        var t = setTimeout(function() {
            jQuery('#search').animate({
                width: "11%"
            }, {
                duration: 500,
                complete: function () {
                    jQuery('#search').removeClass('reveal');
                }
            });
        }, 200);
        jQuery(this).data('timeout', t);
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

    if ( jQuery("#main").hasClass('page1') ) {
        if ( document.body.scrollTop >= pos2 ) {
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
        hamburgerInit(this, "#sidebar");
    });

    // calculate height of blogroll articles
    squareRatioHeight("#blogroll article");

    // calculate height of blogroll articles
    squareRatioHeight(".relatedposts article");

    jQuery('#blogroll article').each( function () {
        jQuery(this).attr('enterCount', 0);
        jQuery(this).attr('leaveCount', 0);
    });

    // slide up and reveal introduction on blogroll articles
    jQuery('#blogroll article').mouseenter( function(){
        var currentArticle = this;

        enqueueBlurbTransition( currentArticle, true);

    }).mouseleave( function(){
        var currentArticle = this;

        enqueueBlurbTransition( currentArticle, false);

    });

    jQuery('.relatedposts article').each( function () {
        jQuery(this).attr('enterCount', 0);
        jQuery(this).attr('leaveCount', 0);
    });
    // slide up and reveal introduction on blogroll articles
    jQuery('.relatedposts article').mouseenter( function(){
        var currentArticle = this;

        enqueueBlurbTransition( currentArticle, true);
    });

    // slide down and hide introduction on blogroll articles
    jQuery('.relatedposts article').mouseleave( function(){
        var currentArticle = this;

        enqueueBlurbTransition( currentArticle, true);
    });

    // append triangle inside of prev and next links
    jQuery('.pagination .triangle-right').detach().appendTo('.next');
    jQuery('.pagination .triangle-left').detach().appendTo('.prev');

    // append class to containing elements of all iframes, to allow centering
    jQuery('body').find('iframe').parent().addClass('iframe-container');

});




// add actions to window resize

if(window.addEventListener) {
    window.addEventListener('resize', function() {
        navOffset = jQuery("#site-navigation").offset();
        pos2 = (Math.floor(navOffset["top"])) - 10;
        viewportHeight = $(window).height();
        scrollDownHeight = ( viewportHeight / 100) * 10;
        squareRatioHeight("#blogroll article");
        squareRatioHeight(".relatedposts article");
    }, true);

    // scroll animation between two positions
    window.addEventListener('scroll', function() {
        if ( jQuery("#main").hasClass('page1') ) {
            if ( eventListenerPaused == false ) {
                if ( scrolledToPos2 == true ) {
                    if ( ( document.body.scrollTop > pos1 )  && ( document.body.scrollTop < pos2 ) ) {
                        jQuery('html, body').animate({
                            scrollTop: pos1
                        }, 500);
                        eventListenerPaused = true;
                        jQuery('.scrollDown i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
                    }
                } else {
                    if ( ( document.body.scrollTop > pos1 )  && ( document.body.scrollTop < pos2 ) ) {
                        jQuery('html, body').animate({
                            scrollTop: pos2
                        }, 500);
                        eventListenerPaused = true;
                        jQuery('.scrollDown i').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
                    }
                }
            } else {
                if ( scrolledToPos2 == true ) {
                    if ( document.body.scrollTop === pos1 ) {
                        eventListenerPaused = false;
                        scrolledToPos2 = false;
                    }
                } else {
                    if ( document.body.scrollTop === pos2 ) {
                        eventListenerPaused = false;
                        scrolledToPos2 = true;
                    }
                }
            }
            if (document.body.scrollTop == 0) {
                jQuery('.scrollDown i').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            }
        }
    });
}
