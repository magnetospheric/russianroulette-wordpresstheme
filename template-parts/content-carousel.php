<?php
/**
 * @package russianroulette
 */

// THIS IS CONTENT POST TYPE CONTENT-CAROUSEL
// For use on index page

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('carousel'); ?> onclick="window.open('<?php the_permalink(); ?>','_self');">


	<div class="featuredImage">


		<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('x-large');
		} ?>

		<span class="overlay-gradient"></span>

		<div class="titles">

			<h3 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h3><!-- end entry-title -->

			<div class="entry-meta">
				<span class="author">by <?php the_author(); //gets author name ?></span>
				<span class="divider"><i class="fa fa-cog" aria-hidden="true"></i></span>
				<span class="date"><?php russianroulette_posted_on(); //gets posted on date ?></span>
			</div><!-- end entry-meta -->

		</div><!-- end titles -->

	</div>


	<div class="text hidden">

		<?php // intro field
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	  		if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
				the_field("introduction", $post->ID);
			}
			else {
				the_excerpt();
			}
		?>
	</div>


</article><!-- #post-## -->
