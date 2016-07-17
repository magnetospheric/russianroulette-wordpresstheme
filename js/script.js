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

    heightOffset = (articleHeight - titleHeight) + 50;

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

jQuery( document ).ready(function() {

    /* search hover */
    // var timeoutId;
    // $(".search-reveal").hover(function() {
    //     if (!timeoutId) {
    //         timeoutId = window.setTimeout(function() {
    //             timeoutId = null;
    //             $('#search').addClass('reveal');
    //             $('#search').animate({
    //                 width: "33.3%"
    //             }, {
    //                 duration: 800,
    //                 complete: function () {
    //                 }
    //             });
    //        }, 1000);
    //     }
    // },
    // function () {
    //     if (timeoutId) {
    //         window.clearTimeout(timeoutId);
    //         timeoutId = null;
    //     }
    //     else {
    //     }
    // });


    $('#search').hover(function() {
        clearTimeout($(this).data('timeout'));
        $('#search').addClass('reveal');
        $('#search').animate({
            width: "33.3%"
        }, {
            duration: 500,
            complete: function () {
            }
        });
    }, function() {
        var t = setTimeout(function() {
            $('#search').animate({
                width: "11%"
            }, {
                duration: 500,
                complete: function () {
                    $('#search').removeClass('reveal');
                }
            });
        }, 200);
        $(this).data('timeout', t);
    });

    // $('#search').hover( function () {
    //     //$('#search').addClass('reveal');
    //     $('#search').animate({
    //         width: "33.3%"
    //     }, {
    //         duration: 500,
    //         complete: function () {
    //         }
    //     });
    // },function()    {
    //     $('#search').animate({
    //         width: "11%"
    //     }, {
    //         duration: 500,
    //         complete: function () {
    //             //$('#search').removeClass('reveal');
    //         }
    //     });
    // }
    // );

    // $('#search').mouseleave( function () {
    //     $('#search').animate({
    //         width: "11%"
    //     }, {
    //         duration: 500,
    //         complete: function () {
    //             //$('#search').removeClass('reveal');
    //         }
    //     });
    // });


    // $('.search-reveal').hover( function(){
    //     $('#search').addClass('reveal');
    //     $('#search').animate({
    //         width: "33.3%"
    //     }, {
    //         duration: 500,
    //         complete: function () {
    //             $('#search').hover( function(){
    //                 $('#search').addClass('reveal');
    //             });
    //         }
    //     });
    // });
    //
    // $('#search').hover( function(){
    //     if ( $('#search').hasClass('.reveal') ) {
    //     } else {
    //         $('#search').addClass('reveal');
    //     }
    // });
    //
    // $('#search').mouseleave( function(){
    //     $('#search').animate({
    //         width: "0%"
    //     }, {
    //         duration: 500,
    //         complete: function () {
    //             //$('#search').removeClass('reveal');
    //         }
    //     });
    // });

    /* initialise slick slider for CAROUSEL */
    $('.carousel-init').slick({
         dots: true,
         slidesToShow: 1,
         slidesToScroll: 1,
         autoplay: true,
         autoplaySpeed: 4000,
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

    // append triangle inside of prev and next links
    $('.pagination .triangle-right').detach().appendTo('.next');
    $('.pagination .triangle-left').detach().appendTo('.prev');
});

// add actions to window resize
if(window.addEventListener) {
    window.addEventListener('resize', function() {
        squareRatioHeight("#blogroll article")
    }, true);
}
