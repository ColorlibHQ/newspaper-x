<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */


if ( is_single() ) {
	/**
	 * Enable breadcrumbs
	 */
	$breadcrumbs_enabled = get_theme_mod( 'newspaperx_enable_post_breadcrumbs', 'breadcrumbs_enabled' );
	if ( $breadcrumbs_enabled == 'breadcrumbs_enabled' ) {
		newspaperx_breadcrumbs();
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		}
		?>
		<div class="newspaperx-image">
			<?php
			if ( has_post_thumbnail() ) {
				echo ! is_single() ? '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' : '';

				is_single() ? the_post_thumbnail( 'newspaperx-single-post' ) : the_post_thumbnail( 'newspaperx-recent-post-big' );

				echo ! is_single() ? '</a>' : '';
			} else {
				echo ! is_single() ? '<img src=' . get_template_directory_uri() . '/images/picture_placeholder.jpg' .
				                     " />" : '';
			}
			?>
		</div>
		<?php
		if ( !is_single() ) {
			echo '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_trim_words( get_the_title(), 8 ) . '</a></h4>';
		}
		if ( 'post' === get_post_type() ) : ?>
			<div class="newspaperx-post-meta">
				<?php newspaperx_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		if ( is_single() ) {
			the_content();

			wp_link_pages( array(
				               'before' => '<ul class="newspaperx-pager">',
				               'after'  => '</ul>',
			               ) );

			$prev = get_previous_post_link();
			$prev = str_replace('&laquo;', '<span class="fa fa-caret-left"></span>', $prev);
			$next = get_next_post_link();
			$next = str_replace('&raquo;', '<span class="fa fa-caret-right"></span>', $next);
			?>
			<div class="newspaperx-next-prev row">
				<div class="col-md-6 text-left">
				<?php echo $prev ?>
				</div>
				<div class="col-md-6 text-right">
				<?php echo $next ?>
				</div>
			</div>
			<?php
		} else {
			echo '<p>' . wp_trim_words( get_the_content( __( 'Read More', 'newspaper-x' ) ), 35 ) . '</p>';
		}

		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		if ( is_single() ) {
			// Include author information
			get_template_part( 'template-parts/author-info' );
			// Include the related posts
			do_action( 'newspaperx_single_after_article' );
		}
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
