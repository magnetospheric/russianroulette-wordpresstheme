<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package russianroulette
 */
?>

<section id="sidebar" class="widget-area overlay" role="complementary">

	<div class="overlay-content">
		<div class="overlay-content-inner">

			<aside id="primaryMenu">
				<h4>Categories</h4>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</aside>

			<aside class="authorThumbs">
				<h4>Authors</h4>
				<?php create_author_list( 'Administrator' ); ?>
	            <?php create_author_list( 'Editor' ); ?>
	            <?php create_author_list( 'Author' ); ?>
	            <?php create_author_list( 'Contributor' ); ?>
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
									?>
									</a>
								</span>
							</p>

							<?php wp_reset_query();  // Restore global post data stomped by the_post().
						endif;
					}
				} ?>
			</aside>

			<aside class="popularTags">
				<h4>Popular topics</h4>
				<?php
					$tag_args = array(
						'smallest' => 0.6,
						'largest' => 1.5,
						'unit' => 'em',
						'number' => 25,
						'orderby' => 'name'
					);
					wp_tag_cloud($tag_args);
				?>
			</aside>

			<aside class="social">

			</aside>

		</div>
	</div>
</section>
