<?php
/**
 * The Template for displaying all single posts.
 *
 * @package russianroulette
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

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
				  ?>
					
					<div class="relatedthumb">
						<a rel="external" href="<? the_permalink()?>"><?php the_post_thumbnail(array(150,300)); ?><br />
							<span class="relatedTitle"><?php the_title(); ?></span>
						</a>
					</div>
					
				  <?php 
				  endwhile;
				  
				}
				$post = $orig_post;
				wp_reset_query();
				?>
			</div>
					
	
		<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>