<?php
/**
 * @package russianroulette
 */

// TEMPLATE PART FOR TOP CAROUSEL

?>
<section id="carousel" class="carousel-init">
    <?php
    // Carousel query
    $carousel_query= new WP_Query( array(
            'posts_per_page' => 3,
            'tag__not_in' => array($tag_exclude->term_id),
            'category__not_in' => $category_excludes,
            'post_type' => 'post',
            'post_status' => 'publish'
        )
    );

    if ( $carousel_query->have_posts() ) {
        while ( $carousel_query->have_posts() ) {

            $carousel_query->the_post();

            include( locate_template('template-parts/content-carousel.php') );

        }

    }

    /* Restore original Post Data */
    wp_reset_postdata();

    ?>
</section><!-- end section CAROUSEL -->
