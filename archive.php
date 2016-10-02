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
				<div class="text page">
					<?php
						$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
						$author_id = $author->ID;
						// avatar goes here
						$avatar = get_field('author_photo', 'user_' . $author_id );
						echo '<div class="author-photo">';
						echo '<img src="';
						echo $avatar['url'];
						echo '" />';
						echo '</div>';
						// bio goes here
						$bio = get_field('extended_bio', 'user_' . $author_id );
						echo '<div class="bio">';
						echo $bio;
						echo '</div>';
 					?>
				</div>

				<div class="extras">
					<div class="extra-photos">
						<?php
						if( have_rows('extra_author_photos', 'user_' . $author_id) ):
							while ( have_rows('extra_author_photos', 'user_' . $author_id) ) : the_row();
								if( get_row_layout() == 'custom_author_photo' ):
									echo '<div class="author-extra-photo">';
									echo '<h4>' . get_sub_field('tagline', 'user_' . $author_id) . '</h4>';
									echo '<img src="';
									$photo = get_sub_field('photo', 'user_' . $author_id);
									echo $photo['url'];
									echo '" />';
									echo '</div>';
								endif;
							endwhile;
							else :
						endif;
						?>

					</div>

					<div class="social-links">
						<?php
						if( have_rows('social_media_links', 'user_' . $author_id) ):
							echo '<h3>Other places you can find me:</h3>';
							echo '<ul>';
							while ( have_rows('social_media_links', 'user_' . $author_id) ) : the_row();
								if( get_row_layout() == 'new_link' ):
									echo '<li>';
									echo get_sub_field('title', 'user_' . $author_id) . ' ';
									echo '<a href="';
									echo get_sub_field('link', 'user_' . $author_id);
									echo '">';
									echo get_sub_field('link', 'user_' . $author_id);
									echo '</a>';
									echo '</li>';
								endif;
							endwhile;
							else :
							// no layouts found
						echo '</ul>';
						endif;
						?>
					</div>
				</div>

				<section class="posts">
					<h3>Posts by me:</h3>
				</section>
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
