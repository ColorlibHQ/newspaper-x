<?php
/**
 * Changelog
 */

$ensign = wp_get_theme( 'bugle' );

?>
<div class="bugle-tab-pane" id="changelog">

	<div class="bugle-tab-pane-center">
	
		<h1>Bugle <?php if( !empty($ensign['Version']) ): ?> <sup id="bugle-theme-version"><?php echo esc_attr( $ensign['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$bugle_changelog = $wp_filesystem->get_contents( get_template_directory().'/CHANGELOG.md' );
	$bugle_changelog_lines = explode(PHP_EOL, $bugle_changelog);
	foreach($bugle_changelog_lines as $bugle_changelog_line){
		if(substr( $bugle_changelog_line, 0, 3 ) === "###"){
			echo '<hr /><h1>'.substr($bugle_changelog_line,3).'</h1>';
		} else {
			echo $bugle_changelog_line,'<br/>';
		}
	}

	?>
	
</div>