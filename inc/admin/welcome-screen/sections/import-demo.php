<?php
/**
 * Import Demo
 */
$button_text = __( 'Import Demo Data', 'newspaper-x' );
?>

<div id="import_demo" class="newspaperx-tab-pane">

	<h1><?php esc_html_e( 'Demo Import.', 'newspaper-x' ); ?></h1>

	<!-- NEWS -->

	<hr/>
	<?php
	$x = new MT_Theme_Importer();
	$x->demo_installer();
	?>
</div>
