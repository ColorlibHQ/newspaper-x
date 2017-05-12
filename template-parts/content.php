<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$breadcrumbs_enabled = get_theme_mod( 'newspaper_x_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled && is_single() ) {
	Newspaper_X_Helper::add_breadcrumbs();
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <div class="newspaper-x-image">
			<?php
			$image = '<img class="wp-post-image" alt="" src="' . get_template_directory_uri() . '/assets/images/picture_placeholder.jpg" />';
			if ( has_post_thumbnail() ) {
				$image = is_single() ? get_the_post_thumbnail( get_the_ID(), 'newspaper-x-single-post' ) : get_the_post_thumbnail( get_the_ID(), 'newspaper-x-recent-post-big' );
			}

			$image_obj = array( 'id' => get_the_ID(), 'image' => $image );
			$new_image = apply_filters( 'newspaper_x_widget_image', $image_obj );

			$allowed_tags = array(
				'img'      => array(
					'data-srcset' => true,
					'data-src'    => true,
					'srcset'      => true,
					'sizes'       => true,
					'src'         => true,
					'class'       => true,
					'alt'         => true,
					'width'       => true,
					'height'      => true
				),
				'noscript' => array()
			);

			echo ! is_single() ? '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' : '';

			echo wp_kses( $new_image, $allowed_tags );

			echo ! is_single() ? '</a>' : '';
			?>
        </div>
		<?php
		if ( ! is_single() ) {
			echo '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_trim_words( get_the_title(), 8 ) . '</a></h4>';
		}

		if ( 'post' === get_post_type() ) : ?>
            <div class="newspaper-x-post-meta">
				<?php Newspaper_X_Helper::posted_on(); ?>
            </div><!-- .entry-meta -->
			<?php
		endif; ?>
		<?php
		if ( is_single() ) {
			the_title( '<h2 class="entry-title">', '</h2>' );
		}
		?>
    </header><!-- .entry-header -->

    <div class="entry-content">
		<?php
		if ( is_single() ) {
			the_content();
		} else {
			echo '<p>' . wp_trim_words( wp_kses_post( get_the_content( esc_html__( 'Read More', 'newspaper-x' ) ) ), 35 ) . '</p>';
		}
		?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
		<?php
		if ( is_single() ) {
			// Include author information
			get_template_part( 'template-parts/author-info' );

		}
		?>
    </footer><!-- .entry-footer -->

	<?php if ( is_single() ):do_action( 'newspaper_x_single_after_article' ); endif; ?>

</article><!-- #post-## -->

