<?php

class Widget_NewspaperX_Contact extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'NewspaperX_Contact', // Base ID
			__( 'Newspaper X Contact Widget', 'newspaper-x' ), // Name
			array( 'description' => __( 'Newspaper X Contact Widget', 'newspaper-x' ), ) // Args
		);
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
				'contact_title' => esc_html( 'Contact' ),
				'phone'         => esc_html( '+40 764123986' ),
				'email'         => esc_html( 'newspaperx@contact.com' ),
				'address'       => esc_html( 'Northon Street, 2015 NYC' ),
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$filepath = dirname( __FILE__ ) . '/view/default.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="newspaperx-contact-widget ', $before_widget );
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
			'contact_title' => esc_html( 'Contact' ),
			'phone'         => esc_html( '+40 764123986' ),
			'email'         => esc_html( 'newspaperx@contact.com' ),
			'address'       => esc_html( 'Northon Street, 2015 NYC' ),
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'contact_title' ); ?>"><?php _e( 'Contact section title:', 'newspaper-x' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'contact_title' ); ?>"
			       name="<?php echo $this->get_field_name( 'contact_title' ); ?>" type="text"
			       value="<?php echo esc_attr( $contact_title ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone number:', 'newspaper-x' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'phone' ); ?>"
			       name="<?php echo $this->get_field_name( 'phone' ); ?>" type="tel"
			       value="<?php echo esc_attr( $phone ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'newspaper-x' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>"
			       name="<?php echo $this->get_field_name( 'email' ); ?>" type="email"
			       value="<?php echo esc_attr( $email ); ?>">
		</p>
		<p>
			<label
				for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e( 'Address:', 'newspaper-x' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>"
			       name="<?php echo $this->get_field_name( 'address' ); ?>" type="text"
			       value="<?php echo esc_attr( $address ); ?>">
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
		$instance                  = $old_instance;
		$instance['contact_title'] = esc_html( $new_instance['contact_title'] );
		$instance['phone']         = esc_html( $new_instance['phone'] );
		$instance['email']         = esc_html( $new_instance['email'] );
		$instance['address']       = esc_html( $new_instance['address'] );

		return $instance;
	}
}