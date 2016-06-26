<?php
/**
 * @package russianroulette
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?> >
	<div class="entry-content">
	  <div class="featuredImage">
		<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('large');
		} ?>
	  
	  <div class="titles">
	 	<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3><?php //h3 title as permalink ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php russianroulette_posted_on(); //gets posted on date ?>
		</div>
		<!-- .entry-meta -->
		<?php endif; ?>
  		</div><!-- end titles -->
	 
	  </div>
	   
	 
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-author">
		 <?php
				  $curauth = get_the_author_meta('ID');
				  //curauth gets the author details based on get_author_meta('ID') 
				  //which is currently the only thing able to target the 
				  //author nicename, nickname AND user photo without getting
				  //confused between nickname and photo, outside of the loop
				  
				  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				  		if ( is_plugin_active('user-photo/user-photo.php') ) {
 							//do stuff
 							if(userphoto_exists($curauth)) {  
 								userphoto_thumbnail($curauth);
 							}
						}
						else {
				  			echo get_avatar($curauth, 40);
				  		}
				 
				



//$user = get_the_author();
//$curauth = get_the_author($user->ID);
//			  if(userphoto_exists($curauth)){
//				userphoto_the_author_thumbnail();}
//			  else{
//				echo get_avatar(get_the_author_meta('ID'), 60);}
				?>
		 
				
		  <?php //gets author icon ?>
			
			<div class="authorCategoryInfo">
			  	<div class="author"><p>Written by 
				  	<a href="<?php  echo get_author_posts_url( get_the_author_meta( 'ID', $curauth->ID ) );  ?>">
				  		<?php the_author(); //gets author name ?>
				  </a>
				  </p></div>
				<div class="category"><p>in</p>
				<?php 
						$counter = 0;
		  				foreach((get_the_category()) as $category) {
						  //
						  if ($counter >= 1) { echo "<span class=\"and\">&nbsp;&amp;&nbsp;</span>"; }
			  				
						  //echo a link
						  ?>
				  			<a class="category" href="<?php 
							$url = home_url('/');		  
		  		
					  		echo $url . $category->cat_name;
				
							?>"><?php
						  
						  	
						  	//echo category name
						  	echo $category->cat_name;	
						  	
						  
							//close a link
							?>
							</a>  
							<?php
						  	$counter++;
						} 
				  	?>					
			  </div>
		</div>
		</div><!-- end entry author -->
		<!-- .entry-meta -->
		<?php endif; ?>

	  
	 
		<div class="intro">
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
		<?php the_content(); ?>
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
				  $posttype = get_field('posttype', $post->ID);
				  if ( $posttype == 'news' || $posttype == 'longform' ) {
					$meta_text = __( '<p>This ' .get_field('posttype', $post->ID)  .' piece was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.</p>', 'russianroulette' );
				  }
				  else {
				  	$meta_text = __( '<p>This ' .get_field('posttype', $post->ID)  .' was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.</p>', 'russianroulette' );
				  }
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
	  <?php $someVar = $category->cat_name; ?>
	  <?php 
//if someVar matches one of the title elements

//
	  
	  
	  ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->