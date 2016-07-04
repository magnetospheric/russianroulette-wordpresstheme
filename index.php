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

	<main id="main" class="site-main" role="main">

		<section id="carousel" class="carousel-init">
			<?php
			// Carousel query
			$carousel_query= new WP_Query( array(
					'posts_per_page' => 3,
					'tag__not_in' => array($tag_exclude->term_id),
				  	'category__not_in' => $category_excludes,
					'post_type' => 'post',
					'post_status' => 'publish'
				)
			);

			if ( $carousel_query->have_posts() ) {
				while ( $carousel_query->have_posts() ) {

					$carousel_query->the_post();

					include( locate_template('template-parts/content-carousel.php') );

				}

			}

			/* Restore original Post Data */
			wp_reset_postdata();

			?>
		</section><!-- end section CAROUSEL -->

		<section id="site-navigation" class="main-navigation" role="navigation">
			<h2 class="menu-toggle"><?php _e( 'Menu', 'russianroulette' ); ?></h2>
			<h3>Navigate to</h3>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</section><!-- #site-navigation -->

		<section class="blogroll">
			<?php
			// The Query
			$main_query = new WP_Query(array(
  				'tag__not_in' => array($tag_exclude->term_id),
			  	'category__not_in' => $category_excludes,
				'post_type' => 'post',
				'post_status' => 'publish',
			  	'paged' => $paged,
				'offset' => 3
			) );

			// The Loop
			if ( $main_query->have_posts() ) {

				while ( $main_query->have_posts() ) {

					$main_query->the_post();

					include(locate_template('template-parts/content-excerpt.php'));

				}

			} else {
				// no posts found
				echo 'No posts found!';
			}

			/* Restore original Post Data */
			wp_reset_postdata();

			?>

			<div class="pagination">
				<?php my_pagination(); ?>
			</div>

		</section><!-- end blogroll -->

	</main><!-- #main -->

<?php get_footer(); ?>
