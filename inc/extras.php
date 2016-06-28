<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bugle
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function bugle_body_classes( $classes ) {
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

add_filter( 'body_class', 'bugle_body_classes' );

# Check if it's an IIS powered server
if ( ! function_exists( 'bugle_on_iis' ) ) {
	/**
	 * @return bool
	 */
	function bugle_on_iis() {
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
if ( ! function_exists( 'bugle_breadcrumbs' ) ) {
	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php
	 *
	 * @return void
	 */
	function bugle_breadcrumbs() {
		$breadcrumbs = new Bugle_Breadcrumbs();
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
function bugle_get_attachment_id( $url ) {
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

	return $attachment_id;
}

/**
 * Change default fields, add placeholder and change type attributes.
 *
 * @param  array $fields
 *
 * @return array
 */
function bugle_comment_placeholders( $fields ) {
	$fields['author'] = str_replace(
		'<input',
		'<input placeholder="'
		. _x(
			'Name *',
			'comment form placeholder',
			'bugle'
		)
		. '"',
		$fields['author']
	);
	$fields['email']  = str_replace(
		'<input id="email" name="email"',
		'<input placeholder="Email *"  id="email" name="email"',
		$fields['email']
	);
	$fields['url']    = str_replace(
		'<input id="url" name="url"',
		'<input placeholder="Website" id="url" name="url"',
		$fields['url']
	);

	return $fields;
}

add_filter( 'comment_form_default_fields', 'bugle_comment_placeholders' );


/*
/* Add responsive container to embeds
*/
function bugle_fix_responsive_videos( $html ) {
	return '<div class="bugle-video-container">' . $html . '</div>';
}

add_filter( 'embed_oembed_html', 'bugle_fix_responsive_videos', 10, 3 );
add_filter( 'video_embed_html', 'bugle_fix_responsive_videos' ); // Jetpack


/**
 * Helper function to determine what kind of archive page we are viewing and return an array
 */
function bugle_check_archive() {

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
function bugle_get_first_posts( $array ) {
	$atts = array(
		'posts_per_page' => 2,
		'order'          => 'DESC',
		'orderby'        => 'date'
	);

	switch ( $array['type'] ) {
		case 'category':
			$atts['cat'] = $array['id'];
			break;
		case 'tags':
			$atts['tag_id'] = $array['id'];
			break;
		case 'day':
			$atts['date_query'] = array(
				array(
					'day' => $array['id'],
				)
			);
			break;
		case 'month':
			$atts['date_query'] = array(
				array(
					'month' => $array['id'],
				)
			);
			break;
		case 'year':
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

function bugle_render_banner() {
	$banner_type = get_theme_mod( 'bugle_banner_type', 'image' );

	$html = '';
	$html .= '<div class="row">';

	if ( $banner_type === 'image' ) {
		$image = get_theme_mod( 'bugle_banner_image', get_template_directory_uri() . '/images/banner.jpg' );

		if ( $image !== get_template_directory_uri() . '/images/banner.jpg' ) {

		}

		$html .= '<div class="col-xs-12 bugle-image-banner">';
		$html .= '<a href="' . get_theme_mod( 'bugle_banner_link', 'https://colorlib.com/wp/themes/ensign/' ) . '">';
		$html .= '<img src="' . get_theme_mod( 'bugle_banner_image', get_template_directory_uri() . '/images/banner.jpg' ) . '"/>';
		$html .= '</a>';
		$html .= '</div>';
	}

	$html .= '</div>';

	return $html;
}