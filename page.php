<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package russianroulette
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php

//MAIN LOOP - First three posts

//call first three posts that match category matching page slug
//args
?><h2 class="page_title"><?php
	the_title();
?></h2><?php



if ( is_page('about-us' ) ) {
 	?><div class="content"><?php
	$page_object = get_page( $post->ID );
	echo $page_object->post_content;
  ?>
		  
		  
		  <h4>Editors</h4>
		  <?php
			// prepare arguments
			$args  = array(
				// search only for Authors role
				'role' => 'Administrator', 'Editor',
				// order results by display_name
				'orderby' => 'display_name');

			// Create the WP_User_Query object
			$wp_user_query = new WP_User_Query($args);

			//global $wpdb;
			//$query = "SELECT ID, user_nicename from $wpdb->users WHERE role = administrator ORDER BY user_nicename";
			
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
			  	<?php 

			  	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  		if ( is_plugin_active('user-photo/user-photo.php') ) {
						if(userphoto_exists($curauth)) {
 								userphoto_thumbnail($curauth);
							}
						  	else {
				  				echo get_avatar($curauth->ID, 60);
				  			}
				}
				else {
		  			echo get_avatar($curauth->ID, 60);
		  		}
				?>
				<p class="name"><?php echo $curauth->display_name; //gets author name ?></p>
				<p><?php the_author_meta( 'shortbio', $curauth->ID ); ?></p>
		  	</a>
		</div>	
		  <p><?php the_author_meta('description', $curauth->ID );?></p>
		  
		<?php endif; ?>
		<?php endforeach; ?> 
		  <br />
		  <h4>Contributors</h4>
		  <?php
			// prepare arguments
			$args  = array(
				// search only for Authors role
				'role' => 'Contributor',
				// order results by display_name - DEPRECATED
			    //'orderby' => 'display_name');  - DEPRECATED
			    // order results by POST COUNT
				'orderby' => 'post_count',
				'order' => 'DESC');
  

			// Create the WP_User_Query object
			$wp_user_query = new WP_User_Query($args);

			//global $wpdb;
			//$query = "SELECT ID, user_nicename from $wpdb->users WHERE role = administrator ORDER BY user_nicename";
			
			// Get the results
			$author_ids = $wp_user_query->get_results();
				foreach($author_ids as $author) :
				$curauth = get_userdata($author->ID);
				if($curauth->user_login !== 'admin') :
				$user_link = get_author_posts_url($curauth->ID);
				$avatar = 'default';
	
  				$user_post_count = count_user_posts( $curauth->ID );
  				if ($user_post_count >= 1) {
		?>
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
		  <p><?php the_author_meta('description', $curauth->ID );?></p>

		  <?php } ?>
		  <?php endif; ?>
		<?php endforeach; ?> 
		  
		  
		  
		  
		  
		  
		  
		  
		    
		  
	  </div>
  <?php
  
}
elseif ( is_page('contact-us' ) ) {
 	?><div class="content"><?php
	$page_object = get_page( $post->ID );
	echo apply_filters('the_content', $page_object->post_content);
  //echo $page_object->post_content;
  ?>
	</div>
  <?php
	}

elseif ( is_page('write-for-us' ) ) {
 	?><div class="content"><?php
	$page_object = get_page( $post->ID );
  	echo apply_filters('the_content', $page_object->post_content);
  //echo $page_object->post_content;
  ?>
	</div>
  <?php
	}

elseif ( is_page('videos') ) {
  
$term = get_term_by('slug','dispatches', 'post_tag');
$term2 = get_term_by('slug','editorial', 'post_tag');
		
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

query_posts( array(
    'posts_per_page' => 7, // change this to any number or '0' for all
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $post->post_name, // this gets the page slug
		  	
        )
	  ),
	'tag__not_in' => array($term->term_id, $term2->term_id),	
	'post_type' => 'post',
	'post_status' => 'publish',
  	'paged' => $paged
  )


);

if ( have_posts() ) : ?>
<ul class="featured videos">
<?php while ( have_posts() ) : the_post(); ?>
	<?php // post content goes here ?>
	<?php
		//should call content-excerpt here

//if(1 == $paged) {
    		//true
				//call content-excerpt
				get_template_part( 'content-video', get_post_format() );
//	}
//	else {
			//call content-list
//		get_template_part( 'content-excerpt', get_post_format() );

//	}
	?>		   
<?php endwhile; ?>
</ul>
<div class="pagination">	
	 <?php my_pagination(); ?>
</div>	  
<?php else : ?>
        <?php // no posts found message goes here ?>
		  <p class="empty">No results!</p>
<?php endif; ?>
<?php  wp_reset_query();  ?>
		  <?php 

}

elseif ( is_page ( 'events-list' ) ) {

?>
		  <div class="eventsList">
			<h4>Upcoming geek events:</h4>
		  <?php
  echo do_shortcode('[event-list num_events=200 show_filterbar=false]');  
  
  ?>
		  <p>Know of an event that's not on this list? <a href="mailto:admin@renegade-revolution.com">Let us know</a>!</p>
			
			<?php $permalink = get_permalink($post->post_parent);
			$parent_title = get_the_title($post->post_parent);
			
			?>
			<a href="<?php echo $permalink; ?>">&laquo; Back to <?php echo $parent_title ?></a>
		  </div>
			<?php
}

elseif ( is_page ( 'news' )  ||  is_page ( 'longform') ||  is_page ( 'review') 
	 ||  is_page ( 'report') ||  is_page ( 'interview') ||  is_page ( 'gallery') ) {
$metaVal = get_the_title(); 

$term = get_term_by('slug','dispatches', 'post_tag');
$term2 = get_term_by('slug','editorial', 'post_tag');
		
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// args
$args = array(
	'meta_key' => 'posttype',
	'meta_value' => $metaVal,
	'tag__not_in' => array($term->term_id, $term2->term_id),	
	'post_type' => 'post',
	'post_status' => 'publish',
  	'paged' => $paged,
  	'posts_per_page' => 22,
);

// get results
$the_query = new WP_Query( $args );

if (  $the_query->have_posts() ) : ?>
<ul class="featured">
  <?php $post_counter = 0; ?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
<?php $post_counter++; ?>
	<?php // post content goes here ?>

	<?php

		//should call content-excerpt here

//if(1 == $paged) {
    		//true

			if( $post_counter == 1 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 4 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 7 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 10 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
		  	else{
				//call content-excerpt
				get_template_part( 'content-excerpt', get_post_format() );
			}
//	}
//	else {
  	
			//call content-list
//		get_template_part( 'content-excerpt', get_post_format() );

//	}

	?>
  		   
<?php endwhile; ?>
</ul>
<div class="pagination">	
<?php 
global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $the_query->max_num_pages
		) );
	?>
</div>
		  
<?php else : ?>

        <?php // no posts found message goes here ?>
		  <p class="empty">No results!</p>
	
<?php endif; ?>

<?php  wp_reset_query();  

}

else {

$term = get_term_by('slug','dispatches', 'post_tag');
$term2 = get_term_by('slug','editorial', 'post_tag');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

query_posts( array(
  //'posts_per_page' => 7, // change this to any number or '0' for all
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $post->post_name, // this gets the page slug
		  	
        )
	  ),
	'tag__not_in' => array($term->term_id, $term2->term_id),	
	'post_type' => 'post',
	'post_status' => 'publish',
  	'paged' => $paged
  )


);

if ( have_posts() ) : ?>
<ul class="featured">
  <?php $post_counter = 0; ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $post_counter++; ?>
	<?php // post content goes here ?>

	<?php

		//should call content-excerpt here

//if(1 == $paged) {
    		//true

			if( $post_counter == 1 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 4 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 7 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
  			else if( $post_counter == 10 ) { 
				//call content-medium
				get_template_part( 'content-medium', get_post_format() );		
			}
		  	else{
				//call content-excerpt
				get_template_part( 'content-excerpt', get_post_format() );
			}
//	}
//	else {
  	
			//call content-list
//		get_template_part( 'content-excerpt', get_post_format() );

//	}

	?>
  		   
<?php endwhile; ?>
</ul>
<div class="pagination">	
	 <?php my_pagination(); ?>
</div>
		  
<?php else : ?>

        <?php // no posts found message goes here ?>
		  <p class="empty">No results!</p>
	
<?php endif; ?>

<?php  wp_reset_query();  ?>



		  <?php } ?>

<!--<?php

/*
$my_query_args = array(
    'showposts' => 5, // change this to any number or '0' for all
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $post->post_name, // this gets the page slug
		  	
        )
	  ),
	'tag__not_in' => array($term->term_id, $term2->term_id),	
	'post_type' => 'post',
	'post_status' => 'publish',
  	'paged' => $currentPage
);
// The Query
$the_query = new WP_Query( $my_query_args );
//category_name=cosplay&posts_per_page=3
// The Loop
if ( $the_query->have_posts() ) {
        echo '<ul class="featured">';
	$post_counter = 0;
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$post_counter++;
		//should call content-excerpt here

		if( $post_counter == 1 ) { 
			//call content-medium
			get_template_part( 'content-medium', get_post_format() );		
		}
		else if( $post_counter == 2 || $post_counter == 3 ) { 
			//call content-excerpt
			get_template_part( 'content-excerpt', get_post_format() );
		}
		else {
			//call content-list
			get_template_part( 'content-list', get_post_format() );
		}
	}
  // Reset the post data
  
        echo '</ul>';
		
 my_pagination();
} 

else {
	// no posts found
	echo 'No posts available!';
}

 wp_reset_query(); 
 */


//call rest of posts (offset by 3) that match cosplay category
//SHOULD NOT REQUIRE THIS ONCE THE ABOVE CONDITIONALS ARE OPERATING

//setting $paged
//if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
//elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
//else { $paged = 1; }

/*$args = array(
	'base'         => '%_%',
	'format'       => '?page=%#%',
	'total'        => 1,
	'current'      => 0,
	'show_all'     => False,
	'end_size'     => 1,
	'mid_size'     => 2,
	'prev_next'    => True,
	'prev_text'    => __('« Previous'),
	'next_text'    => __('Next »'),
	'type'         => 'plain',
	'add_args'     => False,
	'add_fragment' => ''
);*/ 
//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// The Query
//$the_query = new WP_Query( 'category_name=cosplay&offset=3&posts_per_page=2&paged=' . $paged );
// The Loop
/*if ( $the_query->have_posts() ) {
        echo '<ul class="paginated_list">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<a href="';
		echo the_permalink();
		echo '">';
		echo 'Linktests!';
		echo '</a>';
	}
        echo '</ul>';
	echo paginate_links($args);

} else {
	// no posts found
}
*/

?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>