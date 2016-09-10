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

var changeScrollDownHeight = function(target) {
    jQuery(target).css("font-size", scrollDownHeight + "px");
}

var changeHamburgerOffset = function(target) {
    console.log(document.body.scrollTop);
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

var revealIntro = function(target) {
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
    }, 400, function() { // Animation complete.
    });
}


// animates sliding intro back down
var hideIntro = function(target) {
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

var hamburgerInit = function(button, menu) {

    var overlay = document.querySelector("body");
    overlay.classList.toggle('hide-overlay');


    // // set current scroll position and offset sidebar height based on it
    // var currentScrollPosition = document.body.scrollTop;
    // var currentScrollPositionPlusBuffer = document.body.scrollTop + 187;
    //
    // // animate slide-in-out
    // jQuery(button).toggleClass('is-active');
    //
    // if ( jQuery(menu).hasClass('active') ) {
    //
    //     // set classes on elements beneath sidebar overlay
    //     jQuery('#page').removeClass('stopScroll');
    //
    //     // move hamburger out of dom tree to join sidebar
    //     var hamburger = jQuery('.hamburger').detach();
    //     jQuery('#masthead').append(hamburger);
    //
    //     jQuery(menu).animate({
    //         opacity: 0,
    //         right: "-=100%"
    //     }, 400, function () {
    //         jQuery(menu).removeClass('active');
    //     });
    //
    // } else {
    //
    //     jQuery(menu).addClass('active');
    //
    //     // set classes on elements beneath sidebar overlay
    //     jQuery('#page').addClass('stopScroll');
    //
    //     // move hamburger out of dom tree to join sidebar
    //     var hamburger = jQuery('.hamburger').detach();
    //     jQuery('#sidebar').append(hamburger);
    //
    //     jQuery(menu).animate({
    //         opacity: 1,
    //         right: "+=100%"
    //     }, 400, function () {
    //     });
    //
    // }

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
    
    jQuery('body').addClass('hide-overlay');

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
        jQuery('.scrollDown').on('click', function() {
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

    // setScrollDown size
    changeScrollDownHeight(".scrollDown");

    // slide up and reveal introduction on blogroll articles
    jQuery('#blogroll article').mouseenter( function(){
        revealIntro(this);
    });

    // slide down and hide introduction on blogroll articles
    jQuery('#blogroll article').mouseleave( function(){
        hideIntro(this);
    });

    // slide up and reveal introduction on blogroll articles
    jQuery('.relatedposts article').mouseenter( function(){
        revealIntro(this);
    });

    // slide down and hide introduction on blogroll articles
    jQuery('.relatedposts article').mouseleave( function(){
        hideIntro(this);
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
        changeScrollDownHeight(".scrollDown");

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
        }
    });
}
