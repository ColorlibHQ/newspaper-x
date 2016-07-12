<?php
global $wp_customize;

/**
 * Show / Hide the top bar
 */
$wp_customize->add_setting( 'newspaperx_recent_posts_category',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_multiple_checkbox'
	                            ),
	                            'default'           => '1'
                            )
);

$wp_customize->add_setting( 'newspaperx_recent_posts_ordering',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'DESC'
                            )
);

$wp_customize->add_setting( 'newspaperx_recent_posts_order_by',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'date'
                            )
);