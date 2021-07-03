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

global $newspaper_x_required_actions, $newspaper_x_recommended_plugins;

$wp_customize->add_section(
	new Epsilon_Section_Recommended_Actions(
		$wp_customize,
		'epsilon_recommended_section',
		array(
			'title'                        => esc_html__( 'Recomended Actions', 'newspaper-x' ),
			'social_text'                  => esc_html__( 'We are social :', 'newspaper-x' ),
			'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'newspaper-x' ),
			'actions'                      => $newspaper_x_required_actions,
			'plugins'                      => $newspaper_x_recommended_plugins,
			'theme_specific_option'        => 'newspaper_x_show_required_actions',
			'theme_specific_plugin_option' => 'newspaper_x_show_required_plugins',
			'facebook'                     => 'https://www.facebook.com/colorlib',
			'twitter'                      => 'https://twitter.com/colorlib',
			'wp_review'                    => true,
			'theme_slug'                   => 'newspaper-x',
			'priority'                     => 0
		)
	)
);