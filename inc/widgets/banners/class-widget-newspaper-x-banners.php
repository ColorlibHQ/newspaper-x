<?php

class Widget_Newspaper_Banners extends WP_Widget {

	function __construct() {

		add_action( 'admin_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );

		parent::__construct( 'newspaper_x_widget_banners', esc_html__( 'Newspaper X - Banners', 'newspaper-x' ), array(
			'classname'                   => 'newspaper_x_widgets',
			'description'                 => esc_html__( 'Banners or Google Adsense ... .', 'newspaper-x' ),
			'customize_selective_refresh' => true
		) );

	}

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/css/style.css' );
		wp_enqueue_script( 'epsilon-object', get_template_directory_uri() . '/inc/customizer/epsilon-framework/assets/js/epsilon.js', array( 'jquery' ) );
	}

	public function form( $instance ) {
		$defaults = array(
			'title'     => __( 'Banners', 'newspaper-x' )
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label><?php echo esc_html__( 'Title', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       value="<?php echo esc_attr( $title ); ?>">
		</p>

		


		

		


	<?php }

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title']                = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;

	}



	public function widget( $args, $instance ) {

		

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		$filepath = get_template_directory() . '/inc/widgets/banners/layouts/default.php';

		$posts = $this->get_posts( $instance );

		if ( file_exists( $filepath ) ) {
			include $filepath;
		} else {
			echo esc_html__( 'Please configure your widget', 'newspaper-x' );
		}

		wp_reset_postdata();
		echo $after_widget;

	}

}