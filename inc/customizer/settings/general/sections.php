<?php
global $wp_customize;

$wp_customize->add_section( 'bugle_general_section',
                            array(
	                            'title'    => esc_html__( 'General', 'bugle' ),
	                            'panel'    => 'bugle_panel_general',
	                            'priority' => 1,
                            )
);

$wp_customize->add_section( 'bugle_footer_section',
                            array(
	                            'title'    => esc_html__( 'Footer', 'bugle' ),
	                            'panel'    => 'bugle_panel_general',
	                            'priority' => 2,
                            )
);

$wp_customize->add_section( 'bugle_blog_section',
                            array(
	                            'title'    => esc_html__( 'Blog Settings', 'bugle' ),
	                            'panel'    => 'bugle_panel_general',
	                            'priority' => 3,
                            )
);