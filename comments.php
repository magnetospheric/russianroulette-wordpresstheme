<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to russianroulette_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package russianroulette
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php
	echo '<h3 class="comments-title">Comments</h3>';

	if ( have_comments() ) :

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'russianroulette' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'russianroulette' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'russianroulette' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif;

		echo '<ol class="comment-list">';
		wp_list_comments( array( 'callback' => 'russianroulette_comment' ) );
		echo '</ol>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?><nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'russianroulette' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'russianroulette' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'russianroulette' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif;

		else:
		echo '<p>No comments yet - be the first!</p>';
	endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'russianroulette' ); ?></p>
	<?php endif;
	$comments_args = array(
		'comment_notes_before'	=> '',
		'comment_notes_after' 	=>	'<p class="comment-notes">' . __( 'We welcome comments whether constructive or critical, positive or negative, opinionated or not. We <strong>do not accept</strong> any comments which include swearing, defamation, or content which is discriminatory. We do not condone harrassment of fellow commenters.' ) . '</p>' .
									'<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'title_reply'			=>	__( 'Leave a Comment' ),
		'cancel_reply_link'		=>	__( 'Cancel' ));

	comment_form($comments_args);


echo '</div>';
