<?php
global $wp_customize;

/**
 * Enable top bar
 */
$wp_customize->add_control(
	'newspaperx_enable_top_bar',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'       => esc_html__( 'Enable or disable the top bar', 'newspaper-x' ),
		'description' => esc_html__( 'This will disable the topbar', 'newspaper-x' ),
		'section'     => 'newspaperx_general_section',
	)
);

/**
 * Enable top bar search
 */
$wp_customize->add_control(
	'newspaperx_enable_top_bar_search',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'       => esc_html__( 'Enable or disable the search from the top bar', 'newspaper-x' ),
		'description' => esc_html__( 'Enable or disable the search from the top bar', 'newspaper-x' ),
		'section'     => 'newspaperx_general_section',
	)
);

/**
 * Enable the news ticker
 */
$wp_customize->add_control(
	'newspaperx_enable_news_ticker',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'   => esc_html__( 'Enable or disable the news ticker', 'newspaper-x' ),
		'section' => 'newspaperx_general_section',
	)
);

/**
 * Enable breadcrumbs on single posts
 */
$wp_customize->add_control(
	'newspaperx_enable_post_breadcrumbs',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'breadcrumbs_enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'breadcrumbs_disabled' => esc_html__( 'Disabled', 'newspaper-x' )
		),
		'label'       => esc_html__( 'Breadcrumbs on single blog posts', 'newspaper-x' ),
		'description' => esc_html__( 'This will disable the breadcrumbs', 'newspaper-x' ),
		'section'     => 'newspaperx_general_section',
	)
);

/**
 *  Breadcrumbs separator
 */
$wp_customize->add_control(
	'newspaperx_blog_breadcrumb_menu_separator',
	array(
		'type'            => 'select',
		'choices'         => array(
			'/'         => esc_html( '/' ),
			'rarr'      => esc_html( '&rarr;' ),
			'middot'    => esc_html( '&middot;' ),
			'diez'      => esc_html( '&#35;' ),
			'ampersand' => esc_html( '&#38;' ),
		),
		'label'           => esc_html__( 'Separator to be used between breadcrumb items', 'newspaper-x' ),
		'section'         => 'newspaperx_general_section',
		'active_callback' => 'breadcrumbs_enabled_callback',
	)
);

/**
 *  Breadcrumbs post category
 */

$wp_customize->add_control(
	'newspaperx_blog_breadcrumb_menu_post_category',
	array(
		'type'            => 'checkbox',
		'label'           => esc_html__( 'Show post category ?', 'newspaper-x' ),
		'description'     => esc_html__( 'Show the post category in the breadcrumb ?', 'newspaper-x' ),
		'section'         => 'newspaperx_general_section',
		'active_callback' => 'breadcrumbs_enabled_callback',
	)
);

/**
 * Footer Column Count
 */
$wp_customize->add_control(
	'newspaperx_footer_columns',
	array(
		'type'        => 'radio',
		'choices'     => array(
			1 => esc_html__( 'One Column', 'newspaper-x' ),
			2 => esc_html__( 'Two Columns', 'newspaper-x' ),
			3 => esc_html__( 'Three Columns', 'newspaper-x' ),
			4 => esc_html__( 'Four Columns', 'newspaper-x' )
		),
		'label'       => esc_html__( 'Footer Columns', 'newspaper-x' ),
		'description' => esc_html__( 'Select how many columns should the footer display.', 'newspaper-x' ),
		'section'     => 'newspaperx_footer_section',
	)
);
/**
 * Copyright enable/disable
 */
$wp_customize->add_control(
	'newspaperx_enable_copyright',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' ),
		),
		'label'   => esc_html__( 'Enable copyright footer bar?', 'newspaper-x' ),
		'section' => 'newspaperx_footer_section',
	)
);
/**
 * Copyright content
 */
$wp_customize->add_control(
	'newspaperx_copyright_contents',
	array(
		'label'   => esc_html__( 'Copyright Text', 'newspaper-x' ),
		'section' => 'newspaperx_footer_section',
	)
);
/**
 * Enable / Disable Go top
 */
$wp_customize->add_control(
	'newspaperx_enable_go_top',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' ),
		),
		'label'   => esc_html__( 'Go Top Button', 'newspaper-x' ),
		'section' => 'newspaperx_footer_section',
	)
);

/**
 * Blog Settings
 *
 * Author box
 */
$wp_customize->add_control(
	'newspaperx_enable_author_box',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' ),
		),
		'label'   => esc_html__( 'Show author box below posts?', 'newspaper-x' ),
		'section' => 'newspaperx_blog_section',
	)
);

/*
 * Related Post Section
 */
$wp_customize->add_control(
	'newspaperx_related_posts_enabled',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'newspaper-x' ),
			'disabled' => esc_html__( 'Disabled', 'newspaper-x' ),
		),
		'label'   => esc_html__( 'Enable Related Posts Section', 'newspaper-x' ),
		'section' => 'newspaperx_blog_section',
	)
);

/**
 * Autoplay carousel
 */
$wp_customize->add_control(
	'newspaperx_autoplay_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Autoplay related carousel?', 'newspaper-x' ),
		'section' => 'newspaperx_blog_section',
	)
);

/**
 * Blog Post number
 */
$wp_customize->add_control( new NewspaperX_Controls_Slider_Control(
	                            $wp_customize,
	                            'newspaperx_howmany_blog_posts',
	                            array(
		                            'label'       => esc_html__( 'How many blog posts to display in the carousel at once?', 'newspaper-x' ),
		                            'description' => esc_html__( 'No more than 4 posts at once;', 'newspaper-x' ),
		                            'choices'     => array(
			                            'min'  => 1,
			                            'max'  => 4,
			                            'step' => 1,
		                            ),
		                            'section'     => 'newspaperx_blog_section',
		                            'default'     => 4
	                            )
                            )
);

/**
 * Show title
 */

$wp_customize->add_control(
	'newspaperx_enable_related_title_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Posts title in the carousel ?', 'newspaper-x' ),
		'section' => 'newspaperx_blog_section',
	)
);

/**
 * Show date
 */
$wp_customize->add_control(
	'newspaperx_enable_related_date_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Carousel related posts date?', 'newspaper-x' ),
		'section' => 'newspaperx_blog_section',
	)
);

/**
 * Active Callback for breadcrumb
 */
function breadcrumbs_enabled_callback( $control ) {
	if ( $control->manager->get_setting( 'newspaperx_enable_post_breadcrumbs' )->value() == 'breadcrumbs_enabled' ) {
		return true;
	}

	return false;

}