<?php
/**
 * Template part for displaying the news ticker
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$args             = array(
	'numberposts' => 10,
	'orderby'     => 'date',
	'order'       => 'DESC',
	'post_type'   => 'post',
	'post_status' => 'publish',
);
$frontpage_header = new WP_Query( $args );
wp_reset_postdata();

if ( $frontpage_header->have_posts() ): $i = 0; ?>
    <!-- News Ticker Module -->
    <span class="newspaper-x-module-title"><?php echo esc_html__( 'Latest News', 'newspaper-x' ) ?></span>
    <ul class="newspaper-x-news-carousel owl-carousel owl-theme">
		<?php while ( $frontpage_header->have_posts() ) : $frontpage_header->the_post(); ?>
            <li class="item">
                <a href="<?php echo esc_url( get_permalink( get_the_id() ) ) ?>"><?php echo esc_html( get_the_title() ) ?></a>
            </li>
		<?php endwhile; ?>
    </ul>
<?php endif;
