<?php
global $wp_customize;

/**
 * Type of banners
 */
$wp_customize->add_control(
	'bugle_banner_type',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'image'   => esc_html__( 'Image', 'bugle' ),
			'adsense' => esc_html__( 'AdSense', 'bugle' )
		),
		'label'       => esc_html__( 'The type of the banner', 'bugle' ),
		'description' => esc_html__( 'Select what type of banner you want to use: normal image or adsense script',
		                             'bugle' ),
		'section'     => 'bugle_general_banners_controls',
	)
);

/**
 * The banner shown after a certain number of posts
 */
$wp_customize->add_control(
	new Bugle_Controls_Slider_Control(
		$wp_customize,
		'bugle_show_banner_after',
		array(
			'label'       => esc_html__( 'Banner after X posts?', 'bugle' ),
			'description' => esc_html__( 'Show this banner after X number of posts.', 'bugle' ),
			'choices'     => array(
				'min'  => 2,
				'max'  => 14,
				'step' => 2,
			),
			'section'     => 'bugle_general_banners_controls',
			'default'     => 4
		)
	)
);

/**
 * Display banner on homepage
 */
$wp_customize->add_control(
	'bugle_show_banner_on_homepage',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'   => esc_html__( 'Enable banner on homepage?', 'bugle' ),
		'section' => 'bugle_general_banners_controls',
	)
);

/**
 * Display banner on categories page
 */
$wp_customize->add_control(
	'bugle_show_banner_on_archive_pages',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'   => esc_html__( 'Enable banner on categories page?', 'bugle' ),
		'section' => 'bugle_general_banners_controls',
	)
);

/**
 * Image upload field for the top-right banner
 */
$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'bugle_banner_image',
		array(
			'label'       => esc_html__( 'Banner Image:', 'bugle' ),
			'description' => esc_html__( 'Recommended size: 728 x 90', 'bugle' ),
			'section'     => 'bugle_image_banner_controls',
		)
	)
);

/**
 * Banner url
 */
$wp_customize->add_control(
	'bugle_banner_link',
	array(
		'label'       => esc_html__( 'Banner Link:', 'bugle' ),
		'description' => esc_html__( 'Add the link for banner image.', 'bugle' ),
		'section'     => 'bugle_image_banner_controls',
		'settings'    => 'bugle_banner_link',
	)
);

/**
 * AdSense code
 */
$wp_customize->add_control(
	'bugle_banner_adsense_code',
	array(
		'label'       => esc_html__( 'AdSense Code:', 'bugle' ),
		'description' => esc_html__( 'Add the code you retrieved from your AdSense account.', 'bugle' ),
		'section'     => 'bugle_adsense_banner_controls',
		'settings'    => 'bugle_banner_adsense_code',
		'type'        => 'textarea'
	)
);