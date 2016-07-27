<?php
/**
 * @package russianroulette
 */

// THIS IS CONTENT POST TYPE CONTENT-BLOGROLL

?>

<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' ); ?>

<article style="" id="post-<?php the_ID(); ?>" <?php post_class('excerpt'); ?> >
		<span class="images" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/blogroll-filter.png'), url('<?php echo $thumb[0]; ?>'); background-size:cover; background-position: 50% 0%;"></span>

		 <?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('small');
		} ?>

		<div class="titles">
			<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php russianroulette_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</div><!-- end titles -->

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
	<span class="link"><a href="<?php the_permalink(); ?>" rel="bookmark"></a></span>
</article><!-- #post-## -->
