<?php
/**
 * Actions required
 */

wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">

	<?php
	global $newspaper_x_required_actions;

	if ( ! empty( $newspaper_x_required_actions ) ):

		/* newspaper_x_show_required_actions is an array of true/false for each required action that was dismissed */
		$newspaper_x_show_required_actions = get_option( "newspaper_x_show_required_actions" );
		$hooray = true;

		foreach ( $newspaper_x_required_actions as $newspaper_x_required_action_key => $newspaper_x_required_action_value ):
			$hidden = false;
			if ( $newspaper_x_show_required_actions[ $newspaper_x_required_action_value['id'] ] === false ) {
				$hidden = true;
			}
			if ( $newspaper_x_required_action_value['check'] ) {
				continue;
			}
			?>
			<div class="newspaper-x-action-required-box">
				<?php if ( ! $hidden ): ?>
					<span data-action="dismiss"
					      class="dashicons dashicons-visibility newspaper-x-required-action-button"
					      id="<?php echo esc_attr( $newspaper_x_required_action_value['id'] ); ?>"></span>
				<?php else: ?>
					<span data-action="add" class="dashicons dashicons-hidden newspaper-x-required-action-button"
					      id="<?php echo esc_attr( $newspaper_x_required_action_value['id'] ); ?>"></span>
				<?php endif; ?>
				<h3><?php if ( ! empty( $newspaper_x_required_action_value['title'] ) ): echo esc_html( $newspaper_x_required_action_value['title'] ); endif; ?></h3>
				<p>
					<?php if ( ! empty( $newspaper_x_required_action_value['description'] ) ): echo esc_html( $newspaper_x_required_action_value['description'] ); endif; ?>
					<?php if ( ! empty( $newspaper_x_required_action_value['help'] ) ): echo '<br/>' . wp_kses_post( $newspaper_x_required_action_value['help'] ); endif; ?>
				</p>
				<?php
				if ( ! empty( $newspaper_x_required_action_value['plugin_slug'] ) ) {
					$active = $this->check_active( $newspaper_x_required_action_value['plugin_slug'] );
					$url    = $this->create_action_link( $active['needs'], $newspaper_x_required_action_value['plugin_slug'] );
					$label  = '';

					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = esc_html__( 'Install', 'newspaper-x' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = esc_html__( 'Activate', 'newspaper-x' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = esc_html__( 'Deactivate', 'newspaper-x' );
							break;
					}

					?>
					<p class="plugin-card-<?php echo esc_attr( $newspaper_x_required_action_value['plugin_slug'] ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
						<a data-slug="<?php echo esc_attr( $newspaper_x_required_action_value['plugin_slug'] ) ?>"
						   class="<?php echo esc_attr( $class ); ?>"
						   href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
					</p>
					<?php
				};
				?>
			</div>
			<?php
			$hooray = false;
		endforeach;
	endif;

	if ( $hooray ):
		echo '<span class="hooray">' . esc_html__( 'Hooray! There are no required actions for you right now.', 'newspaper-x' ) . '</span>';
	endif;
	?>

</div>
