<?php
global $wp_customize;

/**
 * Show / Hide the top bar
 */
$wp_customize->add_setting( 'newspaper_x_enable_top_bar',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Show / Hide the search icon from the top bar
 */
$wp_customize->add_setting( 'newspaper_x_enable_top_bar_search',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

$wp_customize->add_setting( 'newspaper_x_enable_news_ticker',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Breadcrumbs on single blog posts
 */
$wp_customize->add_setting( 'newspaper_x_enable_post_breadcrumbs',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);


/**
 * Footer Options
 */
$wp_customize->add_setting( 'newspaper_x_footer_columns',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_radio_buttons'
	                            ),
	                            'default'           => 3
                            )
);

/**
 * Copyright Options
 * enable the copyright text
 */
$wp_customize->add_setting( 'newspaper_x_enable_copyright',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);
/**
 * Copyright text
 */
$wp_customize->add_setting( 'newspaper_x_copyright_contents',
                            array(
	                            'sanitize_callback' => 'sanitize_text_field',
	                            'default'           => false,
                            )
);
/**
 * Enable the go top button
 */
$wp_customize->add_setting( 'newspaper_x_enable_go_top',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Blog Settings
 */
$wp_customize->add_setting( 'newspaper_x_related_posts_enabled',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Blog posts to display
 */
$wp_customize->add_setting( 'newspaper_x_howmany_blog_posts',
                            array(
	                            'sanitize_callback' => 'absint',
	                            'default'           => 4
                            )
);

/*
* Auto play carousel
*/
$wp_customize->add_setting( 'newspaper_x_autoplay_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Show Title
 */
$wp_customize->add_setting( 'newspaper_x_enable_related_title_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Show Date
 */
$wp_customize->add_setting( 'newspaper_x_enable_related_date_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => false
                            )
);

/**
 * Author box
 */
$wp_customize->add_setting( 'newspaper_x_enable_author_box',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_checkbox'
	                            ),
	                            'default'           => true
                            )
);

/**
 * Header background
 */
$wp_customize->add_setting( 'newspaper_x_header_bg',
                            array(
	                            'sanitize_callback' => array(
		                            'Newspaper_X_Customizer',
		                            'sanitize_hex_color'
	                            ),
	                            'default'           => '#0E0E11'
                            )
);