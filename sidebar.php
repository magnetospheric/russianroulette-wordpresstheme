<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package russianroulette
 */
?>
<div id="secondary" class="widget-area" role="complementary">
<?php do_action( 'before_sidebar' ); ?>
<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

<!-- if on homepage, display recent posts with excerpts and pictures -->
		
<aside id="recent-posts" class="widget widget_recent"> 	  
	<?php
	//loop for homepage recent posts
	if (is_home()) { ?>
	  		  
	<?php } //end if is home
	elseif ( is_page( 'events-and-culture')) {
		//if events plugin exists
		if ( is_plugin_active('event-list/event-list.php') ) { ?>
			<div class="eventsSidebar">
				<h4>Upcoming Events:</h4>
				<?php
					echo do_shortcode('[event-list num_events=3 show_filterbar=false]');
				?>
	  			<a href="<?php echo get_page_link(295); ?>">View all upcoming events</a>
	  		</div>
	  	<?php 
		}
	} //end if is events page
	elseif (is_page()) {
		if ( !is_page('about-us' ) && !is_page('contact-us')) {
			//this adds the editorial into the sidebar
			$my_query_args = array(
			  	'posts_per_page' => 1, // change this to any number or '0' for all
				'tag'=>'editorial',
    			'tax_query' => array(
     			   array(
          			  	'taxonomy' => 'category',
           			 	'field' => 'slug',
            			'terms' => $post->post_name // this gets the page slug
        			)
    			)
			);			  
			// The Query
			$the_query2 = new WP_Query( $my_query_args );
			//category_name=cosplay&posts_per_page=3
			// The Loop
			if ( $the_query2->have_posts() ) {
		        echo '<ul class="featured">';
				$post_counter = 0;
				while ( $the_query2->have_posts() ) {
					$the_query2->the_post();
					$post_counter++;
					//should call content-excerpt here
					get_template_part( 'content-aside', get_post_format() );
				} // end while		  
			} //end query have posts
		}//end if not page about us
		else {
		// no posts found
		} //end else
		wp_reset_query();
	}//end if page
	else {
	} //end else
?>
<div class="filters">		  
	<?php
	 	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) :
		endif;
  	?>
</div> 		    
	
</aside>

<aside id="postTypeFilter">	
	<h4>Filter by post type</h4>
	
	<?php 

	$metakey = 'posttype';
   	$posttypes = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT meta_value 
           FROM $wpdb->postmeta WHERE meta_key = %s ORDER BY meta_value DESC", $metakey) );

   	if ($posttypes) {   
   		//for each meta value associated with posttype, do:
        foreach ( $posttypes as $posttypeSingle ) {
        	if ( $posttypeSingle != 'null' ):		
				// args
				$typeArgs = array(
					'posts_per_page' => -1,
					'post_type' => 'post',
					'meta_key' => 'posttype',
					'meta_value' => $posttypeSingle,
				);

				// get results
				$typeQuery = new WP_Query( $typeArgs );
				$counter = 0;

				// The Loop
				if( $typeQuery->have_posts() ):
					while ( $typeQuery->have_posts() ) : $typeQuery->the_post(); 
						$counter++;
					endwhile;
				endif; 
				?>

				<p>
					<span class="postTypeTitle">
						<a class="post-type" href="<?php $url = home_url('/'); echo $url . $posttypeSingle;	?>">
						<?php
						  	//echo category name
						  	echo $posttypeSingle;	
						  	echo ":"
							//close a link
						?>			
						</a>	
					</span>
					<a class="post-type articleCount" href="<?php $url = home_url('/'); echo $url . $posttypeSingle;	?>">
						<?php echo $counter; ?> articles

					</a>  
				</p>

				<?php wp_reset_query();  // Restore global post data stomped by the_post(). 

			endif;
		}
	} ?>
</aside>

<aside>
<h4>Authors</h4>
		  
<h5>Editors</h5>
	<?php
		// prepare arguments
		$args  = array(
			// search only for Authors role
			'role' => 'Administrator', 'Editor',
			// order results by display_name
			'orderby' => 'display_name');
		// Create the WP_User_Query object
		$wp_user_query = new WP_User_Query($args);
	
		// Get the results
		$author_ids = $wp_user_query->get_results();
			foreach($author_ids as $author) :
			$curauth = get_userdata($author->ID);
			if($curauth->user_login !== 'admin') :
			$user_link = get_author_posts_url($curauth->ID);
			$avatar = 'default';
			?>
			<div class="author" title="<?php echo $curauth->display_name; ?>">
				<a href="
					<?php  echo get_author_posts_url( get_the_author_meta( 'ID', $curauth->ID ) );  ?>
				">
				  	<?php //if(userphoto_exists($curauth)) {
				  		//userphoto_thumbnail($curauth);
				  		//}
				  		//else {
				  		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				  		if ( is_plugin_active('user-photo/user-photo.php') ) {
 							//do stuff
							if(userphoto_exists($curauth)) {
 								userphoto_thumbnail($curauth);
							}
						  	else {
				  				echo get_avatar($curauth->ID, 40);
				  			}
						}
						else {
				  			echo get_avatar($curauth->ID, 40);
				  		}
				  		//} ?>
					<p class="name"><?php echo $curauth->display_name; //gets author name ?></p>
					<p><?php the_author_meta( 'shortbio', $curauth->ID ); ?></p>
			  	</a>
			</div>	
			<?php endif; ?>
			<?php endforeach; ?> 

<h5>Contributors</h5>
	<?php
		// prepare arguments
		$args  = array(
			// search only for Authors role
			'role' => 'Contributor',
		    // order results by display_name //deprecated
		    //'orderby' => 'display_name');  //deprecated
		    // order results by POST COUNT
			'orderby' => 'post_count',
			'order' => 'DESC');
		// Create the WP_User_Query object
		$wp_user_query = new WP_User_Query($args);

		// Get the results

		$author_ids = $wp_user_query->get_results();
			foreach($author_ids as $author) :
			$curauth = get_userdata($author->ID);
			if($curauth->user_login !== 'admin') :
			$user_link = get_author_posts_url($curauth->ID);
			$avatar = 'default';

			$user_post_count = count_user_posts( $curauth->ID );
			if ($user_post_count >= 1) { ?>
			<div class="author" title="<?php echo $curauth->display_name; ?>">
				<a href="
					<?php  echo get_author_posts_url( get_the_author_meta( 'ID', $curauth->ID ) );  ?>
				">
			  		<?php 
			  			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				  		if ( is_plugin_active('user-photo/user-photo.php') ) {
 							//do stuff
 							userphoto_thumbnail($curauth);
						}
						else {
				  			echo get_avatar($curauth->ID, 40); 
				  		}
			  		?>
			  		<p class="name"><?php echo $curauth->display_name; //gets author name ?></p>
					<p><?php the_author_meta( 'shortbio', $curauth->ID ); ?></p>
			 		</a>
			</div>	
			<?php } ?>
			<?php endif; ?>
			<?php endforeach; ?> 
</aside>

<aside id="social">	
	<h4>Join the conversation</h4> 
	<a class="twitter-timeline" href="https://twitter.com/RevolutionGeeks" data-widget-id="409395315926519808" data-tweet-limit="3">Tweets by @RevolutionGeeks</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id))
		{js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
	</script>

	<div class="facebook-social">
		<h4>Facebook</h4>	
		<div class="fb-like" data-href="https://www.facebook.com/RevolutionGeeks" data-layout="button_count" data-action="like" data-show-faces="true" 

data-share="false"></div>
		<p><a href="https://www.facebook.com/RevolutionGeeks">Subscribe to our updates on Facebook</a></p>
	</div>  
</aside>
	  
<?php endif; // end sidebar widget area ?>
</div><!-- #secondary -->








