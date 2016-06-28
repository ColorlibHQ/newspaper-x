<?php
/**
 * Actions required
 */
?>

<div id="actions_required" class="bugle-tab-pane">

    <h1><?php esc_html_e( 'Actions recommend to make this theme look like in the demo.' ,'bugle' ); ?></h1>

    <!-- NEWS -->
    <hr />

	<?php
	global $bugle_required_actions;

	if( !empty($bugle_required_actions) ):

		/* bugle_show_required_actions is an array of true/false for each required action that was dismissed */
		$bugle_show_required_actions = get_option("bugle_show_required_actions");

		foreach( $bugle_required_actions as $bugle_required_action_key => $bugle_required_action_value ):
			if(@$bugle_show_required_actions[$bugle_required_action_value['id']] === false) continue;
			if(@$bugle_required_action_value['check']) continue;
			?>
			<div class="bugle-action-required-box">
				<span class="dashicons dashicons-no-alt bugle-dismiss-required-action" id="<?php echo $bugle_required_action_value['id']; ?>"></span>
				<h4><?php echo $bugle_required_action_key + 1; ?>. <?php if( !empty($bugle_required_action_value['title']) ): echo $bugle_required_action_value['title']; endif; ?></h4>
				<p><?php if( !empty($bugle_required_action_value['description']) ): echo $bugle_required_action_value['description']; endif; ?></p>
				<?php
					if( !empty($bugle_required_action_value['plugin_slug']) ):
						?><p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.$bugle_required_action_value['plugin_slug'] ), 'install-plugin_'.$bugle_required_action_value['plugin_slug'] ) ); ?>" class="button button-primary"><?php if( !empty($bugle_required_action_value['title']) ): echo $bugle_required_action_value['title']; endif; ?></a></p><?php
					endif;
				?>

				<hr />
			</div>
			<?php
		endforeach;
	endif;

	$nr_actions_required = 0;

	/* get number of required actions */
	if( get_option('bugle_show_required_actions') ):
		$bugle_show_required_actions = get_option('bugle_show_required_actions');
	else:
		$bugle_show_required_actions = array();
	endif;

	if( !empty($bugle_required_actions) ):
		foreach( $bugle_required_actions as $bugle_required_action_value ):
			if(( !isset( $bugle_required_action_value['check'] ) || ( isset( $bugle_required_action_value['check'] ) && ( $bugle_required_action_value['check'] == false ) ) ) && ((isset($bugle_show_required_actions[$bugle_required_action_value['id']]) && ($bugle_show_required_actions[$bugle_required_action_value['id']] == true)) || !isset($bugle_show_required_actions[$bugle_required_action_value['id']]) )) :
				$nr_actions_required++;
			endif;
		endforeach;
	endif;

	if( $nr_actions_required == 0 ):
		echo '<p>'.__( 'Hooray! There are no required actions for you right now.','bugle' ).'</p>';
	endif;
	?>

</div>
