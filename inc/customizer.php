<?php
/**
 * Newspaper X Theme Customizer.
 *
 * @package Newspaper X
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function newspaper_x_customize_register( $wp_customize ) {
	/**
	 * Customizer settings
	 */
	require_once get_template_directory() . '/inc/customizer/register_settings.php';
	$controls = array( 'checkbox-multiple', 'slider-control', 'toggle', 'upsell' );
	/**
	 * Initiate the setting helper
	 */
	$newspaper_x_customizer = new Newspaper_X_Customizer_Helper( $controls );
	$newspaper_x_customizer->add_theme_options();
}

add_action( 'customize_register', 'newspaper_x_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function newspaper_x_customize_preview_js() {
	wp_enqueue_script( 'newspaper_x_customizer', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/js/previewer.js', array( 'customize-preview' ), false, true );

	wp_localize_script( 'newspaper_x_customizer', 'WPUrls', array(
		'siteurl' => esc_url( get_option( 'siteurl' ) ),
		'theme'   => esc_url( get_template_directory_uri() ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
	) );

	wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/css/style.css', array(), '2' );

}

function newspaper_x_customizer_enqueue_scripts() {
	/*
	 * Our Customizer script
	 *
	 * Dependencies: Customizer Controls script (core)
	 */
	wp_enqueue_script( 'epsilon-object', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/js/epsilon.js', array( 'jquery' ), '22515141' );
	wp_localize_script( 'epsilon-object', 'WPUrls', array(
		'siteurl' => esc_url( get_option( 'siteurl' ) ),
		'theme'   => esc_url( get_template_directory_uri() ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
	) );
	wp_enqueue_script( 'newspaper_x_customizer-scripts', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/js/customizer.js', array( 'customize-controls' ) );
	wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/css/style.css', array(), '2' );

}

add_action( 'customize_controls_enqueue_scripts', 'newspaper_x_customizer_enqueue_scripts' );
add_action( 'customize_preview_init', 'newspaper_x_customize_preview_js' );
