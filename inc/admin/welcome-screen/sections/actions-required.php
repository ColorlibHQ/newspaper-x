<?php
/**
 * Actions required
 */
?>

<div id="actions_required" class="newspaperx-tab-pane">

    <h1><?php esc_html_e( 'Actions recommend to make this theme look like in the demo.' ,'newspaper-x' ); ?></h1>

    <!-- NEWS -->
    <hr />

	<?php
	global $newspaperx_required_actions;

	if( !empty($newspaperx_required_actions) ):

		/* newspaperx_show_required_actions is an array of true/false for each required action that was dismissed */
		$newspaperx_show_required_actions = get_option("newspaperx_show_required_actions");

		foreach( $newspaperx_required_actions as $newspaperx_required_action_key => $newspaperx_required_action_value ):
			if(@$newspaperx_show_required_actions[$newspaperx_required_action_value['id']] === false) continue;
			if(@$newspaperx_required_action_value['check']) continue;
			?>
			<div class="newspaperx-action-required-box">
				<span class="dashicons dashicons-no-alt newspaperx-dismiss-required-action" id="<?php echo $newspaperx_required_action_value['id']; ?>"></span>
				<h4><?php echo $newspaperx_required_action_key + 1; ?>. <?php if( !empty($newspaperx_required_action_value['title']) ): echo $newspaperx_required_action_value['title']; endif; ?></h4>
				<p><?php if( !empty($newspaperx_required_action_value['description']) ): echo $newspaperx_required_action_value['description']; endif; ?></p>
				<?php
					if( !empty($newspaperx_required_action_value['plugin_slug']) ):
						?><p><a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.$newspaperx_required_action_value['plugin_slug'] ), 'install-plugin_'.$newspaperx_required_action_value['plugin_slug'] ) ); ?>" class="button button-primary"><?php if( !empty($newspaperx_required_action_value['title']) ): echo $newspaperx_required_action_value['title']; endif; ?></a></p><?php
					endif;
				?>

				<hr />
			</div>
			<?php
		endforeach;
	endif;

	$nr_actions_required = 0;

	/* get number of required actions */
	if( get_option('newspaperx_show_required_actions') ):
		$newspaperx_show_required_actions = get_option('newspaperx_show_required_actions');
	else:
		$newspaperx_show_required_actions = array();
	endif;

	if( !empty($newspaperx_required_actions) ):
		foreach( $newspaperx_required_actions as $newspaperx_required_action_value ):
			if(( !isset( $newspaperx_required_action_value['check'] ) || ( isset( $newspaperx_required_action_value['check'] ) && ( $newspaperx_required_action_value['check'] == false ) ) ) && ((isset($newspaperx_show_required_actions[$newspaperx_required_action_value['id']]) && ($newspaperx_show_required_actions[$newspaperx_required_action_value['id']] == true)) || !isset($newspaperx_show_required_actions[$newspaperx_required_action_value['id']]) )) :
				$nr_actions_required++;
			endif;
		endforeach;
	endif;

	if( $nr_actions_required == 0 ):
		echo '<p>'.__( 'Hooray! There are no required actions for you right now.','newspaper-x' ).'</p>';
	endif;
	?>

</div>
