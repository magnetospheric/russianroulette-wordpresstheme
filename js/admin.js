/*
Custom Admin js for RussianRoulette theme


*/

jQuery(function() {
    jQuery('h2').each(function() {
        if ( jQuery(this).text() === 'About Yourself' ) {
            jQuery(this).hide();
            jQuery(this).next().hide();
        }
    });
    jQuery('tr').each(function() {
        if ( jQuery(this).hasClass('user-url-wrap') ) {
            jQuery(this).hide();
        }
    });

});
