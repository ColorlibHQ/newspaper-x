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
</div>   <!-- .row -->
</div><!-- #content -->

<?php if ( is_active_sidebar( 'before-footer-sidebar-a' ) || is_active_sidebar( 'before-footer-sidebar-b' ) ): ?>
	<section class="newspaperx-before-footer-area">
		<div class="container">
			<div class="row">

				<?php if ( is_active_sidebar( 'before-footer-sidebar-a' ) ) { ?>
				<div class="col-xs-12 col-sm-6 col-md-6 newspaperx-before-footer-sidebar-a">
					<?php
						dynamic_sidebar( 'before-footer-sidebar-a' );
					?>
				</div>
				<?php } ?>

				<?php if ( is_active_sidebar( 'before-footer-sidebar-b' ) ) { ?>
					<div class="col-xs-12 col-sm-6 col-md-6 newspaperx-before-footer-sidebar-b">
						<?php
						dynamic_sidebar( 'before-footer-sidebar-b' );
						?>
					</div>
				<?php } ?>
				
			</div>
		</div><!--/.row-->
	</section>
<?php endif; ?>
<footer id="colophon" class="site-footer" role="contentinfo">

	<?php get_sidebar( 'footer' ) ?>

	<?php if ( get_theme_mod( 'newspaperx_enable_go_top', 'enabled' ) !== 'disabled' ): ?>
		<div class="back-to-top-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<a href="javascript:void(0)" id="back-to-top">
							<?php echo esc_html__( 'BACK TO TOP', 'newspaper-x' ) ?>
							<i class="fa fa-angle-up" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( get_theme_mod( 'newspaperx_enable_copyright', 'enabled' ) !== 'disabled' ): ?>
		<div class="site-info ">
			<div class="container">
				<div class="row text-center">
					<div class="col-md-12">
						<?php
						echo get_theme_mod( 'newspaperx_copyright_contents', '&copy; ' . date( "Y" ) . ' <a href="https://machothemes.com/">Newspaper X. All rights reserved.</a>' );
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
