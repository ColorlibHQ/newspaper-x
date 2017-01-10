<?php

if ( function_exists( 'register_sidebar' ) ) {
	if ( ! function_exists( 'newspaper_x_register_sidebars' ) ) {
		function newspaper_x_register_sidebars() {
			register_sidebar( array(
				                  'id'            => 'sidebar',
				                  'name'          => esc_html__( 'Blog Sidebar', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is the blog sidebar. If you\'ve set a posts page under Settings -> Reading, that\'s where your sidebar will be showing up', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3>',
				                  'after_title'   => '</h3>',
			                  ) );


			register_sidebar( array(
				                  'id'            => 'content-area',
				                  'name'          => esc_html__( 'Homepage - Content area', 'newspaper-x' ),
				                  'description'   => esc_html__( 'The sidebar holds the entire homepage content.', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'after-content-area',
				                  'name'          => esc_html__( 'Homepage - After Content area', 'newspaper-x' ),
				                  'description'   => esc_html__( 'The sidebar holds homepage content.', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-1',
				                  'name'          => esc_html__( 'Footer 1', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );

			register_sidebar( array(
				                  'id'            => 'footer-2',
				                  'name'          => esc_html__( 'Footer 2', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );

			register_sidebar( array(
				                  'id'            => 'footer-3',
				                  'name'          => esc_html__( 'Footer 3', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );

			register_sidebar( array(
				                  'id'            => 'footer-4',
				                  'name'          => esc_html__( 'Footer 4', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );

			register_sidebar( array(
				                  'id'            => 'after-footer',
				                  'name'          => esc_html__( 'After Footer', 'newspaper-x' ),
				                  'description'   => esc_html__( 'This is a footer sidebar.', 'newspaper-x' ),
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>',
				                  'before_title'  => '<h3 class="widget-title">',
				                  'after_title'   => '</h3>',
			                  ) );
		} // function newspaper_x_register_sidebars end

		add_action( 'widgets_init', 'newspaper_x_register_sidebars' );

	} // function exists (newspaper_x_register_sidebars) check
} // function exists (register_sidebar) check