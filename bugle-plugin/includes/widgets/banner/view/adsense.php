<?php
/**
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Bugle
 * @subpackage Bugle/includes
 */

// If the image is not set, terminate here
if ( empty( $params['image'] ) ) {
	return false;
}
?>

<div class="row">
	<div class="col-xs-12 bugle-adsense-banner">
		<?php echo $params['adsense_code'] ?>
	</div>
</div>
