<?php


if ( function_exists( 'register_sidebar' ) ) {
	if ( ! function_exists( 'newspaper_x_register_sidebars' ) ) {
		function newspaper_x_register_sidebars() {
			register_sidebar( array(
				                  'id'            => 'sidebar',
				                  'name'          => __( 'Content Sidebar', 'newspaper-x' ),
				                  'description'   => __( 'In blog archive, right side', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'content-area',
				                  'name'          => __( 'Content Widget Area', 'newspaper-x' ),
				                  'description'   => __( 'Actual page template content', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'after-content-sidebar',
				                  'name'          => __( 'Widget area before the footer', 'newspaper-x' ),
				                  'description'   => __( 'Full width area ( spans across the container )', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-1',
				                  'name'          => __( '[Footer] Sidebar #1', 'newspaper-x' ),
				                  'description'   => __( 'In the footer, first column', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-2',
				                  'name'          => __( '[Footer] Sidebar #2', 'newspaper-x' ),
				                  'description'   => __( 'In the footer, 2nd column', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-3',
				                  'name'          => __( '[Footer] Sidebar #3', 'newspaper-x' ),
				                  'description'   => __( 'In the footer, 3rd column', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-4',
				                  'name'          => __( '[Footer] Sidebar #4', 'newspaper-x' ),
				                  'description'   => __( 'In the footer, 4th column', 'newspaper-x' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

		} // function newspaper_x_register_sidebars end

		add_action( 'widgets_init', 'newspaper_x_register_sidebars' );

	} // function exists (newspaper_x_register_sidebars) check
} // function exists (register_sidebar) check
