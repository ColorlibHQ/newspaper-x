<?php
global $wp_customize;

/**
 * Show / Hide the top bar
 */
$wp_customize->add_setting( 'newspaper_x_frontpage_header_category',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_multiple_checkbox'
	                            ),
	                            'default'           => '1'
                            )
);

$wp_customize->add_setting( 'newspaper_x_frontpage_header_ordering',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_radio_buttons'
	                            ),
	                            'default'           => 'DESC'
                            )
);

$wp_customize->add_setting( 'newspaper_x_frontpage_header_order_by',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_radio_buttons'
	                            ),
	                            'default'           => 'date'
                            )
);