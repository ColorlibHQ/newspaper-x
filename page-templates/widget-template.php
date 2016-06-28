<?php /* Template Name: Widget Template */ ?>

<?php get_header(); ?>
<div class="col-md-12">

	<!-- Recent Posts Module -->
	<?php get_template_part( 'template-parts/recent-posts' ) ?>

	<!-- Before content area -->
	<?php if ( is_active_sidebar( 'before-content-area' ) ) { ?>
		<section class="before-content-area">
			<div class="row">
				<div class="col-xs-12">
					<?php
					dynamic_sidebar( 'before-content-area' );
					?>
				</div><!--/.col-xs-12-->
			</div>
		</section>
	<?php } ?>

	<!-- Actual homepage content, contains sidebar -->
	<section class="bugle-content-area">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 bugle-content">
				<?php
				if ( is_active_sidebar( 'content-area' ) ) {
					dynamic_sidebar( 'content-area' );
				}
				?>
			</div><!--/.col-lg-8-->

			<aside class="col-lg-4 col-md-4 col-sm-4 bugle-sidebar hidden-sm hidden-xs">
				<div class="bugle-blog-sidebar">
					<?php
					if ( is_active_sidebar( 'blog-sidebar' ) ) {
						dynamic_sidebar( 'blog-sidebar' );
					} else {
						the_widget( 'WP_Widget_Search', sprintf( 'title=%s', __( 'Search', 'bugle' ) ) );
					}
					?>
				</div> <!--/.bugle-blog-sidebar-->
			</aside><!--/.col-lg-4-->
		</div><!--/.row-->
	</section><!--/section-->

	<section class="bugle-after-content-area">
		<div class="row">
			<div class="col-xs-12 bugle-after-content-sidebar">
				<?php
				if ( is_active_sidebar( 'after-content-sidebar' ) ) {
					dynamic_sidebar( 'after-content-sidebar' );
				}
				?>
			</div>
		</div><!--/.row-->
	</section>

</div><!--/.container-->
<?php get_footer(); ?>
