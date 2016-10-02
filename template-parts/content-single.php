<?php
/**
 * @package russianroulette
 */
?>

<article id="post-<?php the_ID(); ?>" <?php if ( 'post' == get_post_type($post) ) { post_class('single'); } ?>>
	<div class="entry-content">
		<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) { ?>
		<div class="featuredImage">
			<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'x-large' );
			$url = $thumb['0']; ?>
			<img src="<?php echo $url; ?>" longdesc="URL_2" alt="Text_2" />

		  	<div class="titles">
			 	<h3 class="entry-title"><?php the_title(); ?></h3>
				<?php if ( 'post' == get_post_type($post) ) : ?>
					<div class="entry-meta">
						<?php russianroulette_posted_on(); //gets posted on date ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
	  		</div><!-- end titles -->

			<span class="overlay-gradient"></span>

		</div><!-- end post thumbnail -->

		<?php } else { ?>

		<div class="titles">
		 	<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3><?php //h3 title as permalink ?>

			<?php if ( get_post_type() != 'page' ) : ?>
				<div class="entry-meta">
					<?php russianroulette_posted_on(); //gets posted on date ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
  		</div><!-- end titles -->

	<?php } ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-author">
			<?php
				$author_id = $post->post_author;
				// avatar goes here
				$avatar = get_field('author_photo', 'user_' . $author_id );
				echo '<div class="author-photo article">';
				echo '<img src="';
				echo $avatar['url'];
				echo '" />';
				echo '</div>';
			?>

			<div class="authorCategoryInfo">
				<div class="author"><p>Written by
					<a href="<?php  echo get_author_posts_url( get_the_author_meta( 'ID', $curauth->ID ) );  ?>">
						<?php the_author(); //gets author name ?>
					</a>
				</p>
			</div>
			<div class="category"><p>in</p>
				<?php
					$counter = 0;
	  				foreach((get_the_category()) as $category) {
						if ($counter >= 1) { echo "<span class=\"and\">&nbsp;&amp;&nbsp;</span>"; }
						$url = home_url('/');
						$cat_name = $category->name;
						$cat_name_with_hyphens = str_replace(" ", "-", strtolower($cat_name));
							echo '<a class="category" href="';
							echo $url . $cat_name_with_hyphens;
							echo '">';
							echo $cat_name;
							echo '</a>';
						$counter++;
					}
				?>
			</div>
		</div>
		</div><!-- end entry author -->
		<!-- .entry-meta -->
		<?php endif; ?>



		<div class="intro page">
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
	  </div>
	  <div class="text page">
		<?php
			$content = apply_filters('the_content', $post->post_content);
			echo $content;
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'russianroulette' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	</div><!-- .entry-content -->

	<?php if ( get_post_type() != 'page' ) : ?>
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
					if ( '' != $tag_list ) {
						$posttype = get_field('posttype', $post->ID);
						$meta_text = __( '<p class="cat">This ' .get_field('posttype', $post->ID)  .' article was posted in %1$s</p><h3>Tags:</h3><p>%2$s</p>', 'russianroulette' );
					} else {
						$meta_text = __( '<p>This article was posted in %1$s</p>', 'russianroulette' );
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
			<?php $someVar = $category->cat_name; ?>

		</footer><!-- .entry-meta -->
	<?php endif; ?>

</article><!-- #post-## -->
