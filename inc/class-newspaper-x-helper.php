<?php

class Newspaper_X_Helper {

	/**
	 * @param string $dirname 'foo-bar'
	 *
	 * @return string 'Foo_Bar'
	 */
	public static function dirname_to_classname( $dirname ) {
		$class_name = explode( '-', $dirname );
		$class_name = array_map( 'ucfirst', $class_name );
		$class_name = implode( '_', $class_name );

		return $class_name;
	}

	/**
	 * Proxy function to return posts
	 *
	 * @param $args
	 *
	 * @return WP_Query
	 */
	public static function get_posts( $args ) {

		$atts = array(
			'cat'            => is_array( $args['cats'] ) ? implode( ',', $args['cats'] ) : '',
			'posts_per_page' => $args['limit'],
			'order'          => $args['order'],
			'offset'         => $args['offset'],
			'orderby'        => $args['orderby']
		);

		$posts = new WP_Query( $atts );

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * Function to return a placeholder if the post has no thumbnail
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function get_post_image( $id, $size ) {
		$image = get_template_directory_uri() . '/assets/images/picture_placeholder.jpg';
		if ( has_post_thumbnail( $id ) ) {
			$image = get_the_post_thumbnail_url( $id, $size );
		}

		return $image;
	}

	/**
	 * Helper function to echo the post information
	 *
	 * @param $id
	 *
	 * @return string
	 */
	public static function get_post_meta( $id ) {
		$cat      = wp_get_post_categories( $id );
		$comments = wp_count_comments( $id );
		$date     = get_the_date( 'F d, Y', $id );

		if ( empty( $cat ) ) {
			$cat[] = 'Uncategorized';
		}

		$html = '<ul>';
		$html .= '<li class="post-date">' . esc_html( $date ) . '</li>';
		$html .= '<li class="post-comments">' . esc_html( $comments->approved ) . ' ' . esc_html__( 'Comments', 'newspaper-x' ) . '</li>';
		$html .= '<li class="post-category"><a href="' . esc_url( get_category_link( $cat[0] ) ) . '">' . esc_html( get_the_category_by_ID( $cat[0] ) ) . '</a></li>';
		$html .= '</ul>';

		return $html;
	}
}