<?php
/**
 * In case we don't have an image, we terminate here
 */
$banner_image = get_theme_mod( 'newspaper_x_banner_image', get_template_directory_uri() . '/assets/images/banner.png' );
$default      = get_template_directory_uri() . '/assets/images/banner.png';
$link         = get_theme_mod( 'newspaper_x_banner_link', 'https://colorlib.com/wp/forums/' );

/**
 * In case the user did not select an image ( default ), we fallback to the placeholder banner
 */
if ( $banner_image !== $default ) {
	$attachment_id = attachment_url_to_postid( get_theme_mod( 'newspaper_x_banner_image' ) ); ?>
    <a href="<?php echo esc_url( $link ) ?>">
		<?php echo wp_kses_post( wp_get_attachment_image( $attachment_id, 'newspaper-x-wide-banner' ) ); ?>
    </a>
<?php } else { ?>
    <a href="<?php echo esc_url( $link ) ?>">
		<?php
		echo '<img src="' . esc_url( $default ) . '" />';
		?>
    </a>
<?php }
