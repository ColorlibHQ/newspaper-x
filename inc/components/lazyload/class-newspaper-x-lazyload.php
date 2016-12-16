<?php

class Newspaper_X_Lazy_Load_Images {
	public $src;

	function __construct() {
		// Add Our Filters and actions for the plugin
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_lazyload' ) );
		add_filter( 'the_content', array( $this, 'filter_lazyload_content' ) );
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
		return preg_replace_callback( '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', array(
			$this,
			'preg_replace_callback_src'
		), $content['image'] );
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

// Initiate Class
new Newspaper_X_Lazy_Load_Images();