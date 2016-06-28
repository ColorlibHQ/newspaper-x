<?php
global $wp_customize;

/**
 * Enable top bar
 */
$wp_customize->add_control(
	'bugle_enable_top_bar',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'       => esc_html__( 'Enable or disable the top bar', 'bugle' ),
		'description' => esc_html__( 'This will disable the topbar', 'bugle' ),
		'section'     => 'bugle_general_section',
	)
);

/**
 * Enable top bar search
 */
$wp_customize->add_control(
	'bugle_enable_top_bar_search',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'       => esc_html__( 'Enable or disable the search from the top bar', 'bugle' ),
		'description' => esc_html__( 'Enable or disable the search from the top bar', 'bugle' ),
		'section'     => 'bugle_general_section',
	)
);

/**
 * Enable the news ticker
 */
$wp_customize->add_control(
	'bugle_enable_news_ticker',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'       => esc_html__( 'Enable or disable the news ticker', 'bugle' ),
		'section'     => 'bugle_general_section',
	)
);

/**
 * Enable breadcrumbs on single posts
 */
$wp_customize->add_control(
	'bugle_enable_post_breadcrumbs',
	array(
		'type'        => 'radio',
		'choices'     => array(
			'breadcrumbs_enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'breadcrumbs_disabled' => esc_html__( 'Disabled', 'bugle' )
		),
		'label'       => esc_html__( 'Breadcrumbs on single blog posts', 'bugle' ),
		'description' => esc_html__( 'This will disable the breadcrumbs', 'bugle' ),
		'section'     => 'bugle_general_section',
	)
);

/**
 *  Breadcrumbs separator
 */
$wp_customize->add_control(
	'bugle_blog_breadcrumb_menu_separator',
	array(
		'type'    => 'select',
		'choices' => array(
			'/'         => esc_html( '/' ),
			'rarr'      => esc_html( '&rarr;' ),
			'middot'    => esc_html( '&middot;' ),
			'diez'      => esc_html( '&#35;' ),
			'ampersand' => esc_html( '&#38;' ),
		),
		'label'   => esc_html__( 'Separator to be used between breadcrumb items', 'bugle' ),
		'section' => 'bugle_general_section',
	)
);

/**
 *  Breadcrumbs post category
 */

$wp_customize->add_control(
	'bugle_blog_breadcrumb_menu_post_category',
	array(
		'type'        => 'checkbox',
		'label'       => esc_html__( 'Show post category ?', 'bugle' ),
		'description' => esc_html__( 'Show the post category in the breadcrumb ?', 'bugle' ),
		'section'     => 'bugle_general_section',
	)
);

/**
 * Footer Column Count
 */
$wp_customize->add_control(
	'bugle_footer_columns',
	array(
		'type'        => 'radio',
		'choices'     => array(
			1 => esc_html__( 'One Column', 'bugle' ),
			2 => esc_html__( 'Two Columns', 'bugle' ),
			3 => esc_html__( 'Three Columns', 'bugle' ),
			4 => esc_html__( 'Four Columns', 'bugle' )
		),
		'label'       => esc_html__( 'Footer Columns', 'bugle' ),
		'description' => esc_html__( 'Select how many columns should the footer display.', 'bugle' ),
		'section'     => 'bugle_footer_section',
	)
);
/**
 * Copyright enable/disable
 */
$wp_customize->add_control(
	'bugle_enable_copyright',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' ),
		),
		'label'   => esc_html__( 'Enable copyright?', 'bugle' ),
		'section' => 'bugle_footer_section',
	)
);
/**
 * Copyright content
 */
$wp_customize->add_control(
	'bugle_copyright_contents',
	array(
		'label'   => esc_html__( 'Copyright Text', 'bugle' ),
		'section' => 'bugle_footer_section',
	)
);
/**
 * Enable / Disable Go top
 */
$wp_customize->add_control(
	'bugle_enable_go_top',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' ),
		),
		'label'   => esc_html__( 'Go Top Button', 'bugle' ),
		'section' => 'bugle_footer_section',
	)
);

/**
 * Blog Settings
 *
 * Author box
 */
$wp_customize->add_control(
	'bugle_enable_author_box',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' ),
		),
		'label'   => esc_html__( 'Show author box below posts?', 'bugle' ),
		'section' => 'bugle_blog_section',
	)
);

/*
 * Related Post Section
 */
$wp_customize->add_control(
	'bugle_related_posts_enabled',
	array(
		'type'    => 'radio',
		'choices' => array(
			'enabled'  => esc_html__( 'Enabled', 'bugle' ),
			'disabled' => esc_html__( 'Disabled', 'bugle' ),
		),
		'label'   => esc_html__( 'Enable Related Posts Section', 'bugle' ),
		'section' => 'bugle_blog_section',
	)
);

/**
 * Autoplay carousel
 */
$wp_customize->add_control(
	'bugle_autoplay_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Autoplay related carousel?', 'bugle' ),
		'section' => 'bugle_blog_section',
	)
);

/**
 * Blog Post number
 */
$wp_customize->add_control( new Bugle_Controls_Slider_Control(
	                            $wp_customize,
	                            'bugle_howmany_blog_posts',
	                            array(
		                            'label'       => esc_html__( 'How many blog posts to display in the carousel at once?', 'bugle' ),
		                            'description' => esc_html__( 'No more than 4 posts at once;', 'bugle' ),
		                            'choices'     => array(
			                            'min'  => 1,
			                            'max'  => 4,
			                            'step' => 1,
		                            ),
		                            'section'     => 'bugle_blog_section',
		                            'default'     => 4
	                            )
                            )
);

/**
 * Show title
 */

$wp_customize->add_control(
	'bugle_enable_related_title_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Posts title in the carousel ?', 'bugle' ),
		'section' => 'bugle_blog_section',
	)
);

/**
 * Show date
 */
$wp_customize->add_control(
	'bugle_enable_related_date_blog_posts',
	array(
		'type'    => 'checkbox',
		'label'   => esc_html__( 'Carousel related posts date?', 'bugle' ),
		'section' => 'bugle_blog_section',
	)
);