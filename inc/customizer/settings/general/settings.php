<?php
global $wp_customize;

/**
 * Show / Hide the top bar
 */
$wp_customize->add_setting( 'newspaperx_enable_top_bar',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);

/**
 * Show / Hide the search icon from the top bar
 */
$wp_customize->add_setting( 'newspaperx_enable_top_bar_search',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);

$wp_customize->add_setting( 'newspaperx_enable_news_ticker',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);

/**
 * Breadcrumbs on single blog posts
 */
$wp_customize->add_setting( 'newspaperx_enable_post_breadcrumbs',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'breadcrumbs_enabled'
                            )
);

/**
 * Breadcrumbs separator
 */
$wp_customize->add_setting( 'newspaperx_blog_breadcrumb_menu_separator',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'rarr'
                            )
);

/**
 * Breadcrumb post category
 */
$wp_customize->add_setting( 'newspaperx_blog_breadcrumb_menu_post_category',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_checkbox'
	                            ),
	                            'default'           => 1
                            )
);

/**
 * Footer Options
 */
$wp_customize->add_setting( 'newspaperx_footer_columns',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 3
                            )
);

/**
 * Copyright Options
 * enable the copyright text
 */
$wp_customize->add_setting( 'newspaperx_enable_copyright',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);
/**
 * Copyright text
 */
$wp_customize->add_setting( 'newspaperx_copyright_contents',
                            array(
	                            'sanitize_callback' => 'esc_html',
	                            'default'           => date( "Y" ) . ' Newspaper X. All rights reserved.',
                            )
);
/**
 * Enable the go top button
 */
$wp_customize->add_setting( 'newspaperx_enable_go_top',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);

/**
 * Blog Settings
 */
$wp_customize->add_setting( 'newspaperx_related_posts_enabled',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);

/**
 * Blog posts to display
 */
$wp_customize->add_setting( 'newspaperx_howmany_blog_posts',
                            array(
	                            'sanitize_callback' => 'absint',
	                            'default'           => 4
                            )
);

/*
* Auto play carousel
*/
$wp_customize->add_setting( 'newspaperx_autoplay_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_checkbox'
	                            ),
	                            'default'           => 1,
                            )
);

/**
 * Show Title
 */
$wp_customize->add_setting( 'newspaperx_enable_related_title_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_checkbox'
	                            ),
	                            'default'           => 1
                            )
);

/**
 * Show Date
 */
$wp_customize->add_setting( 'newspaperx_enable_related_date_blog_posts',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_checkbox'
	                            ),
	                            'default'           => 0
                            )
);

/**
 * Author box
 */
$wp_customize->add_setting( 'newspaperx_enable_author_box',
                            array(
	                            'sanitize_callback' => array(
		                            'NewspaperX_Customizer_Helper',
		                            'newspaperx_sanitize_radio_buttons'
	                            ),
	                            'default'           => 'enabled'
                            )
);