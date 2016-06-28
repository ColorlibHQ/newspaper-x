<?php
global $wp_customize;
$wp_customize->add_panel( 'bugle_panel_general',
                          array(
	                          'priority'       => 24,
	                          'capability'     => 'edit_theme_options',
	                          'theme_supports' => '',
	                          'title'          => esc_html__( 'Theme options', 'bugle' )
                          )
);