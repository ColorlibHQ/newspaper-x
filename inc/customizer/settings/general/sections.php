<?php
global $wp_customize;

$wp_customize->add_section( 'newspaperx_general_section',
                            array(
	                            'title'    => esc_html__( 'General', 'newspaper-x' ),
	                            'panel'    => 'newspaperx_panel_general',
	                            'priority' => 1,
                            )
);

$wp_customize->add_section( 'newspaperx_footer_section',
                            array(
	                            'title'    => esc_html__( 'Footer', 'newspaper-x' ),
	                            'panel'    => 'newspaperx_panel_general',
	                            'priority' => 2,
                            )
);

$wp_customize->add_section( 'newspaperx_blog_section',
                            array(
	                            'title'    => esc_html__( 'Blog Settings', 'newspaper-x' ),
	                            'panel'    => 'newspaperx_panel_general',
	                            'priority' => 3,
                            )
);