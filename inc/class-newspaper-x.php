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
	 * Load Breadcrumbs
	 */
	public function init_breadcrumbs() {
		new Newspaper_X_Breadcrumbs();
	}

	/**
	 * Initiate the setting helper
	 */
	public function customize_register_init() {
		new Newspaper_X_Customizer();
	}

	/**
	 * Initiate epsilon framework
	 */
	public function init_epsilon() {
		$args = array(
			'controls' => array( 'slider', 'toggle' ),
			'sections' => array( 'recommended-actions' ),
			'path'     => '/inc/libraries'
		);

		new Epsilon_Framework( $args );
	}

	/**
	 * Initiate the welcome screen
	 */
	public function init_welcome_screen() {
		// Welcome screen
		if ( is_admin() ) {
			global $newspaper_x_required_actions, $newspaper_x_recommended_plugins;

			$newspaper_x_recommended_plugins = array(
        		'kali-forms'                       => array( 'recommended' => true ),
				'modula-best-grid-gallery'         => array( 'recommended' => true ),
				'fancybox-for-wordpress'           => array( 'recommended' => false ),
				'simple-custom-post-order'         => array( 'recommended' => false ),
				'colorlib-404-customizer'          => array( 'recommended' => false ),
				'colorlib-coming-soon-maintenance' => array( 'recommended' => false ),
				'colorlib-login-customizer'        => array( 'recommended' => false ),
				'kb-support'                       => array( 'recommended' => false ),
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
					"help"        => '<a target="_blank"  href="https://colorlibvault-divilabltd.netdna-ssl.com/newspaper-x-content.xml">' . __( 'Posts', 'newspaper-x' ) . '</a>,
									   <a target="_blank"  href="https://colorlibvault-divilabltd.netdna-ssl.com/newspaper-x-widgets.wie">' . __( 'Widgets', 'newspaper-x' ) . '</a>',
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
	}

	/**
	 * Register Scripts and Styles for the theme
	 */
	public function enqueues() {
		$theme = wp_get_theme();

		/**
		 * Load Google Fonts
		 */
		wp_enqueue_style( 'newspaper-x-fonts', '//fonts.googleapis.com/css?family=Droid+Serif:400,700|Nunito+Sans:300,400,700,900|Source+Sans+Pro:400,700', array(), $theme['Version'], 'all' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendors/fontawesome/font-awesome.min.css' );

		/**
		 * Load the bootstrap framework
		 */
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap-theme', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap-theme.min.css' );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/vendors/bootstrap/bootstrap.min.js', array( 'jquery' ), '', true );

		/**
		 * Theme styling
		 */
		wp_enqueue_style( 'newspaper-x-style', get_stylesheet_uri() );
		wp_enqueue_style( 'newspaper-x-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(), $theme['Version'] );


		$color = get_theme_mod( 'newspaper_x_header_bg', '#0E0E11' );

		if ( $color !== '#0E0E11' ) {
			$custom_css = "
                .newspaper-x-header-widget-area{
                    background: " . esc_html( $color ) . ";
                }";

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
		wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '', true );
		wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.carousel.min.css' );
		wp_enqueue_style( 'owl.carousel-theme', get_template_directory_uri() . '/assets/vendors/owl-carousel/owl.theme.default.css' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Admin enqueues
	 */
	public function admin_enqueues() {
		wp_enqueue_style( 'newspaper-x-fonts', 'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Poppins:400,500,600,700', array(), '', 'all' );
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

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
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