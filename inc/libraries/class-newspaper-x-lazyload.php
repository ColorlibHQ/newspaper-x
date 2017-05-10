<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Newspaper_X_LazyLoad {
	public $src;

	function __construct() {
		// Add Our Filters and actions for the plugin
		$lazy = get_theme_mod( 'newspaper_x_enable_blazy', '' );

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_lazyload' ) );

		if ( $lazy ) {

			$browser = $this->check_browser_version();
			if ( $browser['name'] === 'Internet Explorer' ) {
				add_filter( 'wp_get_attachment_image_attributes', function ( $attr ) {
					if ( isset( $attr['sizes'] ) ) {
						unset( $attr['sizes'] );
					}
					if ( isset( $attr['srcset'] ) ) {
						unset( $attr['srcset'] );
					}

					return $attr;
				}, PHP_INT_MAX );
				add_filter( 'wp_calculate_image_sizes', '__return_false', PHP_INT_MAX );
				add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX );
				remove_filter( 'the_content', 'wp_make_content_images_responsive' );
			}

			add_filter( 'the_content', array( $this, 'filter_lazyload_content' ) );
		}

		add_filter( 'newspaper_x_widget_image', array( $this, 'filter_lazyload' ) );
	}

	function enqueue_lazyload() {
		// Make sure to load in the lazy load script
		wp_enqueue_script( 'jquery_lazy_load', get_template_directory_uri() . '/assets/vendors/blazy/blazy.min.js', array( 'jquery' ), '1.9.1' );
	}

	function filter_lazyload_content( $content ) {
		// Perform a search for all images
		return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', array(
			$this,
			'preg_replace_callback_src'
		), $content );
	}

	function filter_lazyload( $content ) {
		$this->src = get_the_post_thumbnail_url( $content['id'], 'newspaper-x-recent-post-list-image' );
		if ( ! $this->src ) {
			// Perform a search for all images
			return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', array(
				$this,
				'preg_replace_callback_src'
			), $content['image'] );
		}

		// Perform a search for all images
		return preg_replace_callback( '/(<\s*img[^>]+)(srcset\s*=\s*"[^"]+")([^>]+>)/i', array(
			$this,
			'preg_replace_callback'
		), $content['image'] );
	}

	function check_browser_version() {
		if ( empty( $_SERVER['HTTP_USER_AGENT'] ) ) {
			return false;
		}

		$key = md5( $_SERVER['HTTP_USER_AGENT'] );

		if ( false === ( $response = get_site_transient( 'browser_' . $key ) ) ) {
			$options = array(
				'body'       => array( 'useragent' => $_SERVER['HTTP_USER_AGENT'] ),
				'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . home_url()
			);

			$response = wp_remote_post( 'http://api.wordpress.org/core/browse-happy/1.1/', $options );

			if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
				return false;
			}

			/**
			 * Response should be an array with:
			 *  'name' - string - A user friendly browser name
			 *  'version' - string - The version of the browser the user is using
			 *  'current_version' - string - The most recent version of the browser
			 *  'upgrade' - boolean - Whether the browser needs an upgrade
			 *  'insecure' - boolean - Whether the browser is deemed insecure
			 *  'upgrade_url' - string - The url to visit to upgrade
			 *  'img_src' - string - An image representing the browser
			 *  'img_src_ssl' - string - An image (over SSL) representing the browser
			 */
			$response = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( ! is_array( $response ) ) {
				return false;
			}

			set_site_transient( 'browser_' . $key, $response, WEEK_IN_SECONDS );
		}

		return $response;
	}

	function preg_replace_callback_src( $matches ) {
		if ( ! $this->src ) {
			$this->src = get_template_directory_uri() . '/assets/images/picture_placeholder_list.jpg';
		}

		// Step 1: Replace our source attribute with a placeholder, and add a "data-original" attribute with our image source
		$img_replace = $matches[1] . 'src="' . $this->src . '" data-src' . substr( $matches[2], 3 ) . $matches[3];
		// Step 2: Add the class "lazy" to the image
		$img_replace = preg_replace( '/class\s*=\s*"/i', 'class="blazy ', $img_replace );

		// Step 3: Add a noscript tag as a fallback
		$img_replace .= '<noscript>' . $matches[0] . '</noscript>';


		return $img_replace;
	}

	function preg_replace_callback( $matches ) {
		if ( ! $this->src ) {
			$this->src = get_template_directory_uri() . '/assets/images/picture_placeholder_list.jpg';
		}

		// Step 1: Replace our source attribute with a placeholder, and add a "data-original" attribute with our image source
		$img_replace = $matches[1] . 'src="' . $this->src . '" data-src="' . $this->src . '" data-srcset' . substr( $matches[2], 6 ) . $matches[3];
		// Step 2: Add the class "lazy" to the image
		$img_replace = preg_replace( '/class\s*=\s*"/i', 'class="blazy ', $img_replace );

		// Step 3: Add a noscript tag as a fallback
		$img_replace .= '<noscript>' . $matches[0] . '</noscript>';

		return $img_replace;
	}
}
