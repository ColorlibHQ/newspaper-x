<?php
/**
 * Import Demo
 */
$button_text = __( 'Import Demo Data', 'bugle' );
?>

<div id="import_demo" class="bugle-tab-pane">

	<h1><?php esc_html_e( 'Demo Import.', 'bugle' ); ?></h1>

	<!-- NEWS -->

	<hr/>
	<?php
	$x = new MT_Theme_Importer();
	$x->demo_installer();
	?>
</div>
