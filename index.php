<?php
/**
 * The main template file.
 *
 * @package russianroulette
 */

error_reporting(E_ALL);

get_header();

// common vars
// exclude dispatches, videos, polls and editorial tags
$category_excludes = array(
	get_cat_ID( 'Dispatches'),
	get_cat_ID( 'Videos'),
	get_cat_ID( 'polls')
);
$tag_exclude = get_term_by('slug','editorial', 'post_tag');

?>

<?php
	$paged = get_query_var('paged');

	if ($paged < 2) { // only show carousel on first page
		?><main id="main" class="site-main page1" role="main"><?php
		include(locate_template('template-parts/section-carousel.php'));
	} else {
		?><main id="main" class="site-main" role="main"><?php
	}
?>
		<section id="site-navigation" class="main-navigation" role="navigation">
			<h2 class="menu-toggle"><?php _e( 'Menu', 'russianroulette' ); ?></h2>
			<h3>
				<?php
				if ($paged < 2) { // only show scroll button on first page
					?><span class="scrollDown"><i class="fa fa-angle-double-down" aria-hidden="true"></i></span><?php
				} else {
					?><span class="rr-logo-greyscale"> </span><?php
				}?>
				N<span class="threepixels">a</span>vi<span class="onepixel">ga</span>te to:
			</h3>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</section><!-- #site-navigation -->

		<section id="blogroll">
			<?php
			// The Query

			// First, initialize how many posts to render per page
			$display_count = 16;

			// Next, get the current page
			$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

			// After that, calculate the offset
			$offset = ( ( $page - 1 ) * $display_count ) + 3;

			$args = array(
			  'posts_per_page' => $display_count,
			  'offset' => $offset,
			  'paged'          => $page,
			  'tag__not_in' => array($tag_exclude->term_id),
		  	  'category__not_in' => $category_excludes
			);

			$main_query = new WP_Query( $args );


			// The Loop
			if ( $main_query->have_posts() ) {

				while ( $main_query->have_posts() ) {

					$main_query->the_post();

					include(locate_template('template-parts/content-blogroll.php'));

				}

			} else {
				// no posts found
				echo 'No posts found!';
			}

			/* Restore original Post Data */
			wp_reset_postdata();

			?>

			<div class="pagination">
				<?php rr_pagination($main_query); ?>
			</div>

		</section><!-- end blogroll -->

		<div class="clear"></div>

	</main><!-- #main -->

<?php get_footer(); ?>
