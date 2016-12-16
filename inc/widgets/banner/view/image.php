<?php
/**
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Ensign
 * @subpackage Ensign/includes
 */

// If the image is not set, terminate here
if ( empty( $params['image_id'] ) ) {
	return false;
}
?>

<div class="newspaper-x-image-banner newspaper-x-margin-top">
	<?php echo ( ! empty( $params['image_url'] ) ) ? '<a href="' . esc_url_raw( $params['image_url'] ) . '">' : '' ?>
	<?php echo wp_get_attachment_image( $params['image_id'], false, false ); ?>
	<?php echo ( ! empty( $params['image_url'] ) ) ? '</a>' : '' ?>
</div>