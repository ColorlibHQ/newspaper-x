<?php
global $wp_customize;

$wp_customize->add_section( 'newspaper_x_general_section',
                            array(
	                            'title'    => esc_html__( 'General', 'newspaper-x' ),
	                            'panel'    => 'newspaper_x_panel_general',
	                            'priority' => 1,
                            )
);

$wp_customize->add_section( 'newspaper_x_footer_section',
                            array(
	                            'title'    => esc_html__( 'Footer', 'newspaper-x' ),
	                            'panel'    => 'newspaper_x_panel_general',
	                            'priority' => 2,
                            )
);

$wp_customize->add_section( 'newspaper_x_blog_section',
                            array(
	                            'title'    => esc_html__( 'Blog Settings', 'newspaper-x' ),
	                            'panel'    => 'newspaper_x_panel_general',
	                            'priority' => 3,
                            )
);

