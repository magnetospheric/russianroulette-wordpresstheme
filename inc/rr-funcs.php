<?php
/**
 * Custom functions specific to RR setup
 *
 *
 * @package russianroulette
 */



 /*===================================================================================
  * Register widgetized area and update sidebar with default widgets.
  * =================================================================================*/

 function russianroulette_widgets_init() {
 	register_sidebar( array(
 		'name'          => __( 'Sidebar', 'russianroulette' ),
 		'id'            => 'sidebar-1',
 		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
 		'after_widget'  => '</aside>',
 		'before_title'  => '<h1 class="widget-title">',
 		'after_title'   => '</h1>',
 	) );
 }
 add_action( 'widgets_init', 'russianroulette_widgets_init' );


 /*===================================================================================
  * Add support for post featured image
  * =================================================================================*/

add_theme_support( 'post-thumbnails' );

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
        set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions
}


/*===================================================================================
 * Add own image sizes
 * =================================================================================*/

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'x-large', 1366, 768 ); //1500 wide, 775 high
	add_image_size( 'large', 712, 400 ); //680 pixels wide (and unlimited height)
	add_image_size( 'thumb', 220, 180, true ); //(cropped)
	add_image_size( 'small', 537, 263, true ); //(small - for minor features)
}


/*===================================================================================
 * Adds gallery shortcode defaults of size="medium" and columns="2"
 * =================================================================================*/

function russianroulette_gallery_atts( $out, $pairs, $atts ) {

    $atts = shortcode_atts( array(
        'columns' => '2',
        'size' => 'galleryimg',
         ), $atts );

    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];

    return $out;

}
add_filter( 'shortcode_atts_gallery', 'russianroulette_gallery_atts', 10, 3 );


/*===================================================================================
 * Add pagination function
 * =================================================================================*/

if ( ! function_exists( 'my_pagination' ) ) :
	function my_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer

		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
	}
endif;

/*===================================================================================
 * Register sidebars
 * =================================================================================*/
if ( function_exists('register_sidebar') )
register_sidebar(array('name'=>'sidebar1',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));

register_sidebar(array('name'=>'sidebar2',
'before_widget' => '',
'after_widget' => '',
'before_title' => '<h4>',
'after_title' => '</h4>',
));


/*===================================================================================
 * Add Author Links
 * =================================================================================*/
function add_to_author_profile( $contactmethods ) {

	$contactmethods['shortbio'] = 'Short Bio (for sidebar) e.g. Editor, Games';
	$contactmethods['google_profile'] = 'Google Profile URL';
	$contactmethods['twitter_profile'] = 'Twitter Profile URL';
	$contactmethods['facebook_profile'] = 'Facebook Profile URL';
	$contactmethods['linkedin_profile'] = 'Linkedin Profile URL';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_to_author_profile', 10, 1);

function pagination_on_archive($query){
    if ($query->is_archive) {
            $query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1 );
   }
    return $query;
}

add_filter('pre_get_posts', 'pagination_on_archive');

function pagination_on_search($query){
    if ($query->is_search) {
            $query->set('paged', (get_query_var('paged')) ? get_query_var('paged') : 1 );
   }
    return $query;
}

add_filter('pre_get_posts', 'pagination_on_search');

function add_title_attachment_link($link, $id = null) {
	$id = intval( $id );
	$_post = get_post( $id );
	$post_title = esc_attr( $_post->post_title );
	return str_replace('<a href', '<a title="'. $post_title .'" href', $link);
}
add_filter('wp_get_attachment_link', 'add_title_attachment_link', 10, 2);


/* ====================================================================================
 * Restrict the_excerpt to just 25 words
 * ==================================================================================*/
function custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/* ====================================================================================
 * Modify tag cloud defaults
 * ==================================================================================*/
function custom_tag_cloud_widget($args) {
	$ex_term = get_term_by( 'slug', 'featured', 'post_tag' );
    $args = array(
        'smallest' => 0.8,
        'largest' => 1.7,
        'unit' => 'em',
        'number' => 40,
        'format' => 'flat',
        'separator' => "\n",
        'orderby' => 'name',
        'order' => 'ASC',
        'exclude' => $ex_term->term_id,
        'include' => '',
        'link' => 'view',
        'taxonomy' => 'post_tag',
        'post_type' => '',
        'echo' => true
    );
    return $args;
}
add_filter( 'widget_tag_cloud_args', 'custom_tag_cloud_widget' );


/*===================================================================================
 * Modifies meta query to allow posttype param in http request
 * =================================================================================*/

add_action('pre_get_posts', 'my_pre_get_posts');

function my_pre_get_posts( $query )
{
	// validate
	if( is_admin() )
	{
		return;
	}

	// get original meta query
	$meta_query = $query->get('meta_query');

        // allow the url to alter the query
        // eg: http://www.website.com/?posttype=longform
        if( !empty($_GET['posttype']) )
        {

        	$posttype = explode(',', $_GET['posttype']);

        	//Add our meta query to the original meta queries
	    	$meta_query[] = array(
                'key'		=> 'posttype',
                'value'		=> $_GET['posttype'],
                'compare'	=> '=',
                'is_archive' => 'true',
            );
        }

	// update the meta query args
	$query->set('meta_query', $meta_query);

	// always return
	return;

}
