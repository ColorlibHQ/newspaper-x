<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Newspaper X
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function newspaper_x_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

add_filter( 'body_class', 'newspaper_x_body_classes' );

# Check if it's an IIS powered server
if ( ! function_exists( 'newspaper_x_on_iis' ) ) {
	/**
	 * @return bool
	 */
	function newspaper_x_on_iis() {
		$sSoftware = strtolower( $_SERVER["SERVER_SOFTWARE"] );
		if ( strpos( $sSoftware, "microsoft-iis" ) !== false ) {
			return true;
		}

		return false;
	}
}

/**
 * Render breadcrumbs
 */
if ( ! function_exists( 'newspaper_x_breadcrumbs' ) ) {
	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php
	 *
	 * @return void
	 */
	function newspaper_x_breadcrumbs() {
		$breadcrumbs = new Newspaper_X_Breadcrumbs();
		$breadcrumbs->get_breadcrumbs();
	}
}

/**
 * Get an attachment ID given a URL.
 *
 * @param string $url
 *
 * @return int Attachment ID on success, 0 on failure
 */
function newspaper_x_get_attachment_id( $url ) {
	$attachment_id = 0;
	$dir           = wp_upload_dir();
	if ( false !== strpos( $url, $dir['baseurl'] . '/' ) ) { // Is URL in uploads directory?
		$file       = basename( $url );
		$query_args = array(
			'post_type'   => 'attachment',
			'post_status' => 'inherit',
			'fields'      => 'ids',
			'meta_query'  => array(
				array(
					'value'   => $file,
					'compare' => 'LIKE',
					'key'     => '_wp_attachment_metadata',
				),
			)
		);
		$query      = new WP_Query( $query_args );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $post_id ) {
				$meta                = wp_get_attachment_metadata( $post_id );
				$original_file       = basename( $meta['file'] );
				$cropped_image_files = wp_list_pluck( $meta['sizes'], 'file' );
				if ( $original_file === $file || in_array( $file, $cropped_image_files ) ) {
					$attachment_id = $post_id;
					break;
				}
			}
		}
	}

	return (int) $attachment_id;
}

/*
/* Add responsive container to embeds
*/
function newspaper_x_fix_responsive_videos( $html ) {
	return '<div class="newspaper-x-video-container">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'newspaper_x_fix_responsive_videos', 10, 3 );
add_filter( 'video_embed_html', 'newspaper_x_fix_responsive_videos' ); // Jetpack


/**
 * Helper function to determine what kind of archive page we are viewing and return an array
 */
function newspaper_x_check_archive() {

	$return = array(
		'type' => NULL,
		'id'   => NULL,
	);

	if ( is_category() ) {
		$return['type'] = 'category';
		$category       = get_category( get_query_var( 'cat' ) );
		$return['id']   = $category->cat_ID;
	}

	if ( is_tag() ) {
		$return['type'] = 'tags';
		$tags           = get_tags();
		$return['id']   = $tags[0]->term_id;
	}

	if ( is_day() ) {
		$return['type'] = 'day';
		$day            = get_query_var( 'day' );
		$return['id']   = $day;
	}

	if ( is_month() ) {
		$return['type'] = 'month';
		$month          = get_query_var( 'monthnum' );
		$return['id']   = $month;
	}

	if ( is_year() ) {
		$return['type'] = 'year';
		$year           = get_query_var( 'year' );
		$return['id']   = $year;
	}

	return $return;
}

;

/**
 * @param $array
 *
 * @return WP_Query
 */
function newspaper_x_get_first_posts( $array ) {
	$atts = array(
		'posts_per_page'      => 2,
		'order'               => 'DESC',
		'orderby'             => 'date',
		'ignore_sticky_posts' => true,
	);

	switch ( $array['type'] ) {
		case 'category':
			$atts['cat'] = $array['id'];
			break;
		case 'tags':
			$atts['tag_id'] = $array['id'];
			break;
		case 'day':
			$permalink = get_option( 'permalink_structure' );
			if ( empty( $permalink ) ) {
				$query       = get_query_var( 'm' );
				$array['id'] = substr( $query, 6, 2 );
			}

			$atts['date_query'] = array(
				array(
					'day' => $array['id'],
				)
			);
			break;
		case 'month':
			$permalink = get_option( 'permalink_structure' );
			if ( empty( $permalink ) ) {
				$query       = get_query_var( 'm' );
				$month       = substr( $query, 4, 2 );
				$array['id'] = $month;
			}

			$atts['date_query'] = array(
				array(
					'month' => $array['id'],
				)
			);
			break;
		case 'year':
			$permalink = get_option( 'permalink_structure' );
			if ( empty( $permalink ) ) {
				$query       = get_query_var( 'm' );
				$array['id'] = substr( $query, 0, 4 );
			}

			$atts['date_query'] = array(
				array(
					'year' => $array['id'],
				)
			);
			break;
	}

	$posts = new WP_Query( $atts );

	wp_reset_postdata();

	return $posts;

}

/**
 * @param string $format
 *
 * @return bool|mixed
 */
function newspaper_x_format_icon( $format = 'standard' ) {
	if ( $format === 'standard' ) {
		return false;
	}

	$icons = array(
		'aside'   => 'fa fa-hashtag',
		'image'   => 'fa fa-picture-o',
		'quote'   => 'fa fa-quote-left',
		'link'    => 'fa fa-link',
		'gallery' => 'fa fa-th-large',
		'video'   => 'fa fa-video-camera',
		'status'  => 'fa fa-heartbeat',
		'audio'   => 'fa fa-headphones',
		'chat'    => 'fa fa-comment-o'
	);

	return $icons[ $format ];
}

add_action( 'wp_ajax_newspaper_x_get_attachment_image', 'newspaper_x_get_attachment_image' );
add_action( 'wp_ajax_nopriv_newspaper_x_get_attachment_image', 'newspaper_x_get_attachment_image' );

function newspaper_x_get_attachment_image() {
	$id  = intval( $_POST['attachment_id'] );
	$src = wp_get_attachment_image( $id, false );

	echo esc_js( $src );
	die();
}

add_filter( 'comment_form_defaults', 'newspaper_x_comment_form_defaults' );
function newspaper_x_comment_form_defaults( $defaults ) {
	$defaults['title_reply'] = '<span>' . esc_html__( 'Leave a reply', 'newspaper-x' ) . '</span>';

	return $defaults;
}