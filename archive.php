<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package russianroulette
 */

get_header(); ?>

<section id="primary" class="content-area">
	<main id="main" class="site-main archive single" role="main">

		<?php
		if ( !is_author() ) :
			?> <section class="archive-header">
			<h3>
			<?php
			if ( is_category() ) :
				single_cat_title();

			elseif ( is_tag() ) :
				_e('Archives: ');
				single_tag_title();

			elseif ( is_author() ) :

			elseif ( is_day() ) :
				printf( __( 'Day: %s', 'russianroulette' ), '<span>' . get_the_date() . '</span>' );

			elseif ( is_month() ) :
				printf( __( 'Month: %s', 'russianroulette' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

			elseif ( is_year() ) :
				printf( __( 'Year: %s', 'russianroulette' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

			elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
				_e( 'Asides', 'russianroulette' );

			elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
				_e( 'Images', 'russianroulette');

			elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
				_e( 'Videos', 'russianroulette' );

			elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
				_e( 'Quotes', 'russianroulette' );

			elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
				_e( 'Links', 'russianroulette' );

			else :
				_e( 'Archives', 'russianroulette' );

			endif;
			?>
		</h3>
		<?php
		// Show an optional term description.
		$term_description = term_description();
		if ( ! empty( $term_description ) ) :
			printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
			?>
		</section><!-- .page-header -->

		<?php endif; ?>


		<?php if ( is_author() ) { ?>
			<div class="author-details entry-content">
				<div class="titles">
					<h3 class="entry-title">
						<?php printf( __( 'Author: %s', 'russianroulette' ), '<span class="vcard">' . get_the_author() . '</span>' ); ?>
					</h3>
				</div>
			<?php
				$curauth = get_the_author_meta('ID');

				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active('user-photo/user-photo.php') ) {
							//do stuff
							if(userphoto_exists($curauth)) {
								userphoto_thumbnail($curauth);
						}
						else {
							echo get_avatar($curauth, 60);
						}
					}
					else {
						echo get_avatar($curauth, 60);
					}

				?>

				<h4>Posts by me:</h4>
			</div>
		<?php } ?>


		<?php

		if ( have_posts() ) :
			?><section id="blogroll"><?php

			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content', 'blogroll' );
			endwhile;

			wp_reset_postdata(); ?>

			<div class="pagination">
				<?php rr_pagination($wp_query); ?>
			</div>

			</section>

			<div class="clear"></div>

		<?php else :
			get_template_part( 'content', 'none' );
		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
