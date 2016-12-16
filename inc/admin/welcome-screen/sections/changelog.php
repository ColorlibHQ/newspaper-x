<?php
/**
 * Changelog
 */

$newspaper_x = wp_get_theme( 'newspaper-x' );

?>
<div class="featured-section changelog">
	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$newspaper_x_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$newspaper_x_changelog_lines = explode( PHP_EOL, $newspaper_x_changelog );
	foreach ( $newspaper_x_changelog_lines as $newspaper_x_changelog_line ) {
		if ( substr( $newspaper_x_changelog_line, 0, 3 ) === "###" ) {
			echo '<h4>' . substr( esc_html( $newspaper_x_changelog_line ), 3 ) . '</h4>';
		} else {
			echo esc_html( $newspaper_x_changelog_line ), '<br/>';
		}


	}

	echo '<hr />';


	?>

</div>