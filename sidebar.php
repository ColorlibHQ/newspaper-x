<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Newspaper X
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-lg-4 col-md-4 col-sm-4 newspaperx-sidebar hidden-xs" role="complementary">
	<div class="newspaperx-blog-sidebar">
		<?php dynamic_sidebar( 'blog-sidebar' ); ?>
	</div>
</aside><!-- #secondary -->
