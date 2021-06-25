<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Widget_Newspaper_X_Contact_Us extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct( 'newspaper_x_widget_contact_us', esc_html__( 'Newspaper X - Contact', 'newspaper-x' ), array(
			'classname'                   => 'newspaper_x_widgets',
			'description'                 => esc_html__( 'Newspaper X - Contact', 'newspaper-x' ),
			'customize_selective_refresh' => true
		) );
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$params = array();

		if ( empty( $instance ) ) {
			$instance = array(
				'title'   => __( 'Contact', 'newspaper-x' ),
				'phone'   => '',
				'email'   => '',
				'address' => '',
				'social_menu' => '',
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$filepath = dirname( __FILE__ ) . '/layout/default.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="newspaper-x-type-contact ', $before_widget );
		echo $before_widget;

		if ( file_exists( $filepath ) ) {
			include $filepath;
		}

		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return string;
	 */
	public function form( $instance ) {

		$defaults = array(
			'title'   => __( 'Contact', 'newspaper-x' ),
			'phone'   => '',
			'email'   => '',
			'address' => '',
			'social_menu' => '',
		);
		$menus = wp_get_nav_menus();
		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
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
					<label for="<?php echo esc_attr( $this->get_field_id( 'social_menu' ) ); ?>"><?php esc_html_e( 'Social Menu:', 'newspaper-x' ); ?></label>
					<select id="<?php echo $this->get_field_id( 'social_menu' ); ?>" name="<?php echo $this->get_field_name( 'social_menu' ); ?>">
						<option value="0"><?php _e( '&mdash; Select &mdash;', 'newspaper-x' ); ?></option>
						<?php foreach ( $menus as $menu ) : ?>
							<option value="<?php echo esc_attr( $menu->term_id ); ?>" <?php selected( $social_menu, $menu->term_id ); ?>>
								<?php echo esc_html( $menu->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance              = $old_instance;
		$instance['title']  = strip_tags( $new_instance['title'] );
		$instance['phone']  = strip_tags( $new_instance['phone'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['social_menu'] = strip_tags( $new_instance['social_menu'] );

		return $instance;
	}
}