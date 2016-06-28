<?php
global $wp_customize;

$wp_customize->add_panel( 'bugle_panel_ad_manager',
                          array(
	                          'priority'       => 34,
	                          'capability'     => 'edit_theme_options',
	                          'theme_supports' => '',
	                          'title'          => esc_html__( 'Ad Manager', 'bugle' ),
	                          'description'    => esc_html__( 'Easy banner management ( supports image banners & AdSense type - JS powered banners) ', 'bugle' ),
                          )
);