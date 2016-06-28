<?php
/**
 * In case we don't have an image, we terminate here
 */
$banner_image = get_theme_mod( 'bugle_banner_image', get_template_directory_uri() . '/images/banner.jpg' );
if ( empty( $banner_image ) ) {
	return false;
}

$link = get_theme_mod( 'bugle_banner_link', 'https://colorlib.com/wp/themes/ensign/' );

/**
 * In case the user did not select an image ( default ), we fallback to the placeholder banner
 */
if ( get_theme_mod( 'bugle_banner_image', get_template_directory_uri() . '/images/banner.jpg' ) !== get_template_directory_uri() . '/images/banner.jpg' ) {
	$attachment_id = bugle_get_attachment_id( get_theme_mod( 'bugle_banner_image' ) ); ?>
	<a href="<?php echo $link ?>">
		<?php echo wp_get_attachment_image( $attachment_id, 'bugle-wide-banner' ); ?>
	</a>
<?php } else { ?>
	<a href="<?php echo $link ?>">
		<?php
		echo '<img src="' . get_template_directory_uri() . '/images/banner.jpg' . '" />';
		?>
	</a>
<?php }
