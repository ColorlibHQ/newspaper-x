<?php
/**
 * Template part for displaying the news ticker
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

$args = array(
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
<section class="newspaper-x-news-ticker">
    <span class="newspaper-x-module-title">
        <span class="fa-stack fa-lg">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fa fa-bullhorn fa-stack-1x fa-inverse"></i>
        </span>
        <?php echo esc_html__( 'Latest News', 'newspaper-x' ) ?>
    </span>
    <ul class="newspaper-x-news-carousel owl-carousel owl-theme">
        <?php while ( $frontpage_header->have_posts() ) : $frontpage_header->the_post(); ?>
            <li class="item">
                <a href="<?php echo esc_url( get_permalink( get_the_id() ) ) ?>"><?php echo esc_html( get_the_title() ) ?></a>
            </li>
        <?php endwhile; ?>
    </ul>
</section>
<?php endif; ?>