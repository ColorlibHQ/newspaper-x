<?php
/**
 * Recommended Plugins
 */
global $newspaper_x_required_actions, $newspaper_x_recommended_plugins;
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section recommended-plugins three-col demo-import-boxed" id="plugin-filter">
	<?php foreach ( $newspaper_x_recommended_plugins as $plugin => $prop ) { ?>
		<?php
		$info   = $this->call_plugin_api( $plugin );
		$icon   = $this->check_for_icon( $info->icons );
		$active = $this->check_active( $plugin );
		$url    = $this->create_action_link( $active['needs'], $plugin );
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
		<div class="col plugin_box">
			<?php if ( $prop['recommended'] ): ?>
				<span class="recommended"><?php echo esc_html__( 'Recommended', 'newspaper-x' ); ?></span>
			<?php endif; ?>
			<img src="<?php echo esc_attr( $icon ) ?>" alt="plugin box image">
			<span class="version">
				<?php echo esc_html__( 'Version:', 'newspaper-x' ); ?><?php echo esc_html( $info->version ) ?>
			</span>
			<span class="separator">|</span>
				<?php echo wp_kses_post( $info->author ) ?>
			<div class="action_bar <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
				<span class="plugin_name">
					<?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'Active: ' : '' ?><?php echo esc_html( $info->name ); ?>
				</span>
			</div>
			<span
				class="plugin-card-<?php echo esc_attr( $plugin ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
				<a data-slug="<?php echo esc_attr( $plugin ) ?>" class="<?php echo esc_attr( $class ); ?>"
				   href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
			</span>
		</div>
	<?php } ?>
</div>