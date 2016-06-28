<?php
/**
 * Bugle functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bugle
 */

if ( ! function_exists( 'bugle_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bugle_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Bugle, use a find and replace
		 * to change 'bugle' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bugle', get_template_directory() . '/languages' );

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
			                    'primary'    => esc_html__( 'Primary', 'bugle' ),
			                    'top-header' => esc_html__( 'Top Header', 'bugle' ),
			                    'social'     => esc_html__( 'Top Social', 'bugle' ),
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
		add_image_size( 'bugle-single-post', 760, 490, true );
		add_image_size( 'bugle-recent-post-big', 550, 360, true );
		add_image_size( 'bugle-recent-post-list-image', 95, 65, true );

		/**
		 * Banners
		 */
		add_image_size( 'bugle-wide-banner', 728, 90, true );
		add_image_size( 'bugle-square-banner', 300, 250, true );
		add_image_size( 'bugle-skyscraper-banner', 300, 600, true );

		add_filter( 'image_size_names_choose', 'bugle_image_sizes' );
		function bugle_image_sizes( $sizes ) {
			$addsizes = array(
				'bugle-single-post' => __( 'Single Post Size', 'bugle' ),
				'bugle-wide-banner'       => __( 'Wide Banner', 'bugle' ),
				'bugle-square-banner'     => __( 'Square Banner', 'bugle' ),
				'bugle-skyscraper-banner' => __( 'Sky scraper Banner', 'bugle' )
			);
			$newsizes = array_merge( $sizes, $addsizes );

			return $newsizes;
		}

		/**
		 * Add support for the custom logo functionality
		 */
		add_theme_support( 'custom-logo', array(
			'height'     => 45,
			'width'      => 285,
			'flex-width' => true,
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'bugle_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Welcome screen
		if ( is_admin() ) {
			global $bugle_required_actions;
			/*
			 * id - unique id; required
			 * title
			 * description
			 * check - check for plugins (if installed)
			 * plugin_slug - the plugin's slug (used for installing the plugin)
			 *
			 */
			$imported = get_option( 'mt_imported_demo' );

			if ( empty( $imported ) ) {
				$imported = false;
			} else {
				$imported = true;
			}

			$bugle_required_actions = array(

				array(
					"id"          => 'bugle-req-ac-install-bugle-plugin',
					"title"       => esc_html__( 'Install Bugle Plugin', 'bugle' ),
					"description" => esc_html__( 'Please install the plugin that comes bundled with the theme to have access to the template custom widgets and demo content importer.', 'bugle' ),
					"check"       => defined( "ENSIGN_PLUGIN_VERSION" ),
					"plugin_slug" => 'bugle-plugin'
				),

				array(
					"id"          => 'bugle-req-ac-check-demo-content',
					"title"       => esc_html__( 'Check the demo content after installing Bugle Plugin', 'bugle' ),
					"description" => esc_html__( "After installing Bugle Theme plugin, please make sure to import the demo content.", 'bugle' ),
					"check"       => $imported,
				)

			);
			require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
		}
	}
endif;
add_action( 'after_setup_theme', 'bugle_setup' );


/**
 * @param $sidebars_widgets
 *
 * @return mixed
 */
function bugle_disable_default_widgets( $sidebars_widgets ) {

	if ( is_array( $sidebars_widgets['before-content-area'] ) ) {
		foreach ( $sidebars_widgets['before-content-area'] as $i => $widget ) {
			unset( $sidebars_widgets['before-content-area'][ $i ] );
		}

	}

	return $sidebars_widgets;
}

if ( ! function_exists( 'bugle_is_not_latest_posts' ) ) {
	function bugle_is_not_static_page() {
		return ( 'page' == get_option( 'show_on_front' ) ? true : false );
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bugle_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bugle_content_width', 1110 );
}

add_action( 'after_setup_theme', 'bugle_content_width', 0 );

add_filter( 'comment_form_defaults', 'bugle_comment_form_defaults' );
function bugle_comment_form_defaults( $defaults ) {

	$defaults['title_reply'] = __( '<span>Leave Comment</span>' );
	return $defaults;

}

/**
 * Filter the categories widget to add a <span> element before the count
 *
 * @param $links
 *
 * @return mixed
 */
function bugle_add_span_cat_count( $links ) {
	$links = str_replace( '</a> (', '</a> <span class="bugle-cat-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );

	return $links;
}

add_filter( 'wp_list_categories', 'bugle_add_span_cat_count' );

function bugle_add_span_archive_count( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a> <span class="bugle-cat-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );

	return $links;
}

add_filter( 'get_archives_link', 'bugle_add_span_archive_count' );

function bugle_remove_from_archive_title( $title ) {
	if ( is_category() ) {

		$title = single_cat_title( '', false );

	} elseif ( is_tag() ) {

		$title = single_tag_title( '', false );

	} elseif ( is_author() ) {

		$title = '<span class="vcard">' . get_the_author() . '</span>';

	}

	return $title;
}

add_filter( 'get_the_archive_title', 'bugle_remove_from_archive_title' );

function bugle_check_widget_text( $content ) {

	$content = preg_replace( "/<object/Si", '<div class="bugle-video-containe"><object', $content );
	$content = preg_replace( "/<\/object>/Si", '</object></div>', $content );

	/**
	 * Added iframe filtering, iframes are bad.
	 */
	$content = preg_replace( "/<iframe.+?src=\"(.+?)\"/Si", '<div class="bugle-video-containe"><iframe src="\1" frameborder="0" allowfullscreen>', $content );
	$content = preg_replace( "/<\/iframe>/Si", '</iframe></div>', $content );

	return $content;
}

add_filter( 'widget_text', 'bugle_check_widget_text' );

/**
 * Enqueue scripts and styles.
 */
function bugle_scripts() {
	/**
	 * Load the fonts
	 */
	$ssl = is_ssl() ? 'https:' : 'http:';
	wp_enqueue_style( 'google-fonts', $ssl . '//fonts.googleapis.com/css?family=Droid+Serif:400,700|Oswald:300,400,600,700|Source+Sans+Pro:300,400,600,700"' );
	wp_enqueue_style( 'hind-style', $ssl . '//fonts.googleapis.com/css?family=Hind:400,300,500,600,700' );
	wp_enqueue_style( 'font-awesome-style', get_template_directory_uri() . '/css/font-awesome.min.css' );

	/**
	 * Load the bootstrap framework
	 */
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-theme-style', get_template_directory_uri() . '/css/bootstrap-theme.min.css' );
	wp_enqueue_script( 'bugle-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20151215', true );

	/**
	 * Theme styling
	 */
	wp_enqueue_style( 'bugle-style', get_stylesheet_uri() );

	/**
	 * Load menu script & skip-link-focus-fix
	 */
	wp_enqueue_script( 'bugle-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'bugle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	/**
	 *Load the theme's core Javascript
	 */
	wp_enqueue_script( 'bugle-functions', get_template_directory_uri() . '/js/functions.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'bugle_scripts' );

function bugle_the_posts_navigation( $args = array() ) {
	echo get_the_posts_navigation( $args );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
require get_template_directory() . '/inc/components/breadcrumbs/class-bugle-breadcrumbs.php';
require get_template_directory() . '/inc/components/related-posts/class-bugle-related-posts.php';
require get_template_directory() . '/inc/components/lazyload/class-bugle-lazyload.php';
/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Sidebars
 */
require get_template_directory() . '/sidebars/sidebars.php';