<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Newspaper_X_Related_Posts_Output
 *
 * This file does the social sharing handling for the Muscle Core Lite Framework
 *
 * @author           Cristian Raiber
 * @copyright    (c) Copyright by Macho Themes
 * @link             http://www.machothemes.com
 * @package          Newspaper X
 * @since            Version 1.0.0
 */

/**
 * Class Newspaper_X_Related_Posts_Output
 */
class Newspaper_X_Related_Posts {

	/**
	 * @var Singleton The reference to *Singleton* instance of this class
	 */
	private static $instance;

	/**
	 * Constructor
	 */
	protected function __construct() {

		$related_posts = get_theme_mod( 'newspaper_x_related_posts_enabled', true );
		if ( $related_posts ) {
			add_action( 'newspaper_x_single_after_article', array( $this, 'output_related_posts' ), 2 );
		}

	}

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 */
	public static function getInstance() {
		if ( NULL === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {
	}

	/**
	 * Private unserialize method to prevent unserializing of the *Singleton*
	 * instance.
	 *
	 * @return void
	 */
	private function __wakeup() {
	}


	/**
	 * Get related posts by category
	 *
	 * @param  integer $post_id      current post id
	 * @param  integer $number_posts number of posts to fetch
	 *
	 * @return object                  object with posts info
	 */
	public function get_related_posts( $post_id, $number_posts = - 1 ) {

		$related_postquery = new WP_Query();
		$args              = '';

		if ( $number_posts == 0 ) {
			return $related_postquery;
		}

		$args = wp_parse_args( $args, array(
			'category__in'        => wp_get_post_categories( $post_id ),
			'ignore_sticky_posts' => 0,
			'posts_per_page'      => $number_posts,
			'post__not_in'        => array( $post_id ),
//				'meta_key'            => '_thumbnail_id',
		) );

		$related_postquery = new WP_Query( $args );

		// reset post query
		wp_reset_postdata();
		wp_reset_query();

		return $related_postquery;
	}

	/**
	 * Render related posts carousel
	 *
	 * @return string                    HTML markup to display related posts
	 **/
	function output_related_posts() {
		// Check if related posts should be shown
		$related_posts = $this->get_related_posts( get_the_ID(), get_option( 'posts_per_page' ) );

		if ( $related_posts->post_count == 0 ) {
			return false;
		}

		echo '<div class="newspaper-x-related-posts">';

		// Number of posts to show / view
		$limit      = get_theme_mod( 'newspaper_x_howmany_blog_posts', 3 );
		$show_title = get_theme_mod( 'newspaper_x_enable_related_title_blog_posts', true );
		$show_date  = get_theme_mod( 'newspaper_x_enable_related_date_blog_posts', false );
		$auto_play  = get_theme_mod( 'newspaper_x_autoplay_blog_posts', true );


		echo '<div class="row">';

		/*
		 * Heading
		 */
		echo '<div class="col-lg-11 col-sm-10 col-xs-12 newspaper-x-related-posts-title">';
		echo '<h3><span>' . esc_html__( 'Related posts ', 'newspaper-x' ) . '</span></h3>';
		echo '</div>';

		/*
		 * Arrows
		 */
		echo '<div class="newspaper-x-carousel-navigation hidden-xs text-right">';
		echo '<ul class="newspaper-x-carousel-arrows clearfix">';
		echo '<li><a href="#" class="newspaper-x-owl-prev fa fa-angle-left"></a></li>';
		echo '<li><a href="#" class="newspaper-x-owl-next fa fa-angle-right"></a></li>';
		echo '</ul>';
		echo '</div>';
		echo '</div><!--/.row-->';

		echo sprintf( '<div class="owlCarousel owl-carousel owl-theme" data-slider-id="%s" id="owlCarousel-%s" 
			data-slider-items="%s" 
			data-slider-speed="400" data-slider-auto-play="%s" data-slider-navigation="false">', get_the_ID(), get_the_ID(), $limit, $auto_play );

		// Loop through related posts
		while ( $related_posts->have_posts() ) {
			$related_posts->the_post();

			echo '<div class="item">';
			if ( has_post_thumbnail( $related_posts->post->ID ) ) {
				echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_post_thumbnail( $related_posts->post->ID, 'newspaper-x-recent-post-big' ) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_the_permalink() ) . '"><img class="attachment-newspaper-x-recent-post-big size-newspaper-x-recent-post-big wp-post-image" alt="" src="' . esc_url( get_template_directory_uri() . '/assets/images/picture_placeholder.jpg' ) . '" /></a>';
			}

			if ( $show_title ) {
				echo '<div class="newspaper-x-related-post-title">';

				# Post Title
				echo '<a href="' . esc_url( get_the_permalink() ) . '">' . wp_trim_words( get_the_title(), 5 ) .
				     '</a>';

				echo '</div>';

			}

			if ( $show_date ) {

				echo '<div class="newspaper-x-related-posts-date">';

				#Post Date
				echo esc_html( get_the_date() );

				echo '</div>';
			}

			echo '</div><!--/.item-->';
		}

		echo '</div><!--/.owlCarousel-->';
		echo '</div><!--/.mt-related-posts-->';

		wp_reset_postdata();
	}
}
