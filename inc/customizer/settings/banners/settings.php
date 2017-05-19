<?php
global $wp_customize;
/**
 * Select the type of banner
 */
$wp_customize->add_setting( 'newspaper_x_banner_type',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_radio_buttons'
	                            ),
	                            'default'           => 'image'
                            )
);
/**
 * After how many posts you want to show the banner
 */
$wp_customize->add_setting( 'newspaper_x_show_banner_after',
                            array(
	                            'sanitize_callback' => 'absint',
	                            'default'           => 4
                            )
);

/**
 * Display banner on homepage
 */
$wp_customize->add_setting( 'newspaper_x_show_banner_on_homepage',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);
/**
 * Display banner on categories page
 */
$wp_customize->add_setting( 'newspaper_x_show_banner_on_archive_pages',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);


/**
 * Customize the banner image
 */
$wp_customize->add_setting( 'newspaper_x_banner_image',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_file_url'
	                            ),
	                            'default'           => esc_url( get_template_directory_uri() . '/assets/images/banner.png' ),
                            )
);
/**
 * Add a url to your banner URL
 */
$wp_customize->add_setting( 'newspaper_x_banner_link',
                            array(
	                            'sanitize_callback' => 'esc_url_raw',
	                            'default'           => esc_url( '#' ),
                            )
);

/**
 * Add an AdSense code
 */
$wp_customize->add_setting( 'newspaper_x_banner_adsense_code',
                            array(
	                            'sanitize_callback' => 'esc_html',
	                            'default'           => ''
                            )
);