<?php
/**
 * Newspaper X functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newspaper X
 */

if ( ! function_exists( 'newspaperx_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function newspaperx_setup() {
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
		add_image_size( 'newspaperx-single-post', 760, 490, true );
		add_image_size( 'newspaperx-recent-post-big', 550, 360, true );
		add_image_size( 'newspaperx-recent-post-list-image', 95, 65, true );

		/**
		 * Banners
		 */
		add_image_size( 'newspaperx-wide-banner', 728, 90, true );
		add_image_size( 'newspaperx-square-banner', 300, 250, true );
		add_image_size( 'newspaperx-skyscraper-banner', 300, 600, true );

		add_filter( 'image_size_names_choose', 'newspaperx_image_sizes' );
		function newspaperx_image_sizes( $sizes ) {
			$addsizes = array(
				'newspaperx-single-post' => __( 'Single Post Size', 'newspaper-x' ),
				'newspaperx-wide-banner'       => __( 'Wide Banner', 'newspaper-x' ),
				'newspaperx-square-banner'     => __( 'Square Banner', 'newspaper-x' ),
				'newspaperx-skyscraper-banner' => __( 'Sky scraper Banner', 'newspaper-x' )
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
		add_theme_support( 'custom-background', apply_filters( 'newspaperx_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Welcome screen
		if ( is_admin() ) {
			global $newspaperx_required_actions;
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

			$newspaperx_required_actions = array(
				array(
					"id"          => 'newspaperx-req-ac-static-latest-news',
					"title"       => esc_html__( 'Set front page to static', 'newspaper-x' ),
					"description" => esc_html__( 'If you just installed Newspaper X, and are not able to see the front-page demo, you need to go to Settings -> Reading , Front page displays and select "Static Page".', 'newspaper-x' ),
					"check"       => newspaperx_is_not_static_page()
				),

				array(
					"id"          => 'newspaperx-req-ac-frontpage-latest-news',
					"title"       => esc_html__( 'Change frontpage template', 'newspaper-x' ),
					"description" => esc_html__( 'Change the template of the Static Page to "Front Page Template".', 'newspaper-x' ),
					"check"       => newspaperx_is_not_template_front_page()
				),
				array(
					"id"          => 'newspaperx-req-ac-install-newspaperx-plugin',
					"title"       => esc_html__( 'Install Newspaper X Plugin', 'newspaper-x' ),
					"description" => esc_html__( 'Please install the plugin that comes bundled with the theme to have access to the template custom widgets and demo content importer.', 'newspaper-x' ),
					"check"       => defined( "ENSIGN_PLUGIN_VERSION" ),
					"plugin_slug" => 'newspaperx-plugin'
				),

				array(
					"id"          => 'newspaperx-req-ac-check-demo-content',
					"title"       => esc_html__( 'Check the demo content after installing Newspaper X Plugin', 'newspaper-x' ),
					"description" => esc_html__( "After installing Newspaper X Theme plugin, please make sure to import the demo content.", 'newspaper-x' ),
					"check"       => $imported,
				)

			);
			require get_template_directory() . '/inc/admin/welcome-screen/welcome-screen.php';
		}
	}
endif;
add_action( 'after_setup_theme', 'newspaperx_setup' );


/**
 * @param $sidebars_widgets
 *
 * @return mixed
 */
function newspaperx_disable_default_widgets( $sidebars_widgets ) {

	if ( is_array( $sidebars_widgets['before-content-area'] ) ) {
		foreach ( $sidebars_widgets['before-content-area'] as $i => $widget ) {
			unset( $sidebars_widgets['before-content-area'][ $i ] );
		}

	}

	return $sidebars_widgets;
}

/**
 * @return bool
 */
function newspaperx_is_not_static_page() {
	return 'page' == get_option( 'show_on_front' ) ? true : false;
}

/**
 * @return bool
 */
function newspaperx_is_not_template_front_page() {
	$page_id = get_option( 'page_on_front' );

	return get_page_template_slug( $page_id ) == 'page-templates/frontpage-template.php' ? true : false;
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function newspaperx_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'newspaperx_content_width', 1110 );
}

add_action( 'after_setup_theme', 'newspaperx_content_width', 0 );

add_filter( 'comment_form_defaults', 'newspaperx_comment_form_defaults' );
function newspaperx_comment_form_defaults( $defaults ) {

	$defaults['title_reply'] = __( '<span>Leave Comment</span>', 'newspaper-x' );
	return $defaults;

}

/**
 * Filter the categories widget to add a <span> element before the count
 *
 * @param $links
 *
 * @return mixed
 */
function newspaperx_add_span_cat_count( $links ) {
	$links = str_replace( '</a> (', '</a> <span class="newspaperx-cat-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );

	return $links;
}

add_filter( 'wp_list_categories', 'newspaperx_add_span_cat_count' );

function newspaperx_add_span_archive_count( $links ) {
	$links = str_replace( '</a>&nbsp;(', '</a> <span class="newspaperx-cat-count">(', $links );
	$links = str_replace( ')', ')</span>', $links );

	return $links;
}

add_filter( 'get_archives_link', 'newspaperx_add_span_archive_count' );

function newspaperx_remove_from_archive_title( $title ) {
	if ( is_category() ) {

		$title = single_cat_title( '', false );

	} elseif ( is_tag() ) {

		$title = single_tag_title( '', false );

	} elseif ( is_author() ) {

		$title = '<span class="vcard">' . get_the_author() . '</span>';

	}

	return $title;
}

add_filter( 'get_the_archive_title', 'newspaperx_remove_from_archive_title' );

function newspaperx_check_widget_text( $content ) {

	$content = preg_replace( "/<object/Si", '<div class="newspaperx-video-containe"><object', $content );
	$content = preg_replace( "/<\/object>/Si", '</object></div>', $content );

	/**
	 * Added iframe filtering, iframes are bad.
	 */
	$content = preg_replace( "/<iframe.+?src=\"(.+?)\"/Si", '<div class="newspaperx-video-containe"><iframe src="\1" frameborder="0" allowfullscreen>', $content );
	$content = preg_replace( "/<\/iframe>/Si", '</iframe></div>', $content );

	return $content;
}

add_filter( 'widget_text', 'newspaperx_check_widget_text' );

/**
 * Enqueue scripts and styles.
 */
function newspaperx_scripts() {
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
	wp_enqueue_script( 'newspaperx-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20151215', true );

	/**
	 * Theme styling
	 */
	wp_enqueue_style( 'newspaperx-style', get_stylesheet_uri() );

	/**
	 * Load menu script & skip-link-focus-fix
	 */
	wp_enqueue_script( 'newspaperx-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'newspaperx-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	/**
	 *Load the theme's core Javascript
	 */
	wp_enqueue_script( 'newspaperx-functions', get_template_directory_uri() . '/js/functions.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'newspaperx_scripts' );

function newspaperx_the_posts_navigation( $args = array() ) {
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
require get_template_directory() . '/inc/components/breadcrumbs/class-newspaperx-breadcrumbs.php';
require get_template_directory() . '/inc/components/related-posts/class-newspaperx-related-posts.php';
require get_template_directory() . '/inc/components/lazyload/class-newspaperx-lazyload.php';
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