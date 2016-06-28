<?php
global $wp_customize;
$wp_customize->add_section( 'bugle_general_banners_controls',
                            array(
	                            'title'       => esc_html__( 'Ad Controls', 'bugle' ),
	                            'description' => esc_html__( 'Control various banner related settings from here',
	                                                         'bugle' ),
	                            'panel'       => 'bugle_panel_ad_manager'
                            )
);
$wp_customize->add_section( 'bugle_image_banner_controls',
                            array(
	                            'title' => esc_html__( 'Image Type Controls', 'bugle' ),
	                            'panel' => 'bugle_panel_ad_manager'
                            )
);
$wp_customize->add_section( 'bugle_adsense_banner_controls',
                            array(
	                            'title' => esc_html__( 'AdSense Type Controls', 'bugle' ),
	                            'panel' => 'bugle_panel_ad_manager'
                            )
);