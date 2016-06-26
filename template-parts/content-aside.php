<?php
/**
 * @package russianroulette
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('aside'); ?> >
	<div class="entry-content">
	  <div class="featuredImage">
		<?php // check if the post has a Post Thumbnail assigned to it.
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('large');
		} ?>
	  
	  <div class="titles">
	 	
		<?php if ( has_tag ( 'editorial' ) ) { ?>
		
		<h3 class="entry-title">Editor's Note</h3><?php //h3 title as permalink ?>
		<?php } 

		else { ?>
		  
		<h3 class="entry-title"><?php the_title(); ?></h3><?php //h3 title as permalink ?>
		
		<?php } ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
		  	<div class="posted-on">
				<?php the_time('F Y'); //gets posted on date ?>
			</div>
		</div>
		<!-- .entry-meta -->
		<?php endif; ?>
  		</div><!-- end titles -->
	 
	  </div>
	   
	
	  	<?php the_content(); ?>
	
	  
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-author">
		  <?php if (function_exists('userphoto_the_author_thumbnail')) {  userphoto_the_author_thumbnail();} //gets author icon ?>
		  <div class="author"><p>From your </p>
			<a class="category" href="<?php 
		  $url = home_url('/');		  
		  		foreach((get_the_category()) as $category) {
			  		echo $url . $category->cat_name;
				} 
				?>"><?php foreach((get_the_category()) as $category) {
			  	echo $category->cat_name;
			} ?></a>
			<p>editor,</p>
									<p class="author-name"><?php the_author(); //gets author name ?></p></div>
		</div><!-- end entry author -->
		<!-- .entry-meta -->
		<?php endif; ?>

	 
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'russianroulette' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php


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