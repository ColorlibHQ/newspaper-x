<?php

/**
 * Enqueue scripts and styles in the frontend.
 */
function newspaper_x_scripts() {
	$newspaper_x = wp_get_theme();

	/**
	 * Load Google Fonts
	 */
	wp_enqueue_style( 'newspaper-x-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700|Nunito+Sans:300,400,700,900|Source+Sans+Pro:400,700', array(), $newspaper_x['Version'], 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendors/fontawesome//font-awesome.min.css' );

	/**
	 * Load the bootstrap framework
	 */
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap-theme.min.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.js', array( 'jquery' ), $newspaper_x['Version'], true );

	/**
	 * Theme styling
	 */
	wp_enqueue_style( 'newspaper-x-style', get_stylesheet_uri() );
	wp_enqueue_style( 'newspaper-x-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(), $newspaper_x['Version'] );

	$color = get_bloginfo( 'header_textcolor', 'display' );
	if ( $color !== 'blank' ) {
		$custom_css = "
                .site-description{
                    color: " . esc_html( $color ) . ";
                }";

		wp_add_inline_style( 'newspaper-x-style', $custom_css );
	}
	/**
	 * Load menu script & skip-link-focus-fix
	 */
	wp_enqueue_script( 'newspaper-x-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), $newspaper_x['Version'], true );
	wp_enqueue_script( 'newspaper-x-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), $newspaper_x['Version'], true );

	/**
	 * Adsense loader
	 */
	wp_enqueue_script( 'adsense-loader', get_template_directory_uri() . '/assets/vendors/adsenseloader/jquery.adsenseloader.js', array( 'jquery' ), $newspaper_x['Version'], true );

	/**
	 *Load the theme's core Javascript
	 */
	wp_enqueue_script( 'machothemes-object', get_template_directory_uri() . '/assets/vendors/machothemes/machothemes.min.js', array(), $newspaper_x['Version'], true );
	wp_enqueue_script( 'newspaper-x-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), $newspaper_x['Version'], true );
	wp_localize_script( 'newspaper-x-functions', 'WPUrls', array(
		'siteurl' => esc_url( get_option( 'siteurl' ) ),
		'theme'   => esc_url( get_template_directory_uri() ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
	) );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * OwlCarousel Library
	 */
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.js', array( 'jquery' ), $newspaper_x['Version'], true );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.css' );
	wp_enqueue_style( 'owl.carousel-theme', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.theme.default.css' );
}

add_action( 'wp_enqueue_scripts', 'newspaper_x_scripts' );

/**
 * Load admin fonts
 */
function newspaper_x_admin_scripts() {
	$newspaper_x = wp_get_theme();
	wp_enqueue_style( 'newspaper-x-fonts', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Poppins:400,500,600,700', array(), $newspaper_x['Version'], 'all' );
}

add_action( 'admin_enqueue_scripts', 'newspaper_x_admin_scripts' );

/**
 * Load editor styles
 */
function newspaper_x_add_editor_styles() {
	add_editor_style( 'inc/assets/css/custom-editor-style.css' );
}

add_action( 'admin_init', 'newspaper_x_add_editor_styles' );