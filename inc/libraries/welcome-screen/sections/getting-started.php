<?php
/**
 * Getting started template
 */
$customizer_url = admin_url() . 'customize.php';
$count = $this->count_actions();
?>

<div class="feature-section three-col has-3-columns is-fullwidth">
	<div class="col column">
		<h3><?php esc_html_e( 'Step 1 - Implement recommended actions', 'newspaper-x' ); ?></h3>
		<p><?php esc_html_e( 'We\'ve compiled a list of steps for you, to take make sure the experience you\'ll have using one of our products is very easy to follow.', 'newspaper-x' ); ?></p>
		<?php if ( $count == 0 ) { ?>
			<p><span class="dashicons dashicons-yes"></span>
				<a href="<?php echo admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions' ); ?>"><?php esc_html_e( 'No recommended actions left to perform', 'newspaper-x' ); ?></a>
			</p>
		<?php } else { ?>
			<p><span class="dashicons dashicons-no-alt"></span> <a href="<?php echo admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions' ); ?>"><?php esc_html_e( 'Check recommended actions', 'newspaper-x' ); ?></a>
			</p> <?php
		}; ?>
	</div><!--/.col-->

	<div class="col column">
		<h3><?php esc_html_e( 'Step 2 - Check our documentation', 'newspaper-x' ); ?></h3>
		<p><?php esc_html_e( 'Even if you\'re a long-time WordPress user, we still believe you should give our documentation a very quick Read.', 'newspaper-x' ) ?></p>
		<p>
			<a target="_blank"
			   href="<?php echo esc_url( 'https://colorlib.com/wp/forums/' ); ?>"><?php esc_html_e( 'Full documentation', 'newspaper-x' ); ?></a>
		</p>
	</div><!--/.col-->

	<div class="col column">
		<h3><?php esc_html_e( 'Step 3 - Customize everything', 'newspaper-x' ); ?></h3>
		<p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'newspaper-x' ); ?></p>
		<p><a target="_blank" href="<?php echo esc_url( $customizer_url ); ?>"
		      class="button button-primary"><?php esc_html_e( 'Go to Customizer', 'newspaper-x' ); ?></a>
		</p>
	</div><!--/.col-->
</div><!--/.feature-section-->