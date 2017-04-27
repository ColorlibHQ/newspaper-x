<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) :
	if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<span>
				<?php echo esc_html__( 'Comments', 'newspaper-x' ) ?>
			</span>
		</h4>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'newspaper-x' ); ?></h2>
				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'newspaper-x' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'newspaper-x' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				                  'style'       => 'ol',
				                  'short_ping'  => true,
				                  'avatar_size' => 64,
			                  ) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'newspaper-x' ); ?></h2>
				<div class="nav-links">

					<div
						class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'newspaper-x' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'newspaper-x' ) ); ?></div>

				</div><!-- .nav-links -->
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().
endif; // Check if comments are open.
?>