<?php
/**
 * The footer widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bugle
 */

/**
 * The defined sidebars
 */
$mysidebars = array(
	'footer-sidebar-1',
	'footer-sidebar-2',
	'footer-sidebar-3',
	'footer-sidebar-4'
);

/**
 * We create an empty array that will keep which one of them has any active sidebars
 */
$sidebars = array();
foreach ( $mysidebars as $column ) {
	if ( is_active_sidebar( $column ) ) {
		$sidebars[] = $column;
	}
};

/**
 * If the array is empty, terminate here
 */
if ( empty( $sidebars ) ) {
	return false;
}

/**
 * Handle the sizing of the footer columns based on the user selection
 */
$count = (int) get_theme_mod( 'bugle_footer_columns', 3 );
/**
 * Size can be set dynamically as well by counting the array elements
 * $size = 12 / count($sidebars);
 */
$size = 12 / $count;
/**
 * In case all the sidebars have widgets attached, we slice the array it.
 */
$sidebars = array_slice( $sidebars, 0, $count );
?>
<div class="widgets-area">
	<div class="container">
		<div class="row">
			<?php foreach ( $sidebars as $sidebar ): ?>
				<div class="col-md-<?php echo $size ?> col-sm-6">
					<?php dynamic_sidebar( $sidebar ); ?>
				</div>
			<?php endforeach; ?>
		</div><!--.row-->
	</div>
</div>