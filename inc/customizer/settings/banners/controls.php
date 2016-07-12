<?php
global $wp_customize;

/**
 * Type of banners
 */
$wp_customize->add_control(
	'newspaperx_banner_type',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'image'   => esc_html__( 'Image', 'newspaper-x' ),
			'adsense' => esc_html__( 'AdSense', 'newspaper-x' )
		),
		'label'       => esc_html__( 'The type of the banner', 'newspaper-x' ),
		'description' => esc_html__( 'Select what type of banner you want to use: normal image or adsense script',
		                             'newspaper-x' ),
		'section'     => 'newspaperx_general_banners_controls',
	)
);

/**
 * The banner shown after a certain number of posts
 */
$wp_customize->add_control(
	new NewspaperX_Controls_Slider_Control(
		$wp_customize,
		'newspaperx_show_banner_after',
		array(
			'label'       => esc_html__( 'Banner after X posts?', 'newspaper-x' ),
			'description' => esc_html__( 'Show this banner after X number of posts.', 'newspaper-x' ),
			'choices'     => array(
				'min'  => 2,
				'max'  => 14,
				'step' => 2,
			),
			'section'     => 'newspaperx_general_banners_controls',
			'default'     => 4
		)
	)
);

/**
 * Display banner on homepage
 */
$wp_customize->add_control(
	'newspaperx_show_banner_on_homepage',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'   => esc_html__( 'Enable banner on homepage?', 'newspaper-x' ),
		'section' => 'newspaperx_general_banners_controls',
	)
);

/**
 * Display banner on categories page
 */
$wp_customize->add_control(
	'newspaperx_show_banner_on_archive_pages',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'   => esc_html__( 'Enable banner on categories page?', 'newspaper-x' ),
		'section' => 'newspaperx_general_banners_controls',
	)
);

/**
 * Image upload field for the top-right banner
 */
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'newspaperx_banner_image',
		array(
			'label'           => esc_html__( 'Banner Image:', 'newspaper-x' ),
			'description'     => esc_html__( 'Recommended size: 728 x 90', 'newspaper-x' ),
			'section'         => 'newspaperx_general_banners_controls',
			'active_callback' => 'banners_type_callback',
		)
	)
);

/**
 * Banner url
 */
$wp_customize->add_control(
	'newspaperx_banner_link',
	array(
		'label'           => esc_html__( 'Banner Link:', 'newspaper-x' ),
		'description'     => esc_html__( 'Add the link for banner image.', 'newspaper-x' ),
		'section'         => 'newspaperx_general_banners_controls',
		'settings'        => 'newspaperx_banner_link',
		'active_callback' => 'banners_type_callback',
	)
);

/**
 * AdSense code
 */
$wp_customize->add_control(
	'newspaperx_banner_adsense_code',
	array(
		'label'           => esc_html__( 'AdSense Code:', 'newspaper-x' ),
		'description'     => esc_html__( 'Add the code you retrieved from your AdSense account.', 'newspaper-x' ),
		'section'         => 'newspaperx_general_banners_controls',
		'settings'        => 'newspaperx_banner_adsense_code',
		'type'            => 'textarea',
		'active_callback' => 'banners_type_false_callback',
	)
);

function banners_type_callback( $control ) {
	if ( $control->manager->get_setting( 'newspaperx_banner_type' )->value() == 'image' ) {
		return true;
	}

	return false;
}

function banners_type_false_callback( $control ) {
	if ( $control->manager->get_setting( 'newspaperx_banner_type' )->value() == 'image' ) {
		return false;
	}

	return true;
}