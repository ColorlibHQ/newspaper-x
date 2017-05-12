<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Sigma_Shop_Sidebars
 */
class Newspaper_X_Sidebars {
	/**
	 * @var array
	 */
	public $sidebars = array();

	/**
	 * Sigma_Shop_Sidebars constructor.
	 */
	public function __construct() {
		$this->collect_sidebars();
		add_action( 'widgets_init', array( $this, 'set_sidebars' ) );
		add_action( 'widgets_init', array( $this, 'initiate_widgets' ) );

	}

	/**
	 * registers sidebars
	 */
	public function set_sidebars() {
		foreach ( $this->sidebars as $sidebar ) {
			register_sidebar( $sidebar );
		}
	}

	/**
	 * Add sidebars here
	 */
	private function collect_sidebars() {
		$this->sidebars = array(
			array(
				'id'            => 'sidebar',
				'name'          => esc_html__( 'Blog Sidebar', 'newspaper-x' ),
				'description'   => esc_html__( 'This is the blog sidebar. If you\'ve set a posts page under Settings -> Reading, that\'s where your sidebar will be showing up', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'header-widget-area',
				'name'          => esc_html__( 'Homepage - Header area', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'content-area',
				'name'          => esc_html__( 'Homepage - Content area', 'newspaper-x' ),
				'description'   => esc_html__( 'The sidebar holds the entire homepage content.', 'newspaper-x' ),
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>'
			),
			array(
				'id'            => 'after-content-area',
				'name'          => esc_html__( 'Homepage - After Content area', 'newspaper-x' ),
				'description'   => esc_html__( 'The sidebar holds homepage content.', 'newspaper-x' ),
				'before_title'  => '<h3 class="widget-title"><span>',
				'after_title'   => '</span></h3>',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>'
			),
			array(
				'id'            => 'sidebar-homepage',
				'name'          => esc_html__( 'Homepage - Sidebar', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'footer-1',
				'name'          => esc_html__( 'Footer 1', 'newspaper-x' ),
				'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'footer-2',
				'name'          => esc_html__( 'Footer 2', 'newspaper-x' ),
				'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'footer-3',
				'name'          => esc_html__( 'Footer 3', 'newspaper-x' ),
				'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'footer-4',
				'name'          => esc_html__( 'Footer 4', 'newspaper-x' ),
				'description'   => esc_html__( 'This is your footer sidebar. By default, we\'ve defined a maximum of 4 sidebars but if you want to use less make sure you change the settings in: Footer -> Footer columns.', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			),
			array(
				'id'            => 'after-footer',
				'name'          => esc_html__( 'After Footer', 'newspaper-x' ),
				'description'   => esc_html__( 'This is a footer sidebar.', 'newspaper-x' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	/**
	 * Initiate widgets
	 */
	public function initiate_widgets() {
		$widgets = array(
			'Widget_Newspaper_X_Posts_A',
			'Widget_Newspaper_X_Posts_B',
			'Widget_Newspaper_X_Posts_C',
			'Widget_Newspaper_X_Posts_D',
			'Widget_Newspaper_X_Banner',
			'Widget_Newspaper_X_Contact_Us',
			'Widget_Newspaper_X_Header_Module',
		);

		foreach ( $widgets as $widget ) {
			new $widget();
			register_widget( $widget );
		}
	}
}