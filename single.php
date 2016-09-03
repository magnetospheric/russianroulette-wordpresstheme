<?php
/**
 * The Template for displaying all single posts.
 *
 * @package russianroulette
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main single" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php russianroulette_content_nav( 'nav-below' ); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) {
						comments_template();
				}
			?>

			<div class="relatedposts">
			<h4>Related posts</h4>
			<?php
				$orig_post = $post;
				global $post;
				$tags = wp_get_post_tags($post->ID);

				if ($tags) {
				  $tag_ids = array();
				  foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				  $args=array(
				  'tag__in' => $tag_ids,
				  'post__not_in' => array($post->ID),
				  'posts_per_page'=>4, // Number of related posts to display.
				  'caller_get_posts'=>1
				  );

				  $my_query = new wp_query( $args );



				  while ( $my_query->have_posts() ) : $my_query->the_post();

				  //$relatedThumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );

				  include(locate_template('template-parts/content-blogroll.php'));
				  ?>





				  <?php
				  endwhile;

				}
				$post = $orig_post;
				wp_reset_query();
				?>
			</div>


		<?php endwhile; ?>

		<div class="clear"></div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
