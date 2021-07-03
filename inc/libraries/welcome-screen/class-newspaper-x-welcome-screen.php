<?php

/**
 * Welcome Screen Class
 */
class Newspaper_X_Welcome_Screen {

	/**
	 * Constructor for the welcome screen
	 */
	public function __construct() {
		/* create dashbord page */
		add_action( 'admin_menu', array( $this, 'newspaper_x_welcome_register_menu' ) );

		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'newspaper_x_activation_admin_notice' ) );

		/* enqueue script and style for welcome screen */
		add_action( 'admin_enqueue_scripts', array( $this, 'newspaper_x_welcome_style_and_scripts' ) );

		/* ajax callback for dismissable required actions */
		add_action( 'wp_ajax_newspaper_x_dismiss_required_action', array(
			$this,
			'newspaper_x_dismiss_required_action_callback'
		) );
		add_action( 'wp_ajax_nopriv_newspaper_x_dismiss_required_action', array(
			$this,
			'newspaper_x_dismiss_required_action_callback'
		) );

		add_action( 'admin_init', array( $this, 'newspaper_x_activate_plugin' ) );
		add_action( 'admin_init', array( $this, 'newspaper_x_deactivate_plugin' ) );
		add_action( 'admin_init', array( $this, 'newspaper_x_set_pages' ) );
	}

	public function newspaper_x_set_pages() {
		if ( ! empty( $_GET ) ) {
			/**
			 * Check action
			 */
			if ( ! empty( $_GET['action'] ) && $_GET['action'] === 'set_page_automatic' ) {

				if ( ! check_ajax_referer( 'epsilon_framework_ajax_action', 'security' ) ) {
					return;
				}

				if ( ! current_user_can( 'manage_options' ) ) {
				    return;
				}
				
				$active_tab = $_GET['tab'];
				$about      = get_page_by_title( 'Homepage' );
				update_option( 'page_on_front', $about->ID );
				update_option( 'show_on_front', 'page' );

				// Set the blog page
				$blog = get_page_by_title( 'Blog' );
				update_option( 'page_for_posts', $blog->ID );

				wp_redirect( self_admin_url( 'themes.php?page=newspaper-x-welcome&tab=' . $active_tab ) );
			}
		}
	}


	public function newspaper_x_activate_plugin() {
		if ( ! empty( $_GET ) ) {
			/**
			 * Check action
			 */
			if ( ! empty( $_GET['action'] ) && ! empty( $_GET['plugin'] ) && $_GET['action'] === 'activate_plugin' ) {

				if ( ! check_ajax_referer( 'epsilon_framework_ajax_action', 'security' ) ) {
					return;
				}

				if ( ! current_user_can( 'manage_options' ) ) {
				    return;
				}

				$active_tab = $_GET['tab'];
				$url        = self_admin_url( 'themes.php?page=newspaper-x-welcome&tab=' . $active_tab );
				activate_plugin( $_GET['plugin'], $url );
			}
		}
	}

	public function newspaper_x_deactivate_plugin() {
		if ( ! empty( $_GET ) ) {
			/**
			 * Check action
			 */
			if ( ! empty( $_GET['action'] ) && ! empty( $_GET['plugin'] ) && $_GET['action'] === 'deactivate_plugin' ) {

				if ( ! check_ajax_referer( 'epsilon_framework_ajax_action', 'security' ) ) {
					return;
				}

				if ( ! current_user_can( 'manage_options' ) ) {
				    return;
				}

				$active_tab = $_GET['tab'];
				$url        = self_admin_url( 'themes.php?page=newspaper-x-welcome&tab=' . $active_tab );
				$current    = get_option( 'active_plugins', array() );
				$search     = array_search( $_GET['plugin'], $current );
				if ( array_key_exists( $search, $current ) ) {
					unset( $current[ $search ] );
				}
				update_option( 'active_plugins', $current );
			}
		}
	}

	/**
	 * Creates the dashboard page
	 *
	 * @see   add_theme_page()
	 * @since 1.8.2.4
	 */
	public function newspaper_x_welcome_register_menu() {
		$action_count = $this->count_actions();
		$title        = $action_count > 0 ? 'About Newspaper X <span class="badge-action-count">' . esc_html( $action_count ) . '</span>' : 'About Newspaper X';

		add_theme_page( 'About Newspaper X', $title, 'edit_theme_options', 'newspaper-x-welcome', array(
			$this,
			'newspaper_x_welcome_screen'
		) );
	}

	/**
	 * Adds an admin notice upon successful activation.
	 *
	 * @since 1.8.2.4
	 */
	public function newspaper_x_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'newspaper_x_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 *
	 * @since 1.8.2.4
	 */
	public function newspaper_x_welcome_admin_notice() {
		?>
		<div class="updated notice is-dismissible">
			<p><?php echo sprintf( __( 'Welcome! Thank you for choosing Newspaper X! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'newspaper-x' ), '<a href="' . esc_url( admin_url( 'themes.php?page=newspaper-x-welcome' ) ) . '">', '</a>' ); ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaper-x-welcome' ) ); ?>" class="button"
			      style="text-decoration: none;"><?php echo esc_html__( 'Get started with Newspaper X', 'newspaper-x' ); ?></a></p>
		</div>
		<?php
	}

	/**
	 * Load welcome screen css and javascript
	 *
	 * @since  1.8.2.4
	 */
	public function newspaper_x_welcome_style_and_scripts( $hook_suffix ) {

		wp_enqueue_style( 'newspaper-x-welcome-screen-css', get_template_directory_uri() . '/inc/libraries/welcome-screen/css/welcome.css' );
		wp_enqueue_script( 'newspaper-x-welcome-screen-js', get_template_directory_uri() . '/inc/libraries/welcome-screen/js/welcome.js', array( 'jquery' ) );

		wp_localize_script( 'newspaper-x-welcome-screen-js', 'newspaperXWelcomeScreenObject', array(
			'nr_actions_required'      => absint( $this->count_actions() ),
			'ajaxurl'                  => esc_url( admin_url( 'admin-ajax.php' ) ),
			'template_directory'       => esc_url( get_template_directory_uri() ),
			'no_required_actions_text' => esc_html__( 'Hooray! There are no required actions for you right now.', 'newspaper-x' )
		) );

	}

	/**
	 * Load scripts for customizer page
	 *
	 * @since  1.8.2.4
	 */
	public function newspaper_x_welcome_scripts_for_customizer() {

		wp_enqueue_style( 'newspaper-x-welcome-screen-customizer-css', get_template_directory_uri() . '/inc/libraries/welcome-screen/css/welcome_customizer.css' );
		wp_enqueue_script( 'newspaper-x-welcome-screen-customizer-js', get_template_directory_uri() . '/inc/libraries/welcome-screen/js/welcome_customizer.js', array( 'jquery' ), '20120206', true );

		wp_localize_script( 'newspaper-x-welcome-screen-customizer-js', 'newspaperXWelcomeScreenCustomizerObject', array(
			'nr_actions_required' => absint( $this->count_actions() ),
			'aboutpage'           => esc_url( admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions' ) ),
			'customizerpage'      => esc_url( admin_url( 'customize.php#recommended_actions' ) ),
			'themeinfo'           => esc_html__( 'View Theme Info', 'newspaper-x' ),
		) );
	}

	/**
	 * Dismiss required actions
	 *
	 * @since 1.8.2.4
	 */
	public function newspaper_x_dismiss_required_action_callback() {

		global $newspaper_x_required_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html( $action_id ); /* this is needed and it's the id of the dismissable required action */

		if ( ! empty( $action_id ) ):

			/* if the option exists, update the record for the specified id */
			if ( get_option( 'newspaper_x_show_required_actions' ) ):

				$newspaper_x_show_required_actions = get_option( 'newspaper_x_show_required_actions' );

				switch ( $_GET['todo'] ) {
					case 'add';
						$newspaper_x_show_required_actions[ $action_id ] = true;
						break;
					case 'dismiss';
						$newspaper_x_show_required_actions[ $action_id ] = false;
						break;
				}

				update_option( 'newspaper_x_show_required_actions', $newspaper_x_show_required_actions );

			/* create the new option,with false for the specified id */
			else:

				$newspaper_x_show_required_actions_new = array();

				if ( ! empty( $newspaper_x_required_actions ) ):

					foreach ( $newspaper_x_required_actions as $newspaper_x_required_action ):

						if ( $newspaper_x_required_action['id'] == $action_id ):
							$newspaper_x_show_required_actions_new[ $newspaper_x_required_action['id'] ] = false;
						else:
							$newspaper_x_show_required_actions_new[ $newspaper_x_required_action['id'] ] = true;
						endif;

					endforeach;

					update_option( 'newspaper_x_show_required_actions', $newspaper_x_show_required_actions_new );

				endif;

			endif;

		endif;

		die(); // this is required to return a proper result
	}

	/**
	 *
	 */
	public function count_actions() {
		global $newspaper_x_required_actions;

		$newspaper_x_show_required_actions = get_option( 'newspaper_x_show_required_actions' );
		if ( ! $newspaper_x_show_required_actions ) {
			$newspaper_x_show_required_actions = array();
		}

		$i = 0;
		foreach ( $newspaper_x_required_actions as $action ) {
			$true      = false;
			$dismissed = false;

			if ( ! $action['check'] ) {
				$true = true;
			}

			if ( ! empty( $newspaper_x_show_required_actions ) && isset( $newspaper_x_show_required_actions[ $action['id'] ] ) && ! $newspaper_x_show_required_actions[ $action['id'] ] ) {
				$true = false;
			}

			if ( $true ) {
				$i ++;
			}
		}


		return $i;
	}

	public function call_plugin_api( $slug ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

		if ( false === ( $call_api = get_transient( 'newspaper_x_plugin_information_transient_' . $slug ) ) ) {
			$call_api = plugins_api( 'plugin_information', array(
				'slug'   => $slug,
				'fields' => array(
					'downloaded'        => false,
					'rating'            => false,
					'description'       => false,
					'short_description' => true,
					'donate_link'       => false,
					'tags'              => false,
					'sections'          => true,
					'homepage'          => true,
					'added'             => false,
					'last_updated'      => false,
					'compatibility'     => false,
					'tested'            => false,
					'requires'          => false,
					'downloadlink'      => false,
					'icons'             => true
				)
			) );
			set_transient( 'newspaper_x_plugin_information_transient_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
		}

		return $call_api;
	}

	public function check_active( $slug ) {
		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			$needs = is_plugin_active( $slug . '/' . $slug . '.php' ) ? 'deactivate' : 'activate';

			return array( 'status' => is_plugin_active( $slug . '/' . $slug . '.php' ), 'needs' => $needs );
		}

		return array( 'status' => false, 'needs' => 'install' );
	}

	public function check_for_icon( $arr ) {
		if ( ! empty( $arr['svg'] ) ) {
			$plugin_icon_url = $arr['svg'];
		} elseif ( ! empty( $arr['2x'] ) ) {
			$plugin_icon_url = $arr['2x'];
		} elseif ( ! empty( $arr['1x'] ) ) {
			$plugin_icon_url = $arr['1x'];
		} else {
			$plugin_icon_url = $arr['default'];
		}

		return $plugin_icon_url;
	}

	public function create_action_link( $state, $slug ) {
		switch ( $state ) {
			case 'install':
				return wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $slug
						),
						network_admin_url( 'update.php' )
					),
					'install-plugin_' . $slug
				);
				break;
			case 'deactivate':
				return add_query_arg( array(
					                      'action'        => 'deactivate',
					                      'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
					                      'plugin_status' => 'all',
					                      'paged'         => '1',
					                      '_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' ),
				                      ), network_admin_url( 'plugins.php' ) );
				break;
			case 'activate':
				return add_query_arg( array(
					                      'action'        => 'activate',
					                      'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
					                      'plugin_status' => 'all',
					                      'paged'         => '1',
					                      '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' ),
				                      ), network_admin_url( 'plugins.php' ) );
				break;
		}
	}

	/**
	 * Welcome screen content
	 *
	 * @since 1.8.2.4
	 */
	public function newspaper_x_welcome_screen() {
		require_once( ABSPATH . 'wp-load.php' );
		require_once( ABSPATH . 'wp-admin/admin.php' );
		require_once( ABSPATH . 'wp-admin/admin-header.php' );

		$newspaper_x  = wp_get_theme();
		$active_tab   = isset( $_GET['tab'] ) ? $_GET['tab'] : 'getting_started';
		$action_count = $this->count_actions();

		?>

		<div class="wrap about-wrap epsilon-wrap">

			<h1><?php echo esc_html__( 'Welcome to Newspaper X! - Version ', 'newspaper-x' ) . esc_html( $newspaper_x['Version'] ); ?></h1>

			<div
				class="about-text"><?php echo esc_html__( 'Newspaper X is now installed and ready to use! Get ready to build something beautiful. We hope you enjoy it! We want to make sure you have the best experience using Newspaper X and that is why we gathered here all the necessary information for you. We hope you will enjoy using Newspaper X, as much as we enjoy creating great products.', 'newspaper-x' ); ?></div>

			<div class="wp-badge epsilon-welcome-logo"></div>


			<h2 class="nav-tab-wrapper wp-clearfix">
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaper-x-welcome&tab=getting_started' ) ); ?>"
				   class="nav-tab <?php echo $active_tab == 'getting_started' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__( 'Getting Started', 'newspaper-x' ); ?></a>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_actions' ) ); ?>"
				   class="nav-tab <?php echo $active_tab == 'recommended_actions' ? 'nav-tab-active' : ''; ?> "><?php echo esc_html__( 'Recommended Actions', 'newspaper-x' ); ?>
					<?php echo $action_count > 0 ? '<span class="badge-action-count">' . esc_html( $action_count ) . '</span>' : '' ?></a>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaper-x-welcome&tab=recommended_plugins' ) ); ?>"
				   class="nav-tab <?php echo $active_tab == 'recommended_plugins' ? 'nav-tab-active' : ''; ?> "><?php echo esc_html__( 'Recommended Plugins', 'newspaper-x' ); ?></a>
				<a href="<?php echo esc_url( admin_url( 'themes.php?page=newspaper-x-welcome&tab=support' ) ); ?>"
				   class="nav-tab <?php echo $active_tab == 'support' ? 'nav-tab-active' : ''; ?> "><?php echo esc_html__( 'Support', 'newspaper-x' ); ?></a>
			</h2>

			<?php
			switch ( $active_tab ) {
				case 'getting_started':
					require_once get_template_directory() . '/inc/libraries/welcome-screen/sections/getting-started.php';
					break;
				case 'recommended_actions':
					require_once get_template_directory() . '/inc/libraries/welcome-screen/sections/actions-required.php';
					break;
				case 'recommended_plugins':
					require_once get_template_directory() . '/inc/libraries/welcome-screen/sections/recommended-plugins.php';
					break;
				case 'support':
					require_once get_template_directory() . '/inc/libraries/welcome-screen/sections/support.php';
					break;
				default:
					require_once get_template_directory() . '/inc/libraries/welcome-screen/sections/getting-started.php';
					break;
			}
			?>


		</div><!--/.wrap.about-wrap-->

		<?php
	}
}