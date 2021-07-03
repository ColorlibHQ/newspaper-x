<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Widget_Newspaper_X_Header_Module
 */
class Widget_Newspaper_X_Header_Module extends WP_Widget {

	/**
	 * Widget_Newspaper_X_Header_Module constructor.
	 */
	public function __construct() {
		parent::__construct( 'newspaper_x_header_module', __( 'Newspaper X - Header Module', 'newspaper-x' ), array(
			'classname'                   => 'newspaper_x_widgets',
			'description'                 => esc_html__( 'Header module.', 'newspaper-x' ),
			'customize_selective_refresh' => true
		) );
	}

	/**
	 * @param $instance
	 */
	public function form( $instance ) {
		$defaults = array(
			'title'    => '',
			'category' => '',
			'order'    => 'desc',
			'order_by' => 'date'
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
        <p>
            <label><?php _e( 'Title', 'newspaper-x' ); ?> :</label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label><?php _e( 'Category', 'newspaper-x' ); ?> :</label>
            <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'category' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">
                <option value="" <?php if ( empty( $instance['category'] ) ) {
					echo 'selected="selected"';
				} ?>><?php _e( '&ndash; Select a category &ndash;', 'newspaper-x' ) ?></option>
				<?php
				$categories = get_categories( 'hide_empty=0' );
				foreach ( $categories as $category ) { ?>
                    <option
                            value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( esc_attr( $category->slug ), $instance['category'] ); ?>><?php echo esc_html( $category->cat_name ); ?></option>
				<?php } ?>
            </select>
        </p>

        <p>
            <label><?php _e( 'Order', 'newspaper-x' ); ?> :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" class="widefat pull-right">
                <option value="desc" <?php echo ( $instance['order'] == 'desc' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Descending', 'newspaper-x' ) ?></option>
                <option value="asc" <?php echo ( $instance['order'] == 'asc' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Ascending', 'newspaper-x' ) ?></option>
                <option value="rand" <?php echo ( $instance['order'] == 'rand' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Random', 'newspaper-x' ) ?></option>
            </select>
        </p>

        <p>
            <label><?php _e( 'Order by', 'newspaper-x' ); ?> :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'order_by' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'order_by' ) ); ?>" class="widefat pull-right">
                <option value="date" <?php echo ( $instance['order_by'] == 'date' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'By date', 'newspaper-x' ) ?></option>
                <option value="title" <?php echo ( $instance['order_by'] == 'title' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'By title', 'newspaper-x' ) ?></option>
                <option value="comment_count" <?php echo ( $instance['order_by'] == 'comment_count' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'By comments', 'newspaper-x' ) ?></option>
                <option value="rand" <?php echo ( $instance['order'] == 'rand' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Random', 'newspaper-x' ) ?></option>
            </select>
        </p>
		<?php
	}

	/**
	 * @param $new_instance
	 * @param $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();

		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? strip_tags( $new_instance['category'] ) : '';
		$instance['order']    = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['order_by'] = ( ! empty( $new_instance['order_by'] ) ) ? strip_tags( $new_instance['order_by'] ) : '';

		return $instance;
	}

	/**
	 * @param $args
	 *
	 * @return WP_Query
	 */
	public function get_posts( $args ) {
		$idObj = get_category_by_slug( $args['category'] );

		$atts = array(
			'posts_per_page' => 3
		);

		$atts['order']   = $args['order'];
		$atts['orderby'] = 'date';

		if ( 'rand' == $atts['order'] ) {
			$atts['order']   = '';
			$atts['orderby'] = 'rand';
		}

		if ( $idObj ) {
			$id          = $idObj->term_id;
			$atts['cat'] = $id;
		}

		$posts = new WP_Query( $atts );

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * @param $args
	 * @param $instance
	 */
	public function widget( $args, $instance ) {
		$defaults = array(
			'title'    => '',
			'category' => '',
			'order'    => 'desc',
			'order_by' => 'date'
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		echo $args['before_widget'];
		$filepath = get_template_directory() . '/inc/libraries/widgets/widget-newspaper-x-header-module/layouts/default.php';

		$posts = $this->get_posts( $instance );

		if ( file_exists( $filepath ) ) {
			include $filepath;
		} else {
			esc_html_e( 'Please configure your widget', 'newspaper-x' );
		}


		echo $args['after_widget'];

	}
}