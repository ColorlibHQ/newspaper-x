<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bugle
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-lg-4 col-md-4 col-sm-4 bugle-sidebar hidden-xs" role="complementary">
	<div class="bugle-blog-sidebar">
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	</div>
</aside><!-- #secondary -->
