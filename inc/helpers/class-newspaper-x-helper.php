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
	 * @param $array
	 *
	 * @return WP_Query
	 */
	public static function get_first_posts( $array ) {
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


	/**
	 * @return array
	 */
	public static function check_archive() {

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

	/**
	 * @param string $format
	 *
	 * @return bool|mixed
	 */
	public static function format_icon( $format = 'standard' ) {
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

	/**
	 * Render the breadcrumbs with help of class-breadcrumbs.php
	 *
	 * @return void
	 */
	public static function add_breadcrumbs() {
		$breadcrumbs = new Newspaper_X_Breadcrumbs();
		$breadcrumbs->get_breadcrumbs();
	}

	/**
	 * @param $image_object
	 *
	 * @return array
	 */
	public static function get_lazy_image( $image_object ) {

		$lazy = get_theme_mod( 'newspaper_x_enable_blazy', '' );
		$img  = $image_object['image'];

		if ( $lazy ) {
			$img = apply_filters( 'newspaper_x_widget_image', $image_object );
		}

		$allowed_tags = array(
			'img'      => array(
				'data-srcset' => true,
				'data-src'    => true,
				'srcset'      => true,
				'sizes'       => true,
				'src'         => true,
				'class'       => true,
				'alt'         => true,
				'width'       => true,
				'height'      => true
			),
			'noscript' => array()
		);

		return array(
			'image' => $img,
			'tags'  => $allowed_tags
		);
	}

	public static function get_first_media( $post_id ) {
		$post    = get_post( $post_id );
		$content = do_shortcode( apply_filters( 'the_content', $post->post_content, 1 ) );
		$embeds  = get_media_embedded_in_content( $content );
		$href    = '';
		$type    = '';
		$html    = '';

		if ( empty( $embeds ) ) {
			return false;
		}

		foreach ( $embeds as $embed ) {
			if ( strpos( $embed, 'youtube' ) ) {
				preg_match( '/src="([^"]+)"/', $embed, $match );
				$href = $match[1];

				$type = 'youtube';
			} elseif ( strpos( $embed, 'vimeo' ) ) {
				preg_match( '/src="([^"]+)"/', $embed, $match );
				$href = $match[1];

				$type = 'vimeo';
			} else {
				$element = new SimpleXMLElement( $embeds[0] );
				$href    = (string) $element->a->attributes()->href;
				$type    = 'local';
			}
		}

		if ( ! empty( $href ) ) {
			switch ( $type ) {
				case 'local':
					$html = '<div>';
					$html .= '<video class="plyr">';
					$html .= '<source src=' . $href . '>';
					$html .= '</video>';
					$html .= '</div>';
					break;
				default:
					$html = '<div class="plyr" data-type="' . $type . '" data-video-id="' . $href . '">';
					$html .= '</div>';
					break;
			}

			return $html;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public static function on_iis() {
		$sSoftware = strtolower( $_SERVER["SERVER_SOFTWARE"] );
		if ( strpos( $sSoftware, "microsoft-iis" ) !== false ) {
			return true;
		}

		return false;
	}

	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	public static function categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'newspaper_x_categories' ) ) ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories( array(
				                                     'fields'     => 'ids',
				                                     'hide_empty' => 1,
				                                     // We only need to know if there is more than one category.
				                                     'number'     => 2,
			                                     ) );

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'newspaper_x_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so newspaper_x_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so newspaper_x_categorized_blog should return false.
			return false;
		}
	}

	/**
	 * Infinite scroll render for jetpack
	 */
	public static function infinite_scroll_render(){
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_format() );
			endif;
		}
	}

	/**
	 * @param array $args
	 */
	public static function the_posts_navigation( $args = array() ) {
		echo get_the_posts_navigation( $args );
	}

	/**
	 * @param string $element
	 */
	public static function posted_on( $element = 'default' ) {
		$cat  = get_the_category();
		$date = get_the_date();

		$html = '<div>';
		if ( ! empty( $cat ) ) {
			$html .= '<span class="newspaper-x-category"> <a href="' . esc_url( get_category_link( $cat[0]->term_id ) ) . '">' . esc_html( get_the_category_by_ID( $cat[0]->term_id ) ) . '</a></span>';
		}
		$html .= '<span class="newspaper-x-date">' . esc_html( $date ) . ' </span>';
		$html .= '</div>';

		switch ( $element ) {
			case 'category':
				echo '<a href="' . esc_url( get_category_link( $cat[0]->term_id ) ) . '">' . esc_html( get_the_category_by_ID( $cat[0]->term_id ) ) . '</a>';
				break;
			case 'date':
				echo '<div class="newspaper-x-date">' . esc_html( $date ) . '</div>';
				break;
			default:
				echo $html;
				break;
		}
	}
}