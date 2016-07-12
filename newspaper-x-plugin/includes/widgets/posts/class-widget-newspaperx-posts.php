<?php

class Widget_NewspaperX_Posts extends WP_Widget {

	/**
	 * @internal
	 */
	public function __construct() {
		parent::__construct(
			'NewspaperX_Posts', // Base ID
			__( 'Newspaper X Posts', 'newspaper-x' ), // Name
			array( 'description' => __( 'Post Widget!', 'newspaper-x' ), ) // Args
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
				'title'         => esc_attr__( 'Recent Posts', 'newspaper-x' ),
				'show_title'    => 'yes',
				'limit'         => 5,
				'posts_per_row' => 2,
				'offset'        => 0,
				'order'         => 'DESC',
				'orderby'       => 'date',
				'cats'          => array( 1 ),
				'layout'        => 'layout-a'
			);

		}

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $before_title . $params['title'] . $after_title;

		$filepath = dirname( __FILE__ ) . '/view/' . $params['layout'][0] . '.php';

		$instance = $params;

		$before_widget = str_replace( 'class="', 'class="newspaperx-' . $params['layout'][0] . ' ', $before_widget );
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
			'title'         => esc_attr__( 'Recent Posts', 'newspaper-x' ),
			'show_title'    => 'yes',
			'limit'         => 5,
			'posts_per_row' => 4,
			'offset'        => 0,
			'order'         => 'DESC',
			'orderby'       => 'date',
			'cats'          => array(),
			'layout'        => 'layout-a'
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );
		// Extract the array to allow easy use of variables.
		extract( $instance );
		// Loads the widget form.
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'newspaper-x' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
			       name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>"/>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title', 'newspaper-x' );
				?>:</label>
			<select name="<?php echo $this->get_field_name( 'show_title' ); ?>[]"
			        id="<?php echo $this->get_field_id( 'show_title' ); ?>" class="widefat" style="height: auto;">
				<option value="yes" <?php echo ( $show_title[0] == 'yes' ) ? 'selected' : '' ?>>
					<?php echo __( 'Yes', 'newspaper-x' ) ?>
				</option>
				<option value="no" <?php echo ( $show_title[0] == 'no' ) ? 'selected' : '' ?>>
					<?php echo __( 'No', 'newspaper-x' ) ?>
				</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Number of posts', 'newspaper-x' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>"
			       name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" value="<?php echo $limit; ?>"
			       min="-1"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_row' ); ?>"><?php _e( 'Posts per row', 'newspaper-x' ); ?>
				:</label>
			<select name="<?php echo $this->get_field_name( 'posts_per_row' ); ?>"
			        id="<?php echo $this->get_field_id( 'posts_per_row' ); ?>" class="widefat">
				<option value="1"<?php if ( $posts_per_row == '1' ) {
					echo ' selected';
				} ?>><?php _e( 'One Post', 'newspaper-x' ); ?></option>
				<option value="2"<?php if ( $posts_per_row == '2' ) {
					echo ' selected';
				} ?>><?php _e( 'Two Posts', 'newspaper-x' ); ?></option>
				<option value="3"<?php if ( $posts_per_row == '3' ) {
					echo ' selected';
				} ?>><?php _e( 'Three Posts', 'newspaper-x' ); ?></option>
				<option value="4"<?php if ( $posts_per_row == '4' ) {
					echo ' selected';
				} ?>><?php _e( 'Four Posts', 'newspaper-x' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'offset' ); ?>"><?php _e( 'Offset', 'newspaper-x' ); ?>
				:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>"
			       name="<?php echo $this->get_field_name( 'offset' ); ?>" type="number" value="<?php echo $offset; ?>"
			       min="-1"/>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'cats' ); ?>"><?php _e( 'Categories', 'newspaper-x' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'cats' ); ?>[]"
			        id="<?php echo $this->get_field_id( 'cats' ); ?>" class="widefat" style="height: auto;" size=""
			        multiple>
				<option value="" <?php if ( empty( $cats ) ) {
					echo 'selected="selected"';
				} ?>><?php _e( '&ndash; Show All &ndash;', 'newspaper-x' ) ?></option>
				<?php
				$categories = get_categories( 'hide_empty=0' );
				foreach ( $categories as $category ) { ?>
					<option
						value="<?php echo $category->term_id; ?>" <?php if ( is_array( $cats ) && in_array( $category->term_id, $cats ) ) {
						echo 'selected="selected"';
					} ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>
		<?php ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'layout' ); ?>"><?php _e( 'Layout', 'newspaper-x' ); ?>:</label>
		<div class="widget-layouts">
			<a href="javascript:void(0)"
			   data-layout="layout-a" <?php echo ( $layout[0] == 'layout-a' ) ? 'class="selected"' : '' ?>>
				<img src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) )) . 'assets/images/layout-a.png' ?>"/>
			</a>
			<a href="javascript:void(0)"
			   data-layout="layout-b" <?php echo ( $layout[0] == 'layout-b' ) ? 'class="selected"' : '' ?>>
				<img src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) )) . 'assets/images/layout-b.png' ?>"/>
			</a>
			<a href="javascript:void(0)"
			   data-layout="layout-c" <?php echo ( $layout[0] == 'layout-c' ) ? 'class="selected"' : '' ?>>
				<img src="<?php echo plugin_dir_url( dirname( dirname( dirname( __FILE__ ) ) )) . 'assets/images/layout-c.png' ?>"/>
			</a>
		</div>

		<select name="<?php echo $this->get_field_name( 'layout' ); ?>[]"
		        id="<?php echo $this->get_field_id( 'layout' ); ?>" class="widefat layout-select hidden"
		        style="height: auto;">
			<option value="layout-a" <?php echo ( $layout[0] == 'layout-a' ) ? 'selected' : '' ?>>
				<?php echo __( 'Layout A', 'newspaper-x' ) ?>
			</option>
			<option value="layout-b" <?php echo ( $layout[0] == 'layout-b' ) ? 'selected' : '' ?>>
				<?php echo __( 'Layout B', 'newspaper-x' ) ?>
			</option>
			<option value="layout-c" <?php echo ( $layout[0] == 'layout-c' ) ? 'selected' : '' ?>>
				<?php echo __( 'Layout C', 'newspaper-x' ) ?>
			</option>
		</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e( 'Order by', 'newspaper-x' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'orderby' ); ?>"
			        id="<?php echo $this->get_field_id( 'orderby' ); ?>" class="widefat">
				<option value="date"<?php if ( $orderby == 'date' ) {
					echo ' selected';
				} ?>><?php _e( 'Published Date', 'newspaper-x' ); ?></option>
				<option value="title"<?php if ( $orderby == 'title' ) {
					echo ' selected';
				} ?>><?php _e( 'Title', 'newspaper-x' ); ?></option>
				<option value="comment_count"<?php if ( $orderby == 'comment_count' ) {
					echo ' selected';
				} ?>><?php _e( 'Comment Count', 'newspaper-x' ); ?></option>
				<option value="rand"<?php if ( $orderby == 'rand' ) {
					echo ' selected';
				} ?>><?php _e( 'Random', 'newspaper-x'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Order', 'newspaper-x' ); ?>:</label>
			<select name="<?php echo $this->get_field_name( 'order' ); ?>"
			        id="<?php echo $this->get_field_id( 'order' ); ?>" class="widefat">
				<option value="DESC"<?php if ( $order == 'DESC' ) {
					echo ' selected';
				} ?>><?php _e( 'Descending', 'newspaper-x' ); ?></option>
				<option value="ASC"<?php if ( $order == 'ASC' ) {
					echo ' selected';
				} ?>><?php _e( 'Ascending', 'newspaper-x' ); ?></option>
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
		$instance                  = $old_instance;
		$instance['title']         = strip_tags( $new_instance['title'] );
		$instance['show_title']    = $new_instance['show_title'];
		$instance['limit']         = (int) $new_instance['limit'];
		$instance['offset']        = (int) $new_instance['offset'];
		$instance['order']         = stripslashes( $new_instance['order'] );
		$instance['orderby']       = stripslashes( $new_instance['orderby'] );
		$instance['cats']          = $new_instance['cats'];
		$instance['layout']        = $new_instance['layout'];
		$instance['posts_per_row'] = (int) $new_instance['posts_per_row'];

		return $instance;
	}
}