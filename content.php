<?php
/**
 * @package russianroulette
 */

//There are 5 main content post types:
//Content-page, which determines content layout for static pages
//Content-excerpt, which displays the introduction to a post and an associated image (image will have a conditional so if feature = true, first result = large size image [ see if( $wp_query->current_post == 0 && !is_paged() ) { /*first post*/ } ]
//Content-medium, which displays the intro  and associated full image
//Content-list, which displays just the title to a post, in list form
//and Content-single, which displays the entire post 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php russianroulette_posted_on(); ?>//gets posted on date
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_page() || is_home() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
	<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('thumb');
		} ?>
		
		<?php 
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  		if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
					//do stuff
					the_field("introduction", $post->ID);
				}
				else {
					$values = get_post_custom( $post->ID );
			    	$intro_text = isset( $values['introduction_text'] ) ? esc_attr( $values['introduction_text'][0] ) : '';

			    	echo '<p>' . $intro_text . '</p>';
				}
		?>

		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<?php else : ?>
	
	<div class="entry-content">
	<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('large');
		} ?>
		<?php 
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  		if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
					//do stuff
					the_field("introduction", $post->ID);
				}
				else {
					$values = get_post_custom( $post->ID );
			    	$intro_text = isset( $values['introduction_text'] ) ? esc_attr( $values['introduction_text'][0] ) : '';

			    	echo '<p>' . $intro_text . '</p>';
				}
		?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'russianroulette' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'russianroulette' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'russianroulette' ) );
				if ( $categories_list && russianroulette_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'russianroulette' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'russianroulette' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'russianroulette' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'russianroulette' ), __( '1 Comment', 'russianroulette' ), __( '% Comments', 'russianroulette' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'russianroulette' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->