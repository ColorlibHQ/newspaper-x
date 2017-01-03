<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspaper X
 */

?>
</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">

	<?php get_sidebar( 'footer' ) ?>

	<?php $go_top = get_theme_mod( 'newspaper_x_enable_go_top', true ); ?>
	<?php if ( $go_top ): ?>
		<div class="back-to-top-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<a href="javascript:void(0)" id="back-to-top">
							<?php echo esc_html__( 'Go Up', 'newspaper-x' ) ?>
							<i class="fa fa-angle-up" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php $go_top = get_theme_mod( 'newspaper_x_enable_copyright', true ); ?>
	<?php if ( $go_top ): ?>
		<div class="site-info ">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<?php
						$default = sprintf( __( '&copy; %s <a href="%s">Newspaper X. All rights reserved.</a>', 'newspaper-x' ), date( "Y" ), 'http://machothemes.com' );

						$copyright = get_theme_mod( 'newspaper_x_copyright_contents' );
						echo empty( $copyright ) ? wp_kses_post( $default ) : wp_kses_post( $copyright );
						?>
					</div>
				</div>
			</div>
		</div><!-- .site-info -->
	<?php endif; ?>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
