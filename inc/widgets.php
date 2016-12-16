<?php
/**
 * Load widgets
 */
function newspaper_x_widget_init() {

	$widget_path = get_template_directory() . '/inc/widgets';
	$dirs        = glob( $widget_path . '/*', GLOB_ONLYDIR );

	foreach ( $dirs as $dir ) {
		$dirname = basename( $dir );

		include_once( $dir . '/class-widget-newspaper-x-' . $dirname . '.php' );

		$widget_class = 'Widget_Newspaper_X_' . newspaper_x_dirname_to_classname( $dirname );
		if ( class_exists( $widget_class ) ) {
			register_widget( $widget_class );
		}

	}
}
add_action( 'widgets_init', 'newspaper_x_widget_init' );

function newspaper_x_dirname_to_classname( $dirname ) {
	$class_name = explode( '-', $dirname );
	$class_name = array_map( 'ucfirst', $class_name );
	$class_name = implode( '_', $class_name );

	return $class_name;
}
