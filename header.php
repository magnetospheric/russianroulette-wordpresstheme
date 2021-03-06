<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package russianroulette
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>


<div id="fb-root"></div>

<!-- <script>

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script> -->

<!-- fonts.com css api -->
<link type="text/css" rel="stylesheet" href="//fast.fonts.net/cssapi/c79fb7e9-f862-4533-8abd-f52081d13e7e.css"/>

</head>

<body <?php body_class('hide-overlay'); ?> id="mainbody">
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding">

            <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'russianroulette' ); ?></a>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<span class="search-reveal"><i class="fa fa-search"></i></span>

            <div id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</div>

		    <div class="title-small">Renegade Revolution</div>

		</div>

        <button class="hamburger hamburger--collapse" type="button">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </button>

	</header><!-- #masthead -->
	<nav id="mainnav">
		<?php wp_nav_menu( array( 'theme_location' => 'primary_head' ) ); ?>
	</nav>

	<div id="content" class="site-content">
