<?php
/**
 * The template used for displaying page content for article types
 *
 * @package russianroulette
 */
?>


<section id="primary" class="content-area">
	<main id="main" class="site-main archive single" role="main">

        <section class="archive-header">
            <h3><?php the_title(); ?></h3>
        </section><!-- .page-header -->

        <?php
            $display_count = 16;
            $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

            $type_args = array(
                'posts_per_page' => $display_count,
                'paged' => $page,
                'meta_key'		=> 'posttype',
	            'meta_value'	=> $posttype
            );

            $type_query = new WP_Query( $type_args );

            if( $type_query->have_posts() ):
			    echo '<section id="blogroll">';

    			while( $type_query->have_posts() ) : $type_query->the_post();
    				get_template_part( 'template-parts/content', 'blogroll' );
    			endwhile;

                wp_reset_postdata(); ?>

    			<div class="pagination">
    				<?php rr_pagination($type_query); ?>
    			</div>
                <?php
    		    echo '</section>';

    			echo '<div class="clear"></div>';

    		else :
    			get_template_part( 'content', 'none' );
    		endif; ?>

    </main><!-- #main -->
</section>
