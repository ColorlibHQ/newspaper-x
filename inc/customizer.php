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
function newspaperx_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Remove sections from customizer front-view
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );

	/**
	 * Custom controls
	 */
	require_once 'customizer/custom-fields/control-checkbox-multiple.php';
	require_once 'customizer/custom-fields/control-slider-control.php';

	/**
	 * Customizer settings
	 */
	require_once 'customizer/register_settings.php';

	/**
	 * Initiate the setting helper
	 */
	$newspaperx_customizer = new NewspaperX_Customizer_Helper();
	$newspaperx_customizer->add_theme_options();
}

add_action( 'customize_register', 'newspaperx_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function newspaperx_customize_preview_js() {
	wp_enqueue_script( 'newspaperx_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}

add_action( 'customize_preview_init', 'newspaperx_customize_preview_js' );
