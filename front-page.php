<?php
/**
 * The template for displaying Front page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newsmag
 */

get_header();
$show_on_front = get_option( 'show_on_front' );
if ( $show_on_front == 'posts' ):

else:
	?>
	<div class="row">
		<div class="col-md-12">
			<!-- Recent Posts Module -->
			<?php get_template_part( 'template-parts/recent-posts' ) ?>
		</div>
	</div>

	<div class="row">
		<?php if ( is_active_sidebar( 'content-area' ) ) { ?>
			<div class="<?php echo is_active_sidebar( 'sidebar' ) ? 'col-md-8' : 'col-md-12' ?> newspaper-x-content">
				<?php dynamic_sidebar( 'content-area' ); ?>
			</div>
		<?php } ?>

		<?php if ( is_active_sidebar( 'sidebar' ) ) { ?>
			<div class="col-md-4 hidden-xs newspaper-x-blog-sidebar">
				<?php dynamic_sidebar( 'sidebar' ); ?>
			</div>
		<?php } ?>
	</div>

	<section class="newspaper-x-after-content-area">
		<div class="row">
			<div class="col-xs-12 newspaper-x-after-content-sidebar">
				<?php
				if ( is_active_sidebar( 'after-content-area' ) ) {
					dynamic_sidebar( 'after-content-area' );
				}
				?>
			</div>
		</div><!--/.row-->
	</section>
<?php endif; ?>

<?php get_footer();