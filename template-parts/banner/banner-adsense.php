<?php

$code = get_theme_mod( 'newspaper_x_banner_adsense_code', '' );

/**
 * In case we don't have an image, we terminate here
 */
if ( empty( $code ) ) {
	return false;
}

?>
<div class="newspaper-x-adsense">
	<?php
	echo htmlspecialchars_decode( $code );
	?>
	<p class="adsense__loading"><span><?php echo esc_html__( 'Loading', 'newspaper-x' ); ?></span></p>
</div>
