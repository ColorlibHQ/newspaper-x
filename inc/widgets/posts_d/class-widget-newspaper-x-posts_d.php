<?php

class Widget_Newspaper_X_Posts_D extends WP_Widget {

	function __construct() {

		add_action( 'admin_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );

		parent::__construct( 'newspaper_x_widget_posts_d', esc_html__( 'Newspaper X - Contact', 'newspaper-x' ), array(
			'classname'                   => 'newspaper_x_widgets',
			'description'                 => esc_html__( 'Contact .', 'newspaper-x' ),
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
			'title'     => __( 'Contact', 'newspaper-x' ),
			'phone'    => '',
			'email'    => '',
			'address'    => '',
			'facebook'    => '',
			'twitter'    => '',
			'tumblr'    => '',
			'gplus'    => '',
			'youtube'    => ''
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label><?php echo esc_html__( 'Title', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       value="<?php echo $instance['title'] ; ?>">
		</p>

		<p>
			<label><?php echo esc_html__( 'Phone', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"
			       value="<?php echo esc_attr( $instance['phone'] ); ?>">
		</p>
		<p>
			<label><?php echo esc_html__( 'Email', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"
			       value="<?php echo esc_attr( $instance['email'] ); ?>">
		</p>
		<p>
			<label><?php echo esc_html__( 'Address', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"
			       value="<?php echo esc_attr( $instance['address'] ); ?>">
		</p>
		<p>
			<label><?php echo esc_html__( 'Facebook', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"
			       value="<?php echo esc_attr( $instance['facebook'] ); ?>">
		</p>
		<p>
			<label><?php echo esc_html__( 'Twitter', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"
			       value="<?php echo esc_attr( $instance['twitter'] ); ?>">
		</p>

		<p>
			<label><?php echo esc_html__( 'Tumblr', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'tumblr' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'tumblr' ) ); ?>"
			       value="<?php echo esc_attr( $instance['tumblr'] ); ?>">
		</p>

		<p>
			<label><?php echo esc_html__( 'Google Plus', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'gplus' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'gplus' ) ); ?>"
			       value="<?php echo esc_attr( $instance['gplus'] ); ?>">
		</p>

		<p>
			<label><?php echo esc_html__( 'Youtube', 'newspaper-x' ); ?> :</label>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>"
			       id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"
			       value="<?php echo esc_attr( $instance['youtube'] ); ?>">
		</p>

	<?php }

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title']                = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['name']                 = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : '';
		$instance['phone']                 = ( ! empty( $new_instance['phone'] ) ) ? absint( $new_instance['phone'] ) : '';
		$instance['email']                = ( ! empty( $new_instance['email'] ) ) ? sanitize_text_field( $new_instance['email']) : '';
		$instance['address']              = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
		$instance['facebook']             = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['twitter']              = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
		$instance['tumblr']               = ( ! empty( $new_instance['tumblr'] ) ) ? strip_tags( $new_instance['tumblr'] ) : '';
		$instance['gplus']                = ( ! empty( $new_instance['gplus'] ) ) ? strip_tags( $new_instance['gplus'] ) : '';
		$instance['youtube']              = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';


		return $instance;

	}


	public function widget( $args, $instance ) {

		$defaults = array(
			'title'     => __( 'Contact', 'newspaper-x' ),
			'phone'    => '',
			'email'    => '',
			'address'    => '',
			'facebook'    => '',
			'twitter'    => '',
			'tumblr'    => '',
			'gplus'    => '',
			'youtube'    => ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		echo $args['before_widget'];

		$filepath = get_template_directory() . '/inc/widgets/posts_d/layouts/default.php';

		if ( file_exists( $filepath ) ) {
			include $filepath;
		} else {
			echo esc_html__( 'Please configure your widget', 'newspaper-x' );
		}

		echo $args['after_widget'];

	}

}