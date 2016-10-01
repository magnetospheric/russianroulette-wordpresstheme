<?php
/**
 * russianroulette functions and definitions
 *
 * @package russianroulette
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1024; /* pixels */

if ( ! function_exists( 'russianroulette_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function russianroulette_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on russianroulette, use a find and replace
	 * to change 'russianroulette' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'russianroulette', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'russianroulette' ),
	) );

  	register_nav_menus( array(
		'secondary' => __( 'Secondary Menu', 'russianroulette' ),
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'russianroulette_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
}
endif; // russianroulette_setup
add_action( 'after_setup_theme', 'russianroulette_setup' );


/**
 * Enqueue scripts and styles.
 */

 //enqueue jquery
 function register_jquery() {
	 wp_deregister_script( 'jquery' );
	 wp_register_script( 'jquery', ( 'https://code.jquery.com/jquery-3.0.0.min.js' ), false, null, true );
	 wp_enqueue_script( 'jquery' );
 }
 add_action( 'wp_enqueue_scripts', 'register_jquery' );

function russianroulette_scripts() {
	wp_enqueue_style( 'russianroulette-style', get_stylesheet_uri() );

	wp_enqueue_style( 'russianroulette-slickstyles', get_template_directory_uri() . '/css/slick.css');

	wp_enqueue_style( 'russianroulette-fontawesome', get_template_directory_uri() . '/webfonts/font-awesome-4.6.3/css/font-awesome.min.css');

	wp_enqueue_style( 'russianroulette-jqueryui', get_template_directory_uri() . '/css/jquery-ui.min.css');

	wp_enqueue_script( 'russianroulette-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'russianroulette-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'russianroulette-slick-slider', get_template_directory_uri() . '/js/slick.min.js', array(), '20160625', true );

	wp_enqueue_script( 'russianroulette-jqueryui', get_template_directory_uri() . '/js/jquery-ui.min.js', array(), '20160625', true );

	wp_enqueue_script( 'russianroulette-script', get_template_directory_uri() . '/js/script.js', array(), '20160625', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

}
add_action( 'wp_enqueue_scripts', 'russianroulette_scripts' );




// custom admin styling
function admin_custom_enqueue( $hook ) {
	wp_register_style( 'russianroulette-fontawesome', get_template_directory_uri() . '/webfonts/font-awesome-4.6.3/css/font-awesome.min.css', false, '1.0.0' );
	wp_enqueue_style( 'russianroulette-fontawesome');

	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );

	wp_register_script( 'admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('admin');
}
add_action('admin_enqueue_scripts', 'admin_custom_enqueue', 2000);




/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
* Custom RR functions and action/hooks
*/
require get_template_directory() . '/inc/customfields.php';

/**
 * Custom RR functions and action/hooks
 */
require get_template_directory() . '/inc/rr-funcs.php';
