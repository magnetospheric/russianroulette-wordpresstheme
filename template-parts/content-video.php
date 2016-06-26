<?php
/**
 * @package russianroulette
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('videos'); ?> >
	<div class="entry-content">
	  
	  <div class="titles">
	 	<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3><?php //h3 title as permalink ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php russianroulette_posted_on(); //gets posted on date ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
  		</div><!-- end titles -->

	  	<div class="videoContent">
			<?php the_content(); ?>
		</div>
	 
		<div class="intro">
		  <?php the_field('introduction', $post->ID) ?>
	  </div>
				<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'russianroulette' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'russianroulette' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'russianroulette' ) );

			if ( ! russianroulette_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'russianroulette' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'russianroulette' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
				  $meta_text = __( '<p>This ' .get_field('posttype', $post->ID)  .' was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.</p>', 'russianroulette' );
				} else {
					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'russianroulette' );
				}

			} // end check for categories on this blog
			printf(
				
				$meta_text,
			  	$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'russianroulette' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->