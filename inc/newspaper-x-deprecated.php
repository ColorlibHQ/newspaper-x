<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Due to the fact that we changed how this theme works,
 * we need to create a separate file to keep all the
 * deprecated functions
 */

/**
 * @todo - change newspaper_x posts navigation to default wordpress
 * @param array $args
 */

/**
 * @deprecated, please use Newspaper_X_Helper::posted_on(); instead
 */
function newspaper_x_posted_on( $element = 'default' ) {
	Newspaper_X_Helper::posted_on( $element );
}

/**
 * @deprecated, please use Newspaper_X_Helper::add_breadcrumbs(); instead
 */
function newspaper_x_breadcrumbs() {
	Newspaper_X_Helper::add_breadcrumbs();
}

/**
 * @param $url
 *
 * @return int
 * @deprecated, please use Newspaper_X_Helper::get_attachment_id(); instead;
 */
function newspaper_x_get_attachment_id( $url ) {
	return Newspaper_X_Helper::get_attachment_id( $url );
}

/**
 * @param string $format
 *
 * @deprecated, please use Newspaper_X_Helper::format_icon(); instead
 */
function newspaper_x_format_icon( $format = 'standard' ) {
	echo Newspaper_X_Helper::format_icon( $format );
}

/**
 * @return bool
 *
 * @deprecated, please use Newspaper_X_Helper::on_iis(); instead
 */
function newspaper_x_on_iis() {
	return Newspaper_X_Helper::on_iis();
}