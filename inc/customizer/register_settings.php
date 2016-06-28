<?php

class Bugle_Customizer_Helper {

	/**
	 * The basic constructor of the helper
	 * It changes the default panels of the customizer
	 *
	 * Bugle_Customizer_Helper constructor.
	 */
	public function __construct() {
		$this->change_default_panels();
	}

	/**
	 * Loads the settings for the panels
	 */
	public function add_theme_options() {
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
		# Necessary since we can't debug on IIS servers
		# Mac OS X rules for dev :)
		if ( ! bugle_on_iis() ) {

			// Change panel for Site Title & Tagline Section
			$site_title        = $wp_customize->get_section( 'title_tagline' );
			$site_title->panel = 'bugle_panel_general';

			// Change panel for Static Front Page
			$site_title3        = $wp_customize->get_section( 'static_front_page' );
			$site_title3->panel = 'bugle_panel_general';

			// Change priority for Site Title
			$site_title4              = $wp_customize->get_control( 'blogname' );
			$site_title4->section     = 'bugle_general_section';
			$site_title4->description = esc_html__( 'Company name in text format below', 'bugle' );
			$site_title4->priority    = 1;

			// Change priority for Site Tagline
			$site_title5           = $wp_customize->get_control( 'blogdescription' );
			$site_title5->priority = 17;
		}
	}

	/**
	 * Simple function to add <br /> tags at new lines
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public static function bugle_sanitize_textarea_nl2br( $input ) {
		return nl2br( $input );
	}

	/**
	 * Simple function to validate choices from radio buttons
	 *
	 * @param $input
	 *
	 * @return string
	 */
	public static function bugle_sanitize_radio_buttons( $input, $setting ) {

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
	public static function bugle_sanitize_number( $input ) {
		return force_balance_tags( $input );
	}

	/**
	 * @param $url
	 *
	 * @return string
	 */
	public static function bugle_sanitize_file_url( $url ) {

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
	public static function bugle_sanitize_hex_color( $color ) {
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
	public static function bugle_sanitize_checkbox( $value ) {
		if ( $value == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * @param $value
	 *
	 * @return string
	 */
	public static function bugle_sanitize_allowed_html( $value ) {

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
	 * @param $values
	 *
	 * @return array
	 */
	public static function bugle_sanitize_multiple_checkbox( $values ) {

		$multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;

		return ! empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
	}
}
