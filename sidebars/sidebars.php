<?php


if ( function_exists( 'register_sidebar' ) ) {
	if ( ! function_exists( 'bugle_register_sidebars' ) ) {
		function bugle_register_sidebars() {

			#
			#    Register sidebars
			#
			register_sidebar( array(
				                  'id'            => 'default-widget-area',
				                  'name'          => __( 'Default Widget Area', 'bugle' ),
				                  'description'   => __( 'Only seen on the normal post query', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'before-content-area',
				                  'name'          => __( 'Before Content Widget Area', 'bugle' ),
				                  'description'   => __( 'Actual page template content', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);
			register_sidebar( array(
				                  'id'            => 'content-area',
				                  'name'          => __( 'Content Widget Area', 'bugle' ),
				                  'description'   => __( 'Actual page template content', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'blog-sidebar',
				                  'name'          => __( 'Content Sidebar', 'bugle' ),
				                  'description'   => __( 'In blog archive, right side', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'after-content-sidebar',
				                  'name'          => __( 'Widget area before the footer', 'bugle' ),
				                  'description'   => __( 'Full width area ( spans across the container )', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'before-footer-sidebar-a',
				                  'name'          => __( 'Before Footer A', 'bugle' ),
				                  'description'   => __( 'Full width area ( spans across the container )', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'before-footer-sidebar-b',
				                  'name'          => __( 'Before Footer B', 'bugle' ),
				                  'description'   => __( 'Full width area ( spans across the container )', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-1',
				                  'name'          => __( '[Footer] Sidebar #1', 'bugle' ),
				                  'description'   => __( 'In the footer, first column', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-2',
				                  'name'          => __( '[Footer] Sidebar #2', 'bugle' ),
				                  'description'   => __( 'In the footer, 2nd column', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-3',
				                  'name'          => __( '[Footer] Sidebar #3', 'bugle' ),
				                  'description'   => __( 'In the footer, 3rd column', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

			register_sidebar( array(
				                  'id'            => 'footer-sidebar-4',
				                  'name'          => __( '[Footer] Sidebar #4', 'bugle' ),
				                  'description'   => __( 'In the footer, 4th column', 'bugle' ),
				                  'before_title'  => '<h3 class="widget-title"><span>',
				                  'after_title'   => '</span></h3>',
				                  'before_widget' => '<div id="%1$s" class="widget %2$s">',
				                  'after_widget'  => '</div>'
			                  )
			);

		} // function bugle_register_sidebars end

		add_action( 'widgets_init', 'bugle_register_sidebars' );

	} // function exists (bugle_register_sidebars) check
} // function exists (register_sidebar) check
