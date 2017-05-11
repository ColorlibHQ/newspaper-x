<?php
/**
 * Template part for displaying the news ticker
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$cats = get_theme_mod( 'newspaper_x_frontpage_header_category', array( '1' ) );
$args = array(
	'numberposts' => 10,
	'orderby'     => 'date',
	'order'       => 'DESC',
	'post_type'   => 'post',
	'post_status' => 'publish',
);

$frontpage_header = wp_get_recent_posts( $args, OBJECT );
wp_reset_postdata();
if ( ! $frontpage_header ) {
	return false;
}
?>
<!-- News Ticker Module -->

<span class="newspaper-x-module-title">
	<span class="fa-stack fa-lg">
	  <i class="fa fa-circle fa-stack-2x"></i>
	  <i class="fa fa-bullhorn fa-stack-1x fa-inverse"></i>
	</span>
	<?php echo esc_html__( 'Latest News', 'newspaper-x' ) ?>
</span>
<ul class="newspaper-x-news-carousel owl-carousel owl-theme">
	<?php foreach ( $frontpage_header as $post ) { ?>
		<li class="item">
			<a href="<?php echo esc_url( get_permalink( $post->ID ) ) ?>"><?php echo esc_html( $post->post_title ) ?></a>
		</li>
	<?php } ?>
</ul>

