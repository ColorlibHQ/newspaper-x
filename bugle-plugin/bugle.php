<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Bugle
 *
 * @wordpress-plugin
 * Plugin Name:       Bugle Plugin
 * Plugin URI:        http://example.com/bugle-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Your Name or Your Company
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ensign
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bugle-activator.php
 */
function activate_bugle() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bugle-activator.php';
	Bugle_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bugle-deactivator.php
 */
function deactivate_bugle() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bugle-deactivator.php';
	Bugle_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bugle' );
register_deactivation_hook( __FILE__, 'deactivate_bugle' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bugle.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = Bugle::getInstance();
	$plugin->run();
	define('BUGLE_PLUGIN_VERSION', $plugin->get_version());
}
run_plugin_name();
