<?php

class Widget_Bugle_Recent extends WP_Widget {

	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'Bugle_Recent', // Base ID
			__( 'Bugle Recent Posts', 'bugle' ), // Name
			array( 'description' => __( 'Recent Posts!', 'bugle' ), ) // Args
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$params = array(
			'order'   => 'DESC',
			'orderby' => 'date',
			'cats'    => ''
		);

		if ( empty( $instance ) ) {
			$instance = array(
				'title'      => esc_attr__( 'Recent Posts', 'bugle' ),
				'show_title' => 'yes',
				'limit'      => 5,
				'offset'     => 0,
			);
		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $before_title . $params['title'] . $after_title;

		$filepath = dirname( __FILE__ ) . '/view/default.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="bugle-recent-posts ', $before_widget );
		echo $before_widget;

		if ( $params['show_title'][0] == 'yes' ) {
			echo $title;
		}

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
	function form( $instance ) {

		$defaults = array(
			'title'      => esc_attr__( 'Recent Posts', 'bugle' ),
			'show_title' => 'yes',
			'limit'      => 5,
			'offset'     => 0,
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'bugle' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title', 'bugle' );
				?>:</label>
			<select name="<?php echo $this->get_field_name( 'show_title' ); ?>[]"
			        id="<?php echo $this->get_field_id( 'show_title' ); ?>" class="widefat" style="height: auto;">
				<option value="yes" <?php echo ( $show_title[0] == 'yes' ) ? 'selected' : '' ?>>
					<?php echo __( 'Yes', 'bugle' ) ?>
				</option>
				<option value="no" <?php echo ( $show_title[0] == 'no' ) ? 'selected' : '' ?>>
					<?php echo __( 'No', 'bugle' ) ?>
				</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of posts', 'bugle' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>"
			       name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" value="<?php echo $limit; ?>"
			       min="-1"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset', 'bugle' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>"
			       name="<?php echo $this->get_field_name( 'offset' ); ?>" type="number" value="<?php echo $offset; ?>"
			       min="-1"/>
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

		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['show_title'] = $new_instance['show_title'];
		$instance['limit']      = (int) $new_instance['limit'];
		$instance['offset']     = (int) $new_instance['offset'];

		return $instance;
	}
}