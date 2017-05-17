<?php

if ( ! class_exists( 'MT_Notify_System' ) ) {
	/**
	 * Class MT_Notify_System
	 */
	class MT_Notify_System {
		/**
		 * @param $ver
		 *
		 * @return mixed
		 */
		public static function version_check( $ver ) {
			$newspaper_x = wp_get_theme();

			return version_compare( $newspaper_x['Version'], $ver, '>=' );
		}

		/**
		 * @return bool
		 */
		public static function is_not_static_page() {
			return 'page' == get_option( 'show_on_front' ) ? true : false;
		}

		/**
		 * @return bool
		 */
		public static function has_widgets() {
			$widgets       = wp_get_sidebars_widgets();
			$banner_exists = false;

			if ( empty( $widgets['content-area'] ) ) {
				return false;
			}

			foreach ( $widgets['content-area'] as $widget ) {
				if ( preg_match( "/newspaper_x_banner-/", $widget ) ) {
					$banner_exists = true;
				}
			}

			if ( ! is_active_sidebar( 'homepage-slider' ) || ! $banner_exists ) {
				return false;
			}

			return true;
		}

		/**
		 * @return bool
		 */
		public static function has_posts() {
			$args  = array( "s" => 'Gary Johns: \'What is Aleppo\'' );
			$query = get_posts( $args );

			if ( ! empty( $query ) ) {
				return true;
			}

			return false;
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
				if ( ! function_exists( 'is_plugin_active' ) ) {
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				return is_plugin_active( 'wordpress-importer/wordpress-importer.php' );
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function check_plugin_is_installed( $slug ) {
			if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * @return bool
		 */
		public static function check_plugin_is_active( $slug ) {
			if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) ) {
				if ( ! function_exists( 'is_plugin_active' ) ) {
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				}

				return is_plugin_active( $slug . '/' . $slug . '.php' );
			}
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
				return esc_html__( 'Install: Widget Importer Exporter Plugin', 'newspaper-x' );
			}

			$active = self::check_plugin_is_active( 'widget-importer-exporter' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: Widget Importer Exporter Plugin', 'newspaper-x' );
			}

			return esc_html__( 'Install: Widget Importer Exporter Plugin', 'newspaper-x' );
		}

		public static function wordpress_importer_title() {
			$installed = self::check_plugin_is_installed( 'wordpress-importer' );
			if ( ! $installed ) {
				return esc_html__( 'Install: WordPress Importer', 'newspaper-x' );
			}

			$active = self::check_plugin_is_active( 'wordpress-importer' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Activate: WordPress Importer', 'newspaper-x' );
			}

			return esc_html__( 'Install: WordPress Importer', 'newspaper-x' );
		}


		/**
		 * @return string
		 */
		public static function wordpress_importer_description() {
			$installed = self::check_plugin_is_installed( 'wordpress-importer' );
			if ( ! $installed ) {
				return esc_html__( 'Please install the WordPress Importer to create the demo content.', 'newspaper-x' );
			}

			$active = self::check_plugin_is_active( 'wordpress-importer' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate the WordPress Importer to create the demo content.', 'newspaper-x' );
			}

			return esc_html__( 'Please install the WordPress Importer to create the demo content.', 'newspaper-x' );
		}

		public static function force_regenerate_thumbnails_description() {
			$installed = self::check_plugin_is_installed( 'force-regenerate-thumbnails' );
			if ( ! $installed ) {
				return esc_html__( 'Please install this plugin to regenerate your images using our custom image sizes.', 'newspaper-x' );
			}

			$active = self::check_plugin_is_active( 'force-regenerate-thumbnails' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate this plugin and regenerate your images using our custom image sizes.', 'newspaper-x' );
			}

			return esc_html__( 'Please install this plugin to regenerate your images using our custom image sizes.', 'newspaper-x' );

		}

		public static function widget_importer_exporter_description() {
			$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
			if ( ! $installed ) {
				return esc_html__( 'Please install the WordPress widget importer to create the demo content', 'newspaper-x' );
			}

			$active = self::check_plugin_is_active( 'widget-importer-exporter' );
			if ( $installed && ! $active ) {
				return esc_html__( 'Please activate the WordPress Widget Importer to create the demo content.', 'newspaper-x' );
			}

			return esc_html__( 'Please install the WordPress widget importer to create the demo content', 'newspaper-x' );

		}

		/**
		 * @return bool
		 */
		public static function is_not_template_front_page() {
			$page_id = get_option( 'page_on_front' );

			return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
		}
	}
}