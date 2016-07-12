<?php
/**
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Newspaper X
 * @subpackage Newspaper X/includes
 */

// If the image is not set, terminate here
if ( empty( $params['image'] ) && empty( $params['image_url'] ) ) {
	return false;
}

if ( empty( $params['image'] ) ) {
	$params['image'] = plugin_dir_url( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) ) . 'assets/images/banner.jpg';
}
?>

<div class="row">
	<div class="col-xs-12 newspaperx-image-banner">
		<?php echo ( ! empty( $params['image_url'] ) ) ? '<a href="' . $params['image_url'] . '">' : '' ?>
		<img src="<?php echo $params['image'] ?>" />
		<?php echo ( ! empty( $params['image_url'] ) ) ? '</a>' : '' ?>
	</div>
</div>
