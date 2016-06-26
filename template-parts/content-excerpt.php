<?php
/**
 * @package russianroulette
 */

// THIS IS CONTENT POST TYPE CONTENT-EXCERPT

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('excerpt'); ?> >

	<div class="entry-summary excerpt">

	q<div class="featuredImage">
		 <?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('small');
		} ?>

		<div class="titles">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3><?php //h3 title as permalink ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php russianroulette_posted_on(); //gets posted on date ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		</div><!-- end titles -->

	</div><!-- end featured image -->

	<div class="text hidden">
		<?php
		// intro field
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
			the_field("introduction", $post->ID);
		}
		else {
			the_excerpt();
		}
		?>
	</div><!-- end text -->

	</div><!-- .entry-summary -->

</article><!-- #post-## -->
