<?php
if ( ! function_exists( 'newspaper_x_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newspaper_x_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Newspaper X, use a find and replace
		 * to change 'newspaper-x' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'newspaper-x', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array() );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			                    'primary'    => esc_html__( 'Primary', 'newspaper-x' ),
			                    'top-header' => esc_html__( 'Top Header', 'newspaper-x' ),
			                    'social'     => esc_html__( 'Top Social', 'newspaper-x' ),
		                    ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Post Thumbs
		 */
		add_image_size( 'newspaper-x-single-post', 760, 490, true );
		add_image_size( 'newspaper-x-recent-post-big', 550, 360, true );
		add_image_size( 'newspaper-x-recent-post-list-image', 95, 65, true );

		/**
		 * Banners
		 */
		add_image_size( 'newspaper-x-wide-banner', 728, 90, true );
		add_image_size( 'newspaper-x-square-banner', 300, 250, true );
		add_image_size( 'newspaper-x-skyscraper-banner', 300, 600, true );

		add_filter( 'image_size_names_choose', 'newspaper_x_image_sizes' );
		function newspaper_x_image_sizes( $sizes ) {
			$addsizes = array(
				'newspaper-x-single-post' => __( 'Single Post Size', 'newspaper-x' ),
				'newspaper-x-wide-banner'       => __( 'Wide Banner', 'newspaper-x' ),
				'newspaper-x-square-banner'     => __( 'Square Banner', 'newspaper-x' ),
				'newspaper-x-skyscraper-banner' => __( 'Sky scraper Banner', 'newspaper-x' )
			);
			$newsizes = array_merge( $sizes, $addsizes );

			return $newsizes;
		}

		/**
		 * Add support for the custom logo functionality
		 */
		add_theme_support( 'custom-logo', array(
			'height'     => 90,
			'width'      => 300,
			'flex-width' => true,
		) );


		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'newspaper_x_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );

		// Welcome screen
		if ( is_admin() ) {
			global $newspaper_x_required_actions, $newspaper_x_recommended_plugins;

			$newspaper_x_recommended_plugins = array(
				'kiwi-social-share'           => array( 'recommended' => false ),
				'force-regenerate-thumbnails' => array( 'recommended' => true ),
				'wp-product-review'           => array( 'recommended' => false ),
				'pirate-forms'                => array( 'recommended' => false ),
				'visualizer'                  => array( 'recommended' => false )
			);

			/*
			 * id - unique id; required
			 * title
			 * description
			 * check - check for plugins (if installed)
			 * plugin_slug - the plugin's slug (used for installing the plugin)
			 *
			 */
			$newspaper_x_required_actions = array(
				array(
					"id"          => 'newspaper-x-req-ac-install-wp-import-plugin',
					"title"       => MT_Notify_System::wordpress_importer_title(),
					"description" => MT_Notify_System::wordpress_importer_description(),
					"check"       => MT_Notify_System::has_import_plugin( 'wordpress-importer' ),
					"plugin_slug" => 'wordpress-importer'
				),
				array(
					"id"          => 'newspaper-x-req-ac-install-wp-import-widget-plugin',
					"title"       => MT_Notify_System::widget_importer_exporter_title(),
					'description' => MT_Notify_System::widget_importer_exporter_description(),
					"check"       => MT_Notify_System::has_import_plugin( 'widget-importer-exporter' ),
					"plugin_slug" => 'widget-importer-exporter'
				),
				array(
					"id"          => 'newspaper-x-req-ac-download-data',
					"title"       => esc_html__( 'Download theme sample data', 'newspaper-x' ),
					"description" => esc_html__( 'Head over to our website and download the sample content data.', 'newspaper-x' ),
					"help"        => '<a target="_blank"  href="https://www.machothemes.com/sample-data/newspaper-x-pro-posts.xml">' . __( 'Posts', 'newspaper-x' ) . '</a>, 
									   <a target="_blank"  href="https://www.machothemes.com/sample-data/newspaper-x-pro-widgets.wie">' . __( 'Widgets', 'newspaper-x' ) . '</a>',
					"check"       => MT_Notify_System::has_content(),
				),
				array(
					"id"    => 'newspaper-x-req-ac-install-data',
					"title" => esc_html__( 'Import Sample Data', 'newspaper-x' ),
					"help"  => '<a class="button button-primary" target="_blank"  href="' . self_admin_url( 'admin.php?import=wordpress' ) . '">' . __( 'Import Posts', 'newspaper-x' ) . '</a> 
									   <a class="button button-primary" target="_blank"  href="' . self_admin_url( 'tools.php?page=widget-importer-exporter' ) . '">' . __( 'Import Widgets', 'newspaper-x' ) . '</a>',
					"check" => MT_Notify_System::has_import_plugins(),
				),
				array(
					"id"          => 'newspaper-x-req-ac-static-latest-news',
					"title"       => esc_html__( 'Set front page to static', 'newspaper-x' ),
					"description" => esc_html__( 'If you just installed Newspaper X, and are not able to see the front-page demo, you need to go to Settings -> Reading , Front page displays and select "Static Page".', 'newspaper-x' ),
					"help"        => 'If you need more help understanding how this works, check out the following <a target="_blank"  href="https://codex.wordpress.org/Creating_a_Static_Front_Page#WordPress_Static_Front_Page_Process">link</a>. <br/> <br/><a class="button button-secondary" target="_blank"  href="' . self_admin_url( 'options-reading.php' ) . '">' . __( 'Set manually', 'newspaper-x' ) . '</a> <a class="button button-primary"  href="' . wp_nonce_url( self_admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions&action=set_page_automatic' ), 'set_page_automatic' ) . '">' . __( 'Set automatically', 'newspaper-x' ) . '</a>',
					"check"       => MT_Notify_System::is_not_static_page()
				)
			);

			require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
		}
	}
endif;
add_action( 'after_setup_theme', 'newspaper_x_setup' );