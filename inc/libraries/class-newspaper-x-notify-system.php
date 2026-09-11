<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Newspaper_X_Notify_System
 */
class Newspaper_X_Notify_System {
	/**
	 * Is a static page used as the front page?
	 *
	 * Previously inherited from Epsilon_Notify_System, which this class no longer
	 * extends.
	 *
	 * @return bool
	 */
	public static function is_not_static_page() {
		return 'page' === get_option( 'show_on_front' );
	}

	/**
	 * @return bool
	 */
	public static function has_widgets() {
		if ( is_active_sidebar( 'content-area' ) || is_active_sidebar( 'after-content-area' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public static function has_posts() {
		$has_posts = get_option('newspaper_x_importer_finished');

		return (bool) $has_posts;
	}

	/**
	 * @return bool
	 */
	public static function has_content() {
		$check = array(
			'widgets' => self::has_widgets(),
			'posts'   => self::has_posts(),
		);


		if ( $check['widgets'] && $check['posts'] ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public static function check_wordpress_importer() {
		if ( file_exists( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			return is_plugin_active( 'wordpress-importer/wordpress-importer.php' );
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public static function check_plugin_is_installed( $slug ) {
		/*
		 * WP_PLUGIN_DIR, not ABSPATH . 'wp-content/plugins/', which was hard-coded
		 * here and is wrong on any site that moves wp-content.
		 */
		return file_exists( WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php' );
	}

	/**
	 * @return bool
	 */
	public static function check_plugin_is_active( $slug ) {
		if ( ! self::check_plugin_is_installed( $slug ) ) {
			// Returned null implicitly before, which is not a boolean answer.
			return false;
		}

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( $slug . '/' . $slug . '.php' );
	}

	public static function has_import_plugin( $slug = NULL ) {
		$return = self::has_content();

		if ( $return ) {
			return true;
		}
		$check = array(
			'installed' => self::check_plugin_is_installed( $slug ),
			'active'    => self::check_plugin_is_active( $slug )
		);

		if ( ! $check['installed'] || ! $check['active'] ) {
			return false;
		}

		return true;
	}

	public static function has_import_plugins() {
		$check = array(
			'wordpress-importer'       => array( 'installed' => false, 'active' => false ),
			'widget-importer-exporter' => array( 'installed' => false, 'active' => false )
		);

		$content = self::has_content();
		$return  = false;
		if ( $content ) {
			return true;
		}

		$stop = false;
		foreach ( $check as $plugin => $val ) {
			if ( $stop ) {
				continue;
			}

			$check[ $plugin ]['installed'] = self::check_plugin_is_installed( $plugin );
			$check[ $plugin ]['active']    = self::check_plugin_is_active( $plugin );

			if ( ! $check[ $plugin ]['installed'] || ! $check[ $plugin ]['active'] ) {
				$return = true;
				$stop   = true;
			}

		}

		return $return;
	}

	public static function widget_importer_exporter_title() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Install: Widget Importer Exporter Plugin', 'newspaper-x' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Activate: Widget Importer Exporter Plugin', 'newspaper-x' );
		}

		return __( 'Install: Widget Importer Exporter Plugin', 'newspaper-x' );
	}

	public static function wordpress_importer_title() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Install: WordPress Importer', 'newspaper-x' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Activate: WordPress Importer', 'newspaper-x' );
		}

		return __( 'Install: WordPress Importer', 'newspaper-x' );
	}

	/**
	 * @return string
	 */
	public static function wordpress_importer_description() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress Importer to create the demo content.', 'newspaper-x' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Importer to create the demo content.', 'newspaper-x' );
		}

		return __( 'Please install the WordPress Importer to create the demo content.', 'newspaper-x' );
	}

	public static function widget_importer_exporter_description() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress widget importer to create the demo content', 'newspaper-x' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Widget Importer to create the demo content.', 'newspaper-x' );
		}

		return __( 'Please install the WordPress widget importer to create the demo content', 'newspaper-x' );

	}

	/**
	 * @return bool
	 */
	public static function is_not_template_front_page() {
		$page_id = get_option( 'page_on_front' );

		return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
	}
}
