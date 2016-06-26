<?php
/**
 * @package russianroulette
 */

//THIS IS CONTENT POST TYPE CONTENT-LIST

//There are 4 main content post types:
//Content-page, which determines content layout for static pages
//Content-excerpt, which displays the introduction to a post and an associated image (image will have a conditional so if feature = true, first result = large size image [ see if( $wp_query->current_post == 0 && !is_paged() ) { /*first post*/ } ]
//Content-list, which displays just the title to a post, in list form
//and Content-single, which displays the entire post 

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('list'); ?>>
	<header class="entry-header list">
		<?php
		//if homepage, archive or search, show category / feature box
		if (is_home()) {
		  	?>
	  	<span> 
		<?php  if ( $feature == true ) { 
  		 ?> 
		<span class="feature">Feature</span>
		<?php
		} 
		else { 
		  ?>
		  	
			<?php
		} ?>
	  	</span>
		<?php
		}
		?>
		<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3><?php //h3 title as permalink ?>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php russianroulette_posted_on(); //gets posted on date ?>
		</div>
		<!-- .entry-meta -->
		<?php endif; ?>
	  	
	  
	  <div class="authorCategoryInfo">
			  	<div class="category"><p>Written in: </p>
				<?php 
						$counter = 0;
		  				foreach((get_the_category()) as $category) {
						  //
						  if ($counter >= 1) { echo "<span class=\"and\">,&nbsp;</span>"; }
			  				
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
	  
	  
	  
	</header><!-- .entry-header --> 


	<div class="entry-summary">
		<?php //if homepage, show introduction too ?>
		<div class="text">

		<?php
		//the_field("posttype", $post->ID); 
		//need to create intro field!
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  		if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
					//do stuff
					the_field("introduction", $post->ID);
				}
				else {
					//if no custom field named Introduction, display first 20 words plus ellipsis [...]
					//$newIntroduction = $post->post_content;
					//$firstTwentyWords = substr($newIntroduction, 0, 20)
					the_excerpt();
				}
		//gets introduction ?>
	  </div>
		<?php //read more goes here ?>
		<a class="readmore" href="<?php the_permalink(); ?>" rel="bookmark">Read more</a>
	</div><!-- .entry-summary -->

</article><!-- #post-## -->