<?php
// If the image is not set, terminate here
if ( empty( $params['image_id'] ) ) {
	return false;
}
?>

<div class="newspaper-x-image-banner">
	<?php echo ( ! empty( $params['image_url'] ) ) ? '<a href="' . esc_url( $params['image_url'] ) . '">' : '' ?>
	<?php echo wp_get_attachment_image( $params['image_id'], false, false ); ?>
	<?php echo ( ! empty( $params['image_url'] ) ) ? '</a>' : '' ?>
</div>