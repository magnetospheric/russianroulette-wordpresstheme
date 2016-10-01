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

		<?php if ( !is_author() ) :
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
				<p><?php the_author_meta('description');?></p><?php

				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				if ( is_plugin_active('cimy-user-extra-fields/cimy_uef_init.php') ) {

				//$curauth = get_the_author($user->ID);
				$civvies_image_url = get_cimyFieldValue(get_the_author_ID(), 'USER_CIVVIES_PHOTO');
				$cosplay_image_url = get_cimyFieldValue(get_the_author_ID(), 'USER_COSPLAY_PHOTO');
				$crossplay_image_url = get_cimyFieldValue(get_the_author_ID(), 'USER_CROSSPLAY_PHOTO');
				$fursuit_image_url = get_cimyFieldValue(get_the_author_ID(), 'USER_FURSUIT_PHOTO');
				$lolita_image_url = get_cimyFieldValue(get_the_author_ID(), 'USER_LOLITA_PHOTO');
				//echo cimy_uef_sanitize_content($value);
				?>

				<?php if ( ! empty( $civvies_image_url ) ) : ?>
				<span class="civviesPhoto">
					<p><?php echo get_the_author(); ?>, as seen normally:</p>
					<img src="<?php echo $civvies_image_url; ?>" alt="<?php echo the_author(); ?> in civvies" />
				</span>
				<?php endif; ?>

				<?php if ( ! empty( $cosplay_image_url ) ) : ?>
				<span class="cosplayPhoto">
					<p><?php echo get_the_author(); ?> in cosplay:</p>
					<img src="<?php echo $cosplay_image_url; ?>" alt="<?php echo the_author(); ?> in cosplay" />
				</span>
				<?php endif; ?>

				<?php if ( ! empty( $crossplay_image_url ) ) : ?>
				<span class="crossplayPhoto">
					<p><?php echo get_the_author(); ?> in crossplay:</p>
					<img src="<?php echo $crossplay_image_url; ?>" alt="<?php echo the_author(); ?> in crossplay" />
				</span>
				<?php endif; ?>

				<?php if ( ! empty( $fursuit_image_url ) ) : ?>
				<span class="fursuitPhoto">
					<p><?php echo get_the_author(); ?> in fursuit:</p>
					<img src="<?php echo $fursuit_image_url; ?>" alt="<?php echo the_author(); ?> in fursuit" />
				</span>
				<?php endif; ?>

				<?php if ( ! empty( $fursuit_image_url ) ) : ?>
				<span class="lolitaPhoto">
					<p><?php echo get_the_author(); ?> in lolita costume:</p>
					<img src="<?php echo $lolita_image_url; ?>" alt="<?php echo the_author(); ?> in fursuit" />
				</span>
				<?php endif;

				} // end if cimy user fields active ?>
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
