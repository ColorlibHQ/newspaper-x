<?php
/**
 * Newspaper X functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newspaper_X
 */

if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}

/**
 * Start Newspaper_X theme framework
 */
require_once dirname( __FILE__ ) . '/inc/class-newspaper-x-autoloader.php';

$newspaper_x = new Newspaper_X();

require_once dirname( __FILE__ ) . '/inc/newspaper-x-deprecated.php';