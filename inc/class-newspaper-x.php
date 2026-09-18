<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Newspaper_X
 */
class Newspaper_X {
	/**
	 * Newspaper_X constructor.
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueues' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueues' ) );
		add_action( 'admin_init', array( $this, 'editor_enqueues' ) );
		/**
		 * Customizer enqueues & controls
		 */
		add_action( 'customize_register', array( $this, 'customize_register_init' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueues' ) );

		add_action( 'after_setup_theme', array( $this, 'content_width' ), 10 );
		/**
		 * Grab all class methods and initiate automatically
		 */
		$methods = get_class_methods( 'Newspaper_X' );

		foreach ( $methods as $method ) {
			if ( strpos( $method, 'init_' ) !== false ) {
				$this->$method();
			}
		}
	}

	/**
	 * Loads sidebars and widgets
	 */
	public function init_sidebars() {
		new Newspaper_X_Sidebars();
	}

	/**
	 * Load Hooks
	 */
	public function init_hooks() {
		new Newspaper_X_Hooks();
	}

	/**
	 * Load Lazyload
	 */
	public function init_lazyload() {
		new Newspaper_X_LazyLoad();
	}

	/**
	 * Initiate the setting helper
	 */
	public function customize_register_init() {
		new Newspaper_X_Customizer();
	}


	/**
	 * Styles for the theme's own Customizer controls.
	 *
	 * The on/off switch markup used to come from the bundled Epsilon framework,
	 * whose stylesheet was never actually enqueued -- the framework object was
	 * never constructed -- so the switches rendered as bare checkboxes. The rules
	 * live in the theme now and are loaded only on the Customizer controls screen.
	 */
	public function customize_controls_enqueues() {
		wp_enqueue_script(
			'newspaper-x-customizer-controls',
			get_template_directory_uri() . '/assets/js/customizer-controls.js',
			array(),
			wp_get_theme()->get( 'Version' ),
			true
		);

		wp_enqueue_style(
			'newspaper-x-customizer-controls',
			get_template_directory_uri() . '/assets/css/customizer.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}

	/**
	 * Initiate the welcome screen
	 */
	public function init_welcome_screen() {
		if ( ! is_admin() ) {
			return;
		}

		/*
		 * Deferred to init. The lists below are translated, and this runs while the
		 * theme's files are still being included -- before init, where WordPress 6.7
		 * and later warn that translations are being loaded too early. Every hook the
		 * welcome screen goes on to register (admin_menu, admin_init, admin_notices,
		 * admin_enqueue_scripts, load-themes.php, wp_ajax_*) fires after init, so
		 * nothing is missed by waiting.
		 */
		add_action( 'init', array( $this, 'register_welcome_screen' ) );
	}

	/**
	 * Builds the welcome screen's plugin and action lists, and starts it.
	 */
	public function register_welcome_screen() {
		global $newspaper_x_required_actions, $newspaper_x_recommended_plugins;

		$newspaper_x_recommended_plugins = array(
        		'kali-forms'                       => array( 'recommended' => true ),
			'modula-best-grid-gallery'         => array( 'recommended' => true ),
			'fancybox-for-wordpress'           => array( 'recommended' => false ),
			'simple-custom-post-order'         => array( 'recommended' => false ),
			'colorlib-404-customizer'          => array( 'recommended' => false ),
			'colorlib-coming-soon-maintenance' => array( 'recommended' => false ),
			'colorlib-login-customizer'        => array( 'recommended' => false ),
			'rsvp'                             => array( 'recommended' => false )
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
				"title"       => Newspaper_X_Notify_System::wordpress_importer_title(),
				"description" => Newspaper_X_Notify_System::wordpress_importer_description(),
				"check"       => Newspaper_X_Notify_System::has_import_plugin( 'wordpress-importer' ),
				"plugin_slug" => 'wordpress-importer'
			),
			array(
				"id"          => 'newspaper-x-req-ac-install-wp-import-widget-plugin',
				"title"       => Newspaper_X_Notify_System::widget_importer_exporter_title(),
				'description' => Newspaper_X_Notify_System::widget_importer_exporter_description(),
				"check"       => Newspaper_X_Notify_System::has_import_plugin( 'widget-importer-exporter' ),
				"plugin_slug" => 'widget-importer-exporter'
			),
			array(
				"id"          => 'newspaper-x-req-ac-download-data',
				"title"       => esc_html__( 'Download theme sample data', 'newspaper-x' ),
				"description" => esc_html__( 'Head over to our website and download the sample content data.', 'newspaper-x' ),
				"help"        => '<a target="_blank"  href="https://preview.colorlib.com/downloads/newspaper-x-content.xml">' . __( 'Posts', 'newspaper-x' ) . '</a>,
								   <a target="_blank"  href="https://preview.colorlib.com/downloads/newspaper-x-widgets.wie">' . __( 'Widgets', 'newspaper-x' ) . '</a>',
				"check"       => Newspaper_X_Notify_System::has_content(),
			),
			array(
				"id"    => 'newspaper-x-req-ac-install-data',
				"title" => esc_html__( 'Import Sample Data', 'newspaper-x' ),
				"help"  => '<a class="button button-primary" target="_blank"  href="' . self_admin_url( 'admin.php?import=wordpress' ) . '">' . __( 'Import Posts', 'newspaper-x' ) . '</a>
								   <a class="button button-primary" target="_blank"  href="' . self_admin_url( 'tools.php?page=widget-importer-exporter' ) . '">' . __( 'Import Widgets', 'newspaper-x' ) . '</a>',
				"check" => Newspaper_X_Notify_System::has_import_plugins(),
			),
			array(
				"id"          => 'newspaper-x-req-ac-static-latest-news',
				"title"       => esc_html__( 'Set front page to static', 'newspaper-x' ),
				"description" => esc_html__( 'If you just installed Newspaper X, and are not able to see the front-page demo, you need to go to Settings -> Reading , Front page displays and select "Static Page".', 'newspaper-x' ),
				"help"        => 'If you need more help understanding how this works, check out the following <a target="_blank"  href="https://codex.wordpress.org/Creating_a_Static_Front_Page#WordPress_Static_Front_Page_Process">link</a>. <br/><br/> <a class="button button-secondary" target="_blank"  href="' . esc_url( self_admin_url( 'options-reading.php' ) ) . '">' . __( 'Set manually', 'newspaper-x' ) . '</a> <a class="button button-primary"  href="' . wp_nonce_url( self_admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions&action=set_page_automatic' ), 'set_page_automatic' ) . '">' . __( 'Set automatically', 'newspaper-x' ) . '</a>',
				"check"       => Newspaper_X_Notify_System::is_not_static_page()
			)
		);

		new Newspaper_X_Welcome_Screen();
	}

	/**
	 * Register Scripts and Styles for the theme
	 */
	public function enqueues() {
		$theme = wp_get_theme();

		/**
		 * Load Google Fonts
		 */
		wp_enqueue_style( 'newspaper-x-fonts', get_template_directory_uri() . '/assets/css/google-fonts.css', array(), $theme['Version'], 'all' );

		/*
		 * Font Awesome 7, self-hosted and split by style: the core file carries the
		 * icon name map, each style file adds one @font-face. No v4 or v5 shim is
		 * loaded -- the theme's own markup and stylesheet use native Font Awesome 7
		 * names and families -- and only woff2 is shipped, which every browser that
		 * can run a current WordPress supports.
		 *
		 * The bundled copy is subsetted to the glyphs this theme renders, a few
		 * kilobytes rather than a few hundred. A site that uses Font Awesome classes
		 * in its own content -- a widget, a page builder, a child theme -- can load
		 * the complete set instead:
		 *
		 *     add_filter( 'newspaper_x_full_fontawesome', '__return_true' );
		 */
		$fa_uri = get_template_directory_uri() . '/assets/vendors/fontawesome/';

		if ( apply_filters( 'newspaper_x_full_fontawesome', false ) ) {
			wp_enqueue_style( 'newspaper-x-icons', $fa_uri . 'css/fontawesome.min.css', array(), '7.3.1' );
			wp_enqueue_style( 'newspaper-x-icons-solid', $fa_uri . 'css/solid.min.css', array( 'newspaper-x-icons' ), '7.3.1' );
			wp_enqueue_style( 'newspaper-x-icons-regular', $fa_uri . 'css/regular.min.css', array( 'newspaper-x-icons' ), '7.3.1' );
			wp_enqueue_style( 'newspaper-x-icons-brands', $fa_uri . 'css/brands.min.css', array( 'newspaper-x-icons' ), '7.3.1' );
		} else {
			wp_enqueue_style( 'newspaper-x-icons', $fa_uri . 'subset/fontawesome-subset.min.css', array(), '7.3.1' );
		}

		/**
		 * Load the bootstrap framework
		 */
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.css', array(), '3.4.1' );

		/**
		 * Theme styling
		 */
		wp_enqueue_style( 'newspaper-x-style', get_stylesheet_uri() );
		wp_enqueue_style( 'newspaper-x-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(), $theme['Version'] );


		/*
		 * Re-validate at output. The Customizer sanitises this on the way in,
		 * but a value stored by an older version, a plugin calling
		 * set_theme_mod(), or a direct database write would otherwise be
		 * printed into a <style> block as-is -- and esc_html() leaves ';' and
		 * '{' alone, so it does not stop a rule being injected there.
		 */
		$color = sanitize_hex_color( get_theme_mod( 'newspaper_x_header_bg', '#0E0E11' ) );

		if ( $color && '#0E0E11' !== $color ) {
			$custom_css = '
                .newspaper-x-header-widget-area{
                    background: ' . $color . ';
                }';

			wp_add_inline_style( 'newspaper-x-stylesheet', $custom_css );
		}
		/**
		 * Load menu script & skip-link-focus-fix
		 */
		wp_enqueue_script( 'newspaper-x-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '', true );
		wp_enqueue_script( 'newspaper-x-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '', true );

		/**
		 * Adsense loader
		 */
		wp_enqueue_script( 'adsense-loader', get_template_directory_uri() . '/assets/vendors/adsenseloader/jquery.adsenseloader.js', array( 'jquery' ), '', true );

		/**
		 *Load the theme's core Javascript
		 */
		wp_enqueue_script( 'machothemes-object', get_template_directory_uri() . '/assets/vendors/machothemes/machothemes.min.js', array(), '', true );
		wp_enqueue_script( 'newspaper-x-functions', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), '', true );
		wp_localize_script( 'newspaper-x-functions', 'WPUrls', array(
			'siteurl' => esc_url( get_option( 'siteurl' ) ),
			'theme'   => esc_url( get_template_directory_uri() ),
			'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) )
		) );

		/**
		 * OwlCarousel Library
		 */
		wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
		wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.css', array(), '2.3.4' );
		wp_enqueue_style( 'owl.carousel-theme', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.theme.default.css', array( 'owl.carousel' ), '2.3.4' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Admin enqueues
	 */
	public function admin_enqueues( $hook_suffix = '' ) {
		wp_enqueue_style( 'newspaper-x-fonts', get_template_directory_uri() . '/assets/css/google-fonts.css', array(), '', 'all' );
		wp_enqueue_style( 'newspaper-x-admin.stylesheet', get_template_directory_uri() . '/assets/css/admin.style.css', array(), '' );

		// The post widgets' forms carry range sliders with a live readout.
		if ( 'widgets.php' === $hook_suffix ) {
			wp_enqueue_script(
				'newspaper-x-customizer-controls',
				get_template_directory_uri() . '/assets/js/customizer-controls.js',
				array(),
				wp_get_theme()->get( 'Version' ),
				true
			);
		}
	}

	/**
	 * Editor styles
	 */
	public function editor_enqueues() {
		add_editor_style( 'assets/css/custom-editor-style.css' );
	}

	/**
	 * Newspaper X Theme Setup
	 */
	public function theme_setup() {
		load_theme_textdomain( 'newspaper-x', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );


		add_theme_support( 'title-tag' );
		register_nav_menus(
			array(
				'primary'     => esc_html__( 'Primary', 'newspaper-x' ),
				'footer-menu' => esc_html__( 'Footer', 'newspaper-x' ),
				'social'      => esc_html__( 'Top Social', 'newspaper-x' ),
			)
		);

		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );


		add_theme_support( 'post-thumbnails' );

		add_image_size( 'newspaper-x-single-post', 760, 490, true );
		add_image_size( 'newspaper-x-recent-post-big', 550, 360, true );
		add_image_size( 'newspaper-x-recent-post-list-image', 95, 65, true );

		add_theme_support( 'custom-logo', array(
			'height'     => 90,
			'width'      => 300,
			'flex-width' => true,
		) );

		add_theme_support( 'custom-background', apply_filters( 'newspaper_x_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => array( 'Newspaper_X_Helper', 'infinite_scroll_render' ),
			'footer'    => 'page',
		) );

		/*
		 * Block editor. The theme's own stylesheet already sets the content
		 * width, so wide and full-width blocks have somewhere to go.
		 */
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'wp-block-styles' );
	}

	/**
	 * Content width
	 */
	public function content_width() {
		if ( ! isset( $GLOBALS['content_width'] ) ) {
			$GLOBALS['content_width'] = 750;
		}
	}
}