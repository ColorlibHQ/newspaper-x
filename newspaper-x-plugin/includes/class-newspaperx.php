<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Newspaper X
 * @subpackage Newspaper X/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Newspaper X
 * @subpackage Newspaper X/includes
 * @author     Your Name <email@example.com>
 */
class NewspaperX {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      NewspaperX_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'newspaper-x';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_hooks();

	}

	/**
	 * Create and serve an instance of the plugin
	 * @return Newspaper X
	 */
	public static function getInstance() {
		static $inst;
		if (!$inst) {
			$inst = new NewspaperX;
		}

		return $inst;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - NewspaperX_Loader. Orchestrates the hooks of the plugin.
	 * - NewspaperX_i18n. Defines internationalization functionality.
	 * - NewspaperX_Admin. Defines all hooks for the admin area.
	 * - NewspaperX_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-newspaperx-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-newspaperx-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/importer/macho-importer.php';
		/**
		 * Helper
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-newspaperx-helper.php';
		$this->loader = new NewspaperX_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the NewspaperX_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new NewspaperX_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {
		$this->loader->add_action( 'widgets_init', $this, 'register_widgets' );
		/**
		 * Add new fields to the user profile
		 */
		$this->loader->add_filter( 'user_contactmethods', $this, 'register_new_user_profile_fields' );

		/**
		 * Load scripts for image uploader
		 */
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'upload_scripts' );
	}

	/**
	 * Upload the Javascripts for the media uploader
	 */
	public function upload_scripts() {
		global $pagenow, $wp_customize;

		if ( 'widgets.php' === $pagenow || isset( $wp_customize ) ) {
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );

			wp_enqueue_script( 'newspaperx-image-upload', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/upload-media.js', array( 'jquery' ) );
			wp_enqueue_style( 'newspaperx-image-upload', plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/upload-media.css' );
		}
	}

	public function register_new_user_profile_fields( $profile_fields ) {
		// Add new fields
		$profile_fields['twitter']     = 'Twitter URL';
		$profile_fields['facebook']    = 'Facebook URL';
		$profile_fields['google-plus'] = 'Google+ URL';
		$profile_fields['linkedin']    = 'LinkedIn URL';
		$profile_fields['dribbble']    = 'Dribbble URL';
		$profile_fields['github']      = 'GitHub URL';
		$profile_fields['pinterest']   = 'Pinterest URL';
		$profile_fields['tumblr']      = 'Tumblr URL';
		$profile_fields['youtube']     = 'YouTube URL';
		$profile_fields['flickr']      = 'FlickR URL';
		$profile_fields['vimeo']       = 'Vimeo URL';
		$profile_fields['instagram']   = 'Instagram URL';
		$profile_fields['codepen']     = 'Codepen URL';

		return $profile_fields;
	}

	public function register_widgets() {

		$widget_path = plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets';
		$dirs        = glob( $widget_path . '/*', GLOB_ONLYDIR );

		foreach ( $dirs as $dir ) {
			$dirname = basename( $dir );

			include_once( $dir . '/class-widget-newspaperx-' . $dirname . '.php' );

			$widget_class = 'Widget_NewspaperX_' . NewspaperX_Helper::dirname_to_classname( $dirname );
			if ( class_exists( $widget_class ) ) {
				register_widget( $widget_class );
			}

		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    NewspaperX_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
