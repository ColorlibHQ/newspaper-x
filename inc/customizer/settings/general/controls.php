<?php
global $wp_customize;

/**
 * Enable top bar
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_top_bar',
	                            array(
		                            'type'        => 'epsilon-toggle',
		                            'label'       => esc_html__( 'Top Bar Section', 'newspaper-x' ),
		                            'description' => esc_html__( 'Enable a top bar section', 'newspaper-x' ),
		                            'section'     => 'newspaper_x_general_section',
	                            )
                            )
);

/**
 * Enable top bar search
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_top_bar_search',
	                            array(
		                            'type'        => 'epsilon-toggle',
		                            'label'       => esc_html__( 'Search form', 'newspaper-x' ),
		                            'description' => esc_html__( 'Toggle the display of the search icon and functionality in the main navigation menu.', 'newspaper-x' ),
		                            'section'     => 'newspaper_x_general_section',
	                            )
                            )
);


/**
 * Enable the news ticker
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_news_ticker',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'News ticker', 'newspaper-x' ),
		                            'section' => 'newspaper_x_general_section',
	                            )
                            )
);

/**
 * Enable the header background image
 */
$wp_customize->add_control( new WP_Customize_Color_Control(
	                            $wp_customize,
	                            'newspaper_x_header_bg',
	                            array(
		                            'label'    => esc_html__( 'Header background', 'newspaper-x' ),
		                            'section'  => 'colors',
		                            'settings' => 'newspaper_x_header_bg'
	                            )
                            )
);

/**
 * Enable breadcrumbs on single posts
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_post_breadcrumbs',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'Breadcrumbs', 'newspaper-x' ),
		                            'section' => 'newspaper_x_blog_section',
	                            )
                            )
);
/**
 * Footer Column Count
 */
$wp_customize->add_control(
	'newspaper_x_footer_columns',
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
		'section'     => 'newspaper_x_footer_section',
	)
);
/**
 * Copyright enable/disable
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_copyright',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'Copyright footer bar', 'newspaper-x' ),
		                            'section' => 'newspaper_x_footer_section',
	                            )
                            )
);
/**
 * Copyright content
 */
$wp_customize->add_control(
	'newspaper_x_copyright_contents',
	array(
		'label'   => esc_html__( 'Copyright Text', 'newspaper-x' ),
		'section' => 'newspaper_x_footer_section',
	)
);
/**
 * Enable / Disable Go top
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_go_top',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'Go Top Button', 'newspaper-x' ),
		                            'section' => 'newspaper_x_footer_section',
	                            )
                            )
);

/**
 * Blog Settings
 *
 * Author box
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_author_box',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'Author info section', 'newspaper-x' ),
		                            'section' => 'newspaper_x_blog_section',
	                            )
                            )
);

/*
 * Related Post Section
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_related_posts_enabled',
	                            array(
		                            'type'    => 'epsilon-toggle',
		                            'label'   => esc_html__( 'Related Posts Section', 'newspaper-x' ),
		                            'section' => 'newspaper_x_blog_section',
	                            )
                            )
);

/**
 * Autoplay carousel
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_autoplay_blog_posts',
	                            array(
		                            'type'            => 'epsilon-toggle',
		                            'label'           => esc_html__( 'Autoplay related carousel', 'newspaper-x' ),
		                            'section'         => 'newspaper_x_blog_section',
		                            'active_callback' => 'newspaper_x_related_posts_enabled_callback',
	                            )
                            )
);
/**
 * Blog Post number
 */
$wp_customize->add_control( new Epsilon_Control_Slider(
	                            $wp_customize,
	                            'newspaper_x_howmany_blog_posts',
	                            array(
		                            'label'           => esc_html__( 'How many blog posts to display in the carousel at once?', 'newspaper-x' ),
		                            'description'     => esc_html__( 'No more than 4 posts at once;', 'newspaper-x' ),
		                            'choices'         => array(
			                            'min'  => 1,
			                            'max'  => 4,
			                            'step' => 1,
		                            ),
		                            'section'         => 'newspaper_x_blog_section',
		                            'default'         => 4,
		                            'active_callback' => 'newspaper_x_related_posts_enabled_callback',
	                            )
                            )
);

/**
 * Show title
 */

$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_related_title_blog_posts',
	                            array(
		                            'type'            => 'epsilon-toggle',
		                            'label'           => esc_html__( 'Posts title in the carousel', 'newspaper-x' ),
		                            'section'         => 'newspaper_x_blog_section',
		                            'active_callback' => 'newspaper_x_related_posts_enabled_callback',
	                            )
                            )
);

/**
 * Show date
 */
$wp_customize->add_control( new Epsilon_Control_Toggle(
	                            $wp_customize,
	                            'newspaper_x_enable_related_date_blog_posts',
	                            array(
		                            'type'            => 'epsilon-toggle',
		                            'label'           => esc_html__( 'Posts date in the carousel', 'newspaper-x' ),
		                            'section'         => 'newspaper_x_blog_section',
		                            'active_callback' => 'newspaper_x_related_posts_enabled_callback',
	                            )
                            )
);
/**
 * Active Callback for breadcrumb
 */
function newspaper_x_breadcrumbs_enabled_callback( $control ) {
	if ( $control->manager->get_setting( 'newspaper_x_enable_post_breadcrumbs' )->value() == 'breadcrumbs_enabled' ) {
		return true;
	}

	return false;
}

/**
 * Active Callback for copyright
 */
function newspaper_x_related_posts_enabled_callback( $control ) {
	if ( $control->manager->get_setting( 'newspaper_x_related_posts_enabled' )->value() == true ) {
		return true;
	}

	return false;
}
