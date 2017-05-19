<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Widget_Newspaper_X_Banner extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'newspaper_x_banner', // Base ID
			__( 'Newspaper X Banner', 'newspaper-x' ), // Name
			array(
				'description'                 => __( 'Newspaper X Banners', 'newspaper-x' ),
				'customize_selective_refresh' => true
			) // Args
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
				'image_id'  => '',
				'image_url' => '',
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$filepath = dirname( __FILE__ ) . '/view/image.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="newspaper-x-type-image ', $before_widget );
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
		wp_enqueue_media();
		wp_enqueue_style( 'newspaper_x_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css' );
		wp_enqueue_script( 'newspaper_x_media_upload_js', get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js', array( 'jquery' ) );

		$defaults = array(
			'image_id'  => '',
			'image_url' => '',
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>

        <p class="newspaper-x-media-control"
           data-delegate-container="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ) ?>">
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"><?php _e( 'Banner Image', 'newspaper-x' );
				?>:</label>

			<?php echo wp_get_attachment_image( $image_id, false, false ); ?>

            <input type="hidden"
                   name="<?php echo esc_attr( $this->get_field_name( 'image_id' ) ); ?>"
                   id="<?php echo esc_attr( $this->get_field_id( 'image_id' ) ); ?>"
                   value="<?php echo (int) $image_id; ?>"
                   class="image-id blazersix-media-control-target">

            <button type="button" class="button upload-button"><?php _e( 'Choose Image', 'newspaper-x' ); ?></button>
        </p>

        <p>
            <label
                    for="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"><?php _e( 'Banner URL:', 'newspaper-x' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image_url' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'image_url' ) ); ?>" type="text"
                   value="<?php echo esc_attr( $image_url ); ?>">
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
		$instance['image_id']  = (int) $new_instance['image_id'];
		$instance['image_url'] = esc_url_raw( $new_instance['image_url'] );

		return $instance;
	}
}