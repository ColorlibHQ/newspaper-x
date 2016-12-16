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
					"id"          => 'newspaper-x-req-ac-static-latest-news',
					"title"       => esc_html__( 'Set front page to static', 'newspaper-x' ),
					"description" => esc_html__( 'If you just installed Newspaper X, head over to Settings -> Reading , Front page displays and select "Static Page". You can start building your homepage by adding theme\'s built-in widgets in the Content Area sidebars.', 'newspaper-x' ),
					"check"       => MT_Notify_System::is_not_static_page()
				)
			);

			require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
		}
	}
endif;
add_action( 'after_setup_theme', 'newspaper_x_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newspaper_x_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newspaper_x_content_width', 750 );
}
add_action( 'after_setup_theme', 'newspaper_x_content_width', 0 );