<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package russianroulette
 */

get_header(); ?>

	<main id="main" class="site-main" role="main">

		<section id="blogroll">
		<?php

		if ( have_posts() ) : ?>

			<section class="archive-header">
				<h3><?php printf( __( 'Search Results for: %s', 'russianroulette' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
			</section><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'blogroll' ); ?>

			<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'content', 'none' ); ?>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

			<div class="pagination">
				<?php rr_pagination($main_query); ?>
			</div>

		</section><!-- end blogroll -->

		<div class="clear"></div>

	</main><!-- #main -->

<?php get_footer(); ?>
