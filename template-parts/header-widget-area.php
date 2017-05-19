<?php
/**
 * Template part for displaying the header area
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */
?>
<?php if ( is_active_sidebar( 'header-widget-area' ) ): ?>
    <div class="newspaper-x-header-widget-area">
		<?php dynamic_sidebar( 'header-widget-area' ); ?>
    </div>
<?php endif; ?>