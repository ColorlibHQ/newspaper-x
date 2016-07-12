<?php
/**
 * Changelog
 */

$newspaperx = wp_get_theme( 'newspaper-x' );

?>
<div class="newspaperx-tab-pane" id="changelog">

	<div class="newspaperx-tab-pane-center">
	
		<h1>Newspaper X <?php if( !empty($newspaperx['Version']) ): ?> <sup id="newspaperx-theme-version"><?php echo esc_attr( $newspaperx['Version'] ); ?> </sup><?php endif; ?></h1>

	</div>

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$newspaperx_changelog = $wp_filesystem->get_contents( get_template_directory().'/CHANGELOG.md' );
	$newspaperx_changelog_lines = explode(PHP_EOL, $newspaperx_changelog);
	foreach($newspaperx_changelog_lines as $newspaperx_changelog_line){
		if(substr( $newspaperx_changelog_line, 0, 3 ) === "###"){
			echo '<hr /><h1>'.substr($newspaperx_changelog_line,3).'</h1>';
		} else {
			echo $newspaperx_changelog_line,'<br/>';
		}
	}

	?>
	
</div>