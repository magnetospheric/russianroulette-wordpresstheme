<?php
/**
 * Template Name: About Page
 *
 * @package russianroulette
 */
 get_header(); ?>

<div id="primary" class="content-area about">
	<main id="main" class="site-main single" role="main">

        <?php get_template_part( 'template-parts/content', 'single' ); ?>

        <section class="writers">
            <h3>Authors</h3>
            <?php create_author_list( 'Administrator' ); ?>
            <?php create_author_list( 'Editor' ); ?>
            <?php create_author_list( 'Author' ); ?>
            <?php create_author_list( 'Contributor' ); ?>
            <div class="clear"></div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
