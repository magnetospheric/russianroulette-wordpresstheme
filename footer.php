<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package russianroulette
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="footer-logo"></div>
		<nav id="site-navigation" class="footer-navigation" role="navigation">
			<h1 class="menu-toggle"><?php _e( 'Menu', 'russianroulette' ); ?></h1>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'russianroulette' ); ?></a>
			<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>

			<a href="https://twitter.com/revolutiongeeks" class="twitter-follow-button" data-show-count="true" show-screen-name="false" data-lang="en">Follow</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			<div class="fb-like" data-href="https://www.facebook.com/RevolutionGeeks" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>

		</nav><!-- #site-navigation -->

		<div class="site-info">
			<p class="left">&copy; Renegade Revolution, 2013</p>
			<p class="right"><?php do_action( 'russianroulette_credits' ); ?>
			<a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'russianroulette' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'russianroulette' ), 'russianroulette', '<a href="http://www.rambutanweb.com" rel="designer">rambutanweb</a>' ); ?>
			</p>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>


<script>
/* ========================
	Google Analytics script
   ======================== */

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-46851565-1', 'renegade-revolution.com');
	ga('send', 'pageview');

</script>


<script>
/* ==========================
	Google Analytics script 2
   ========================== */

	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-47872080-1', 'renegade-revolution.com');
	ga('send', 'pageview');

</script>

</body>
</html>
