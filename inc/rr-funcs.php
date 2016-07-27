<?php
/**
 * Custom functions specific to RR setup
 *
 *
 * @package russianroulette
 */



 // custom admin bar settings when logged in
 show_admin_bar( false );


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

if ( ! function_exists( 'rr_pagination' ) ) :
	function rr_pagination($query) {

		$big = 999999999; // need an unlikely integer
        $last_page = $query->max_num_pages;

		$paginate_links = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $query->max_num_pages,
            'type'      => 'array'
		) );

        foreach ( $paginate_links as $pgl ) {
            $innerHTML = getStringSegment($pgl, "'>", "</");
            if ( $innerHTML == (string)$last_page && strpos($pgl, 'current') === false ) {
                echo '<span class="last">of &nbsp;' . $pgl . '</span>';
            }
            elseif(  $innerHTML == (string)$last_page && strpos($pgl, 'current') !== false ) {
                echo $pgl;
                echo '<span class="last">of &nbsp;' . $pgl . '</span>';
            }
            elseif ( strpos($pgl, 'Previous') !== false ) {
                echo '<span class="prev-page">' . $pgl . '<div class="triangle-left"></div></span>';
            }
            elseif ( strpos($pgl, 'Next') !== false ) {
                echo '<span class="next-page">' . $pgl . '<div class="triangle-right"></div></span>';
            }
            elseif ( strpos($pgl, 'current') !== false ) {
                echo $pgl;
            }
            else { // do nothing
            }
        }
	}
endif;

function getStringSegment($str, $from, $to)
{
    $sub = substr($str, strpos($str, $from) + strlen($from), strlen($str));
    return substr($sub, 0, strpos($sub, $to));
}

the_posts_pagination( array(
	'mid_size'  => 2,
	'prev_text' => __( 'Back', 'textdomain' ),
	'next_text' => __( 'Onward', 'textdomain' ),
) );




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
 * Create Author list
 * =================================================================================*/
function create_author_list( $role ) {

    // list editors first
    $args  = array(
        'role' => $role,
        'orderby' => 'display_name'
    );

    // Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($args);

    $author_ids = $wp_user_query->get_results();

    foreach($author_ids as $author) :

        $curauth = get_userdata($author->ID);

        if($curauth->user_login !== 'admin') : // if name == admin don't display
            $user_link = get_author_posts_url($curauth->ID);
            $avatar = 'default'; ?>

            <div class="author" title="<?php echo $curauth->display_name; ?>">
                <a href="
                    <?php  echo get_author_posts_url( get_the_author_meta( 'ID', $curauth->ID ) );  ?>
                ">
                    <?php
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    if ( is_plugin_active('user-photo/user-photo.php') ) {
                        if(userphoto_exists($curauth)) {
                                userphoto_thumbnail($curauth);
                            }
                            else {
                                echo get_avatar($curauth->ID, 60);
                            }
                    }
                    else {
                        echo get_avatar($curauth->ID, 60);
                    }
                    ?>
                    <p class="name"><?php echo $curauth->display_name; ?></p>
                    <p><?php the_author_meta( 'shortbio', $curauth->ID ); ?></p>
                </a>
            </div>

        <?php endif;
    endforeach;

}



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




/*===================================================================================
 * Nav Menu Custom Fields - code from jennyragan.com
 * =================================================================================*/

/*
 * Saves new field to postmeta for navigation
 */
add_action('wp_update_nav_menu_item', 'custom_nav_update',10, 3);
function custom_nav_update($menu_id, $menu_item_db_id, $args ) {
    if ( is_array($_REQUEST['menu-item-custom']) ) {
        $custom_value = $_REQUEST['menu-item-custom'][$menu_item_db_id];
        update_post_meta( $menu_item_db_id, '_menu_item_custom', $custom_value );
    }
}

/*
 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
 */
add_filter( 'wp_setup_nav_menu_item','custom_nav_item' );
function custom_nav_item($menu_item) {
    $menu_item->custom = get_post_meta( $menu_item->ID, '_menu_item_custom', true );
    return $menu_item;
}

add_filter( 'wp_edit_nav_menu_walker', 'custom_nav_edit_walker',10,2 );
function custom_nav_edit_walker($walker,$menu_id) {
    return 'Walker_Nav_Menu_Edit_Custom';
}

/**
 * Copied from Walker_Nav_Menu_Edit class in core
 *
 * Create HTML list of nav menu input items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker_Nav_Menu
 */
class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
/**
 * @see Walker_Nav_Menu::start_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function start_lvl(&$output) {}

/**
 * @see Walker_Nav_Menu::end_lvl()
 * @since 3.0.0
 *
 * @param string $output Passed by reference.
 */
function end_lvl(&$output) {
}

/**
 * @see Walker::start_el()
 * @since 3.0.0
 *
 * @param string $output Passed by reference. Used to append additional content.
 * @param object $item Menu item data object.
 * @param int $depth Depth of menu item. Used for padding.
 * @param object $args
 */
function start_el(&$output, $item, $depth, $args) {
    global $_wp_nav_menu_max_depth;
    $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    ob_start();
    $item_id = esc_attr( $item->ID );
    $removed_args = array(
        'action',
        'customlink-tab',
        'edit-menu-item',
        'menu-item',
        'page-tab',
        '_wpnonce',
    );

    $original_title = '';
    if ( 'taxonomy' == $item->type ) {
        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
        if ( is_wp_error( $original_title ) )
            $original_title = false;
    } elseif ( 'post_type' == $item->type ) {
        $original_object = get_post( $item->object_id );
        $original_title = $original_object->post_title;
    }

    $classes = array(
        'menu-item menu-item-depth-' . $depth,
        'menu-item-' . esc_attr( $item->object ),
        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
    );

    $title = $item->title;

    if ( ! empty( $item->_invalid ) ) {
        $classes[] = 'menu-item-invalid';
        /* translators: %s: title of menu item which is invalid */
        $title = sprintf( __( '%s (Invalid)' ), $item->title );
    } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
        $classes[] = 'pending';
        /* translators: %s: title of menu item in draft status */
        $title = sprintf( __('%s (Pending)'), $item->title );
    }

    $title = empty( $item->label ) ? $title : $item->label;

    ?>
    <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
        <dl class="menu-item-bar">
            <dt class="menu-item-handle">
                <span class="item-title"><?php echo esc_html( $title ); ?></span>
                <span class="item-controls">
                    <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                    <span class="item-order hide-if-js">
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-up-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
                        |
                        <a href="<?php
                            echo wp_nonce_url(
                                add_query_arg(
                                    array(
                                        'action' => 'move-down-menu-item',
                                        'menu-item' => $item_id,
                                    ),
                                    remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                                ),
                                'move-menu_item'
                            );
                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
                    </span>
                    <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                    ?>"><?php _e( 'Edit Menu Item' ); ?></a>
                </span>
            </dt>
        </dl>

        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
            <?php if( 'custom' == $item->type ) : ?>
                <p class="field-url description description-wide">
                    <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                        <?php _e( 'URL' ); ?><br />
                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                    </label>
                </p>
            <?php endif; ?>
            <p class="description description-thin">
                <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                    <?php _e( 'Navigation Label' ); ?><br />
                    <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                </label>
            </p>
            <p class="description description-thin">
                <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                    <?php _e( 'Title Attribute' ); ?><br />
                    <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                </label>
            </p>
            <p class="field-link-target description">
                <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                    <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
                    <?php _e( 'Open link in a new window/tab' ); ?>
                </label>
            </p>
            <p class="field-css-classes description description-thin">
                <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                    <?php _e( 'CSS Classes (optional)' ); ?><br />
                    <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                </label>
            </p>
            <p class="field-xfn description description-thin">
                <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                    <?php _e( 'Link Relationship (XFN)' ); ?><br />
                    <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                </label>
            </p>
            <p class="field-description description description-wide">
                <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                    <?php _e( 'Description' ); ?><br />
                    <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
                    <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
                </label>
            </p>
            <?php
            /*
             * This is the added field
             */
            ?>
            <p class="field-custom description description-wide">
                <label for="edit-menu-item-custom-<?php echo $item_id; ?>">
                    <?php _e( 'Icon' ); ?><br />
                    <?php $savedValue = get_post_meta($item_id, '_menu_item_custom'); ?>
                    <select name="menu-item-custom[<?php echo $item_id; ?>]" id="edit-menu-item-custom-<?php echo $item_id; ?>" class="selectpicker widefat code edit-menu-item-custom" style="font-family:'FontAwesome', Arial;">
                      <option value="fa-paper-plane" <?php selected( $savedValue[0], "fa-paper-plane" ); ?> class="fa fa-paper-plane" style="font-family:'FontAwesome', Arial; content:'\f1d8';">&#xf1d8; Paper Plane</option>
                      <option value="fa-pencil" <?php selected( $savedValue[0], "fa-pencil" ); ?> class="fa fa-pencil" style="font-family:'FontAwesome', Arial; content:'\f1d8';">&#xf040; Pencil</option>
                      <option value="fa-facebook-official " <?php selected( $savedValue[0], "fa-facebook-official " ); ?> class="fa fa-facebook-official " style="font-family:'FontAwesome', Arial; content:'\f240';">&#xf230; Facebook</option>
                      <option value="fa-twitter " <?php selected( $savedValue[0], "fa-twitter " ); ?> class="fa fa-twitter " style="font-family:'FontAwesome', Arial; content:'\f099';">&#xf099; Twitter</option>
                      <option value="" <?php selected( $savedValue[0], "" ); ?>>No icon</option>
                    </select>
                </label>
            </p>
            <?php
            /*
             * end added field
             */
            ?>
            <div class="menu-item-actions description-wide submitbox">
                <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
                    <p class="link-to-original">
                        <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                    </p>
                <?php endif; ?>
                <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                echo wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'delete-menu-item',
                            'menu-item' => $item_id,
                        ),
                        remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                    ),
                    'delete-menu_item_' . $item_id
                ); ?>"><?php _e('Remove'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
                    ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
            </div>

            <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
            <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
            <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
            <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
            <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
            <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
        </div><!-- .menu-item-settings-->
        <ul class="menu-item-transport"></ul>
    <?php
    $output .= ob_get_clean();
    }
}

class Menu_With_Icons extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '<span class="sub"><i class="fa ' . $item->custom . '" aria-hidden="true"></i></span>';
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


?>
