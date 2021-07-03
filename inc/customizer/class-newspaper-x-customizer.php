<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Newspaper_X_Customizer {

	/**
	 * The basic constructor of the helper
	 * It changes the default panels of the customizer
	 *
	 * Newspaper_X_Customizer constructor.
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_enqueue_scripts' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );

		$this->change_default_panels();
		$this->add_theme_options();
	}

	/**
	 * Loads the settings for the panels
	 */
	public function add_theme_options() {
		$path = get_template_directory() . '/inc/libraries/epsilon-framework-addon';

		if ( file_exists( $path . '/class-epsilon-control-checkbox-multiple.php' ) ) {
			require_once $path . '/class-epsilon-control-checkbox-multiple.php';
		}

		$path  = get_template_directory() . '/inc/customizer/settings';
		$dirs  = glob( $path . '/*', GLOB_ONLYDIR );
		$files = array( 'panels', 'sections', 'settings', 'controls' );
		foreach ( $dirs as $dir ) {
			$dirname = basename( $dir );
			foreach ( $files as $file ) {
				if ( file_exists( get_template_directory() . '/inc/customizer/settings/' . $dirname . '/' . $file . '.php' ) ) {
					include_once get_template_directory() . '/inc/customizer/settings/' . $dirname . '/' . $file . '.php';
				}
			}
		}
	}

	/**
	 * Runs on initialization, changes the default panels to the Theme options
	 */
	public function change_default_panels() {
		global $wp_customize;

		/**
		 * Change transports
		 */
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'custom_logo' )->transport     = 'refresh';

		/**
		 * Change panels
		 */
		$wp_customize->get_section( 'background_image' )->panel = 'newspaper_x_panel_general';

		/**
		 * Change priorities
		 */
		$wp_customize->get_control( 'custom_logo' )->priority     = 0;
		$wp_customize->get_control( 'blogname' )->priority        = 2;
		$wp_customize->get_section( 'header_image' )->priority    = 4;
		$wp_customize->get_control( 'blogdescription' )->priority = 17;

		/**
		 * Change labels
		 */
		$wp_customize->get_control( 'custom_logo' )->description = esc_html__( 'The image logo, if set, will override the text logo. You can not have both at the same time. A tagline can be displayed under the text logo.', 'newspaper-x' );


		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title',
			'render_callback' => function () {
				bloginfo( 'name' );
			},
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => function () {
				bloginfo( 'description' );
			},
		) );

		$wp_customize->selective_refresh->add_partial( 'newspaper_x_banner_type', array(
			'selector'        => '.header-banner',
			'render_callback' => function () {
				$banner = get_theme_mod( 'newspaper_x_banner_type', 'image' );
				get_template_part( 'template-parts/banner/banner', $banner );
			},
		) );

		$wp_customize->selective_refresh->add_partial( 'newspaper_x_header_bg', array(
			'selector'        => '.newspaper-x-header-widget-area',
			'render_callback' => function () {
				get_template_part( 'template-parts/header-widget-area' );
			},
		) );

	}

	/*
	 * Our Customizer script
	 *
	 * Dependencies: Customizer Controls script (core)
	 */
	public function customizer_enqueue_scripts() {
		wp_enqueue_script( 'customizer-scripts', get_template_directory_uri() . '/inc/customizer/assets/js/customizer.js', array( 'customize-controls' ) );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 */
	public function customize_preview_js() {
		wp_enqueue_script( 'newspaper_x_customizer', get_template_directory_uri() . '/inc/customizer/assets/js/previewer.js', array( 'customize-preview' ), '21151215', true );

		wp_localize_script( 'newspaper_x_customizer', 'WPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' )
		) );
	}

	/**
	 * Simple function to add <br /> tags at new lines
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public static function sanitize_textarea_nl2br( $input ) {
		return nl2br( $input );
	}

	/**
	 * Simple function to validate choices from radio buttons
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public static function sanitize_radio_buttons( $input, $setting ) {

		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );
		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		}

		return $setting->default;

	}

	/**
	 * @param $input
	 *
	 * @return string
	 */
	public static function sanitize_number( $input ) {
		return force_balance_tags( $input );
	}

	/**
	 * @param $url
	 *
	 * @return string
	 */
	public static function sanitize_file_url( $url ) {

		$output = '';

		$filetype = wp_check_filetype( $url );
		if ( $filetype["ext"] ) {
			$output = esc_url( $url );
		}

		return $output;
	}

	/**
	 * @param $color
	 *
	 * @return null|string
	 */
	public static function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return NULL;
	}

	/**
	 * @param $value
	 *
	 * @return int
	 */
	public static function sanitize_checkbox( $value ) {
		return (bool) $value;
	}

	/**
	 * @param $value
	 *
	 * @return string
	 */
	public static function sanitize_allowed_html( $value ) {

		return wp_kses(
			$value,
			array(
				'a'      => array(
					'href'  => array(),
					'title' => array()
				),
				'img'    => array(
					'alt'   => array(),
					'title' => array(),
					'src'   => array(),
					'class' => array(),
					'id'    => array()
				),
				'br'     => array(),
				'em'     => array(),
				'strong' => array(),
			)
		);

	}

	/**
	 * @param $input
	 *
	 * @return string|void
	 */
	public static function color_escaping_option_sanitize( $input ) {
		$input = esc_attr( $input );

		return $input;
	}

	/**
	 * @param $color
	 *
	 * @return string
	 */
	public static function color_option_hex_sanitize( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	/**
	 * @param $values
	 *
	 * @return array
	 */
	public static function sanitize_multiple_checkbox( $values ) {

		$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;

		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}

	/**
	 * Active Callback for copyright
	 */
	public static function copyright_enabled_callback( $control ) {
		if ( $control->manager->get_setting( 'newspaper_x_enable_copyright' )->value() == true ) {
			return true;
		}

		return false;
	}

	public static function breadcrumbs_enabled_callback( $control ) {
		if ( $control->manager->get_setting( 'newspaper_x_enable_post_breadcrumbs' )->value() == 'breadcrumbs_enabled' ) {
			return true;
		}

		return false;
	}
}
