<?php
/**
 * Template part for displaying the news ticker
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$cats = get_theme_mod( 'newspaperx_recent_posts_category', array( '1' ) );
$args = array(
	'numberposts' => 10,
	'orderby'     => 'date',
	'order'       => 'DESC',
	'post_type'   => 'post',
	'post_status' => 'publish',
);

$recent_posts = wp_get_recent_posts( $args, OBJECT );
wp_reset_postdata();
if ( ! $recent_posts ) {
	return false;
}
?>
<!-- News Ticker Module -->
<div class="newspaperx-news-ticker">
	<span class="newspaperx-module-title"><?php echo __( 'Latest News', 'newspaper-x' ) ?></span>
	<ul class="newspaperx-news-carousel owl-carousel owl-theme">
		<?php foreach ( $recent_posts as $post ) { ?>
			<li class="item">
				<a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo $post->post_title ?></a>
			</li>
		<?php } ?>
	</ul>
</div>

