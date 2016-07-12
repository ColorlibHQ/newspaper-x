<?php

/**
 * Welcome Screen Class
 */
class NewspaperX_Welcome {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {
		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'newspaperx_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'newspaperx_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'newspaperx_welcome_style_and_scripts' ) );

		/* enqueue script for customizer */
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'newspaperx_welcome_scripts_for_customizer' ) );

		/* load welcome screen */
		add_action( 'newspaperx_welcome', array( $this, 'newspaperx_welcome_getting_started' ), 10 );
		add_action( 'newspaperx_welcome', array( $this, 'newspaperx_welcome_actions_required' ), 20 );

		if ( class_exists( 'MT_Theme_Importer' ) ) {
			add_action( 'newspaperx_welcome', array( $this, 'newspaperx_welcome_import_demo' ), 30 );
		}

		add_action( 'newspaperx_welcome', array( $this, 'newspaperx_welcome_changelog' ), 50 );


		/* ajax callback for dismissable required actions */
		add_action( 'wp_ajax_newspaperx_dismiss_required_action', array(
			$this,
			'newspaperx_dismiss_required_action_callback'
		) );
		add_action( 'wp_ajax_nopriv_newspaperx_dismiss_required_action', array(
			$this,
			'newspaperx_dismiss_required_action_callback'
		) );

	}

	/**
	 * Creates the dashboard page
	 *
	 * @see   add_theme_page()
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_register_menu() {
		add_theme_page( 'About Newspaper X', 'About Newspaper X', 'edit_theme_options', 'newspaperx-welcome', array(
			$this,
			'newspaperx_welcome_screen'
		) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'newspaperx_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_admin_notice() {
		?>
		<div class="updated notice is-dismissible">
			<p><?php echo sprintf( esc_html__( 'Welcome! Thank you for choosing Newspaper X! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'newspaper-x' ), '<a href="' . esc_url( admin_url( 'themes.php?page=newspaperx-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaperx-welcome' ) ); ?>" class="button"
			      style="text-decoration: none;"><?php _e( 'Get started with Newspaper X', 'newspaper-x' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 *
	 * @since  1.8.2.4
	 */
	public function newspaperx_welcome_style_and_scripts( $hook_suffix ) {

		if ( 'appearance_page_newspaperx-welcome' == $hook_suffix ) {
			wp_enqueue_style( 'newspaperx-welcome-screen-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome.css' );
			wp_enqueue_script( 'newspaperx-welcome-screen-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome.js', array( 'jquery' ) );

			global $newspaperx_required_actions;

			$nr_actions_required = 0;

			/* get number of required actions */
			if ( get_option( 'newspaperx_show_required_actions' ) ):
				$newspaperx_show_required_actions = get_option( 'newspaperx_show_required_actions' );
			else:
				$newspaperx_show_required_actions = array();
			endif;

			if ( ! empty( $newspaperx_required_actions ) ):
				foreach ( $newspaperx_required_actions as $newspaperx_required_action_value ):
					if ( ( ! isset( $newspaperx_required_action_value['check'] ) || ( isset( $newspaperx_required_action_value['check'] ) && ( $newspaperx_required_action_value['check'] == false ) ) ) && ( ( isset( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] ) && ( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] == true ) ) || ! isset( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] ) ) ) :
						$nr_actions_required ++;
					endif;
				endforeach;
			endif;

			wp_localize_script( 'newspaperx-welcome-screen-js', 'newspaperxWelcomeScreenObject', array(
				'nr_actions_required'      => $nr_actions_required,
				'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
				'template_directory'       => get_template_directory_uri(),
				'no_required_actions_text' => __( 'Hooray! There are no required actions for you right now.', 'newspaper-x' )
			) );
		}
	}

	/**
	 * Load scripts for customizer page
	 *
	 * @since  1.8.2.4
	 */
	public function newspaperx_welcome_scripts_for_customizer() {

		wp_enqueue_style( 'newspaperx-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/admin/welcome-screen/css/welcome_customizer.css' );
		wp_enqueue_script( 'newspaperx-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/admin/welcome-screen/js/welcome_customizer.js', array( 'jquery' ), '20120206', true );

		global $newspaperx_required_actions;

		$nr_actions_required = 0;

		/* get number of required actions */
		if ( get_option( 'newspaperx_show_required_actions' ) ):
			$newspaperx_show_required_actions = get_option( 'newspaperx_show_required_actions' );
		else:
			$newspaperx_show_required_actions = array();
		endif;

		if ( ! empty( $newspaperx_required_actions ) ):
			foreach ( $newspaperx_required_actions as $newspaperx_required_action_value ):
				if ( ( ! isset( $newspaperx_required_action_value['check'] ) || ( isset( $newspaperx_required_action_value['check'] ) && ( $newspaperx_required_action_value['check'] == false ) ) ) && ( ( isset( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] ) && ( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] == true ) ) || ! isset( $newspaperx_show_required_actions[ $newspaperx_required_action_value['id'] ] ) ) ) :
					$nr_actions_required ++;
				endif;
			endforeach;
		endif;

		wp_localize_script( 'newspaperx-welcome-screen-customizer-js', 'newspaperxWelcomeScreenCustomizerObject', array(
			'nr_actions_required' => $nr_actions_required,
			'aboutpage'           => esc_url( admin_url( 'themes.php?page=newspaperx-welcome#actions_required' ) ),
			'customizerpage'      => esc_url( admin_url( 'customize.php#actions_required' ) ),
			'themeinfo'           => __( 'View Theme Info', 'newspaper-x' ),
		) );
	}

	/**
	 * Dismiss required actions
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_dismiss_required_action_callback() {

		global $newspaperx_required_actions;

		$newspaperx_dismiss_id = ( isset( $_GET['dismiss_id'] ) ) ? $_GET['dismiss_id'] : 0;

		echo $newspaperx_dismiss_id; /* this is needed and it's the id of the dismissable required action */

		if ( ! empty( $newspaperx_dismiss_id ) ):

			/* if the option exists, update the record for the specified id */
			if ( get_option( 'newspaperx_show_required_actions' ) ):

				$newspaperx_show_required_actions = get_option( 'newspaperx_show_required_actions' );

				$newspaperx_show_required_actions[ $newspaperx_dismiss_id ] = false;

				update_option( 'newspaperx_show_required_actions', $newspaperx_show_required_actions );

			/* create the new option,with false for the specified id */
			else:

				$newspaperx_show_required_actions_new = array();

				if ( ! empty( $newspaperx_required_actions ) ):

					foreach ( $newspaperx_required_actions as $newspaperx_required_action ):

						if ( $newspaperx_required_action['id'] == $newspaperx_dismiss_id ):
							$newspaperx_show_required_actions_new[ $newspaperx_required_action['id'] ] = false;
						else:
							$newspaperx_show_required_actions_new[ $newspaperx_required_action['id'] ] = true;
						endif;

					endforeach;

					update_option( 'newspaperx_show_required_actions', $newspaperx_show_required_actions_new );

				endif;

			endif;

		endif;

		die(); // this is required to return a proper result
	}


	/**
	 * Welcome screen content
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_screen() {

		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );
		?>

		<ul class="newspaperx-nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#getting_started" aria-controls="getting_started" role="tab"
			                                          data-toggle="tab"><?php esc_html_e( 'Getting started', 'newspaper-x' ); ?></a>
			</li>
			<li role="presentation" class="newspaperx-w-red-tab"><a href="#actions_required"
			                                                    aria-controls="actions_required" role="tab"
			                                                    data-toggle="tab"><?php esc_html_e( 'Actions required', 'newspaper-x' ); ?></a>
			</li>
			<?php if ( class_exists( 'MT_Theme_Importer' ) ) { ?>
				<li role="presentation"><a href="#import_demo" aria-controls="import_demo" role="tab"
				                           data-toggle="tab"><?php esc_html_e( 'Import Demo', 'newspaper-x' ); ?></a></li>
			<?php } ?>
			<li role="presentation"><a href="#changelog" aria-controls="changelog" role="tab"
			                           data-toggle="tab"><?php esc_html_e( 'Changelog', 'newspaper-x' ); ?></a></li>
		</ul>

		<div class="newspaperx-tab-content">

			<?php
			/**
			 * @hooked newspaperx_welcome_getting_started - 10
			 * @hooked newspaperx_welcome_actions_required - 20
			 * @hooked newspaperx_welcome_changelog - 50
			 */
			do_action( 'newspaperx_welcome' ); ?>

		</div>
		<?php
	}

	/**
	 * Getting started
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_getting_started() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/getting-started.php' );
	}

	/**
	 * Actions required
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_actions_required() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/actions-required.php' );
	}

	/**
	 * Changelog
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_import_demo() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/import-demo.php' );
	}

	/**
	 * Changelog
	 *
	 * @since 1.8.2.4
	 */
	public function newspaperx_welcome_changelog() {
		require_once( get_template_directory() . '/inc/admin/welcome-screen/sections/changelog.php' );
	}

}

new NewspaperX_Welcome();
