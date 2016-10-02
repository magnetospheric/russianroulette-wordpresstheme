<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package russianroulette
 */

get_header(); ?>

	<div id="primary" class="content-area page">
		<main id="main" class="site-main single" role="main">

		<?php // generate templates for article types

			$field = get_field_object('field_52b75069a90e6');
			$posttypes = $field['choices'];

			$site_url = site_url();
			$uri_array = explode("/", $_SERVER['REQUEST_URI']);
			$next = false;
			$is_posttype_page = false;
			foreach ($uri_array as $value) {
				if ( $next == true ) {
					$current_keyword = $value;
					// check if post type match
					foreach ( $posttypes as $posttype ) {
						if ( strtolower($posttype) === strtolower($current_keyword) ) {
							include(locate_template('template-parts/page-articletype.php'));
							$is_posttype_page = true;
						}
					}
					break;
				}
				if (strpos($site_url, $value) !== false) {
					$next = true;
				}
			}
			echo $is_posttype_page;
			if ( $is_posttype_page == false ) {
				include(locate_template('template-parts/content-single.php' ));
			}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
