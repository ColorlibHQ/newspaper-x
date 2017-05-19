<?php

class Widget_Newspaper_X_Posts_D extends WP_Widget {

	function __construct() {

		add_action( 'admin_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );

		parent::__construct( 'newspaper_x_widget_posts_d', esc_html__( 'Newspaper X - Posts Layout D', 'newspaper-x' ), array(
			'classname'                   => 'newspaper_x_widgets',
			'description'                 => esc_html__( 'Layout consists of a featured post thumbnail, followed by a handful of posts that are smaller in size. Perfect for emphasising important news.', 'newspaper-x' ),
			'customize_selective_refresh' => true
		) );

	}

	public function enqueue() {
		if ( is_admin() && ! is_customize_preview() ) {
			wp_enqueue_script( 'jquery-ui' );
			wp_enqueue_script( 'jquery-ui-slider' );
			wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . '/inc/libraries/epsilon-framework/assets/css/style.css' );
			wp_enqueue_script( 'epsilon-object', get_template_directory_uri() . '/inc/libraries/epsilon-framework/assets/js/epsilon.js', array( 'jquery' ) );
		}
	}

	public function form( $instance ) {
		$defaults = array(
			'title'                => '',
			'order'                => 'desc',
			'offset'               => '0',
			'cols'                 => 2,
			'show_post'            => 4,
			'show_date'            => 'on',
			'newspaper_x_category' => ''
		);

		if ( ! empty( $instance['offset'] ) && $instance['offset'] == 0 ) {
			$instance['offset'] = '0';
		}

		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
        <p>
            <label><?php echo esc_html__( 'Title', 'newspaper-x' ); ?> :</label>
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $instance['title'] ); ?>">
        </p>

        <p>
            <label><?php echo esc_html__( 'Category', 'newspaper-x' ); ?> :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'newspaper_x_category' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'newspaper_x_category' ) ); ?>">
                <option value="" <?php if ( empty( $instance['newspaper_x_category'] ) ) {
					echo 'selected="selected"';
				} ?>><?php echo esc_html__( '&ndash; Select a category &ndash;', 'newspaper-x' ) ?></option>
				<?php
				$categories = get_categories( 'hide_empty=0' );
				foreach ( $categories as $category ) { ?>
                    <option
                            value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( esc_attr( $category->slug ), $instance['newspaper_x_category'] ); ?>><?php echo esc_attr( $category->cat_name ); ?></option>
				<?php } ?>
            </select>
        </p>
        <p>
            <label><?php _e( 'Order', 'newspaper-x' ); ?> :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" class="pull-right">
                <option value="desc" <?php echo ( $instance['order'] == 'desc' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Descending', 'newspaper-x' ) ?></option>
                <option value="asc" <?php echo ( $instance['order'] == 'asc' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Ascending', 'newspaper-x' ) ?></option>
                <option value="rand" <?php echo ( $instance['order'] == 'rand' ) ? 'selected' : ''; ?> ><?php echo esc_html__( 'Random', 'newspaper-x' ) ?></option>
            </select>
        </p>

        </p>

        <p>
            <label><?php _e( 'Number of columns', 'newspaper-x' ); ?> :</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'cols' ) ); ?>"
                    id="<?php echo esc_attr( $this->get_field_id( 'cols' ) ); ?>" class="pull-right">
                <option value="2" <?php echo ( $instance['cols'] == '2' ) ? 'selected' : ''; ?> ><?php echo esc_html__( '2', 'newspaper-x' ) ?></option>
                <option value="3" <?php echo ( $instance['cols'] == '3' ) ? 'selected' : ''; ?> ><?php echo esc_html__( '3', 'newspaper-x' ) ?></option>
            </select>
        </p>

        <label class="block" for="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ); ?>">
            <span class="customize-control-title">
               <?php echo esc_html__( 'Posts to Show', 'newspaper-x' ); ?> :
            </span>
        </label>
        <div class="slider-container">
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'show_post' ) ); ?>" class="rl-slider"
                   id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ); ?>"
                   value="<?php echo esc_attr( $instance['show_post'] ); ?>"/>

            <div id="slider_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>" data-attr-min="1"
                 data-attr-max="12" data-attr-step="1" class="ss-slider"></div>
            <script>
							jQuery(document).ready(function ($) {
								$('[id="slider_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ); ?>"]').slider({
									value: <?php echo esc_attr( $instance['show_post'] ); ?>,
									range: 'min',
									min  : 1,
									max  : 12,
									step : 1,
									slide: function (event, ui) {
										$('[id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ); ?>"]').val(ui.value).keyup();
									}
								});
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').on('focus', function () {
									$('[id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').trigger('blur');
								});
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').val($('[id="slider_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').slider("value"));
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').change(function () {
									$('[id="slider_<?php echo esc_attr( $this->get_field_id( 'show_post' ) ) ?>"]').slider({
										value: $(this).val()
									});
								});
							});
            </script>
        </div>
        <label class="block" for="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>">
            <span class="customize-control-title">
               <?php echo esc_html__( 'Posts offset', 'newspaper-x' ); ?> :
            </span>
        </label>

        <div class="slider-container">
            <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" class="rl-slider"
                   id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"
                   value="<?php echo esc_attr( $instance['offset'] ); ?>"/>

            <div id="slider_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>" data-attr-min="0"
                 data-attr-max="10" data-attr-step="1" class="ss-slider"></div>
            <script>
							jQuery(document).ready(function ($) {
								$('[id="slider_<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"]').slider({
									value: <?php echo esc_attr( $instance['offset'] ); ?>,
									range: 'min',
									min  : 0,
									max  : 10,
									step : 1,
									slide: function (event, ui) {
										$('[id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"]').val(ui.value).keyup();
									}
								});
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').on('focus', function () {
									$('[id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').trigger('blur');
								});
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').val($('[id="slider_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').slider("value"));
								$('[id="input_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').change(function () {
									$('[id="slider_<?php echo esc_attr( $this->get_field_id( 'offset' ) ) ?>"]').slider({
										value: $(this).val()
									});
								});
							});
            </script>
        </div>
        <div class="checkbox_switch">
				<span class="customize-control-title onoffswitch_label">
                    <?php echo esc_html__( 'Show Date and Comments', 'newspaper-x' ); ?>
				</span>
            <div class="onoffswitch">
                <input type="checkbox" id="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>"
                       name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>"
                       class="onoffswitch-checkbox"
                       value="on"
					<?php checked( $instance['show_date'], 'on' ); ?>>
                <label class="onoffswitch-label"
                       for="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>"></label>
            </div>
        </div>

	<?php }

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title']                = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['newspaper_x_category'] = ( ! empty( $new_instance['newspaper_x_category'] ) ) ? strip_tags( $new_instance['newspaper_x_category'] ) : '';
		$instance['show_post']            = ( ! empty( $new_instance['show_post'] ) ) ? absint( $new_instance['show_post'] ) : '';
		$instance['show_date']            = ( ! empty( $new_instance['show_date'] ) ) ? strip_tags( $new_instance['show_date'] ) : '';
		$instance['order']                = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';
		$instance['offset']               = ( ! empty( $new_instance['offset'] ) ) ? absint( $new_instance['offset'] ) : '';
		$instance['cols']                 = ( ! empty( $new_instance['cols'] ) ) ? strip_tags( $new_instance['cols'] ) : '';

		return $instance;

	}

	/**
	 * Proxy function to return posts
	 *
	 * @param $args
	 *
	 * @return WP_Query
	 */
	public function get_posts( $args ) {
		/**
		 * Arguments for the normal query
		 */
		$atts = array(
			'posts_per_page' => $args['show_post'],
			'offset'         => $args['offset'],
		);


		/**
		 * Grab the sticky posts
		 */
		$sticky_atts = array(
			'posts_per_page' => $args['show_post'],
			'offset'         => $args['offset'],
			'post__in'       => get_option( 'sticky_posts' ),
		);

		if ( $args['order'] == 'rand' ) {
			$atts['orderby']        = 'rand';
			$sticky_atts['orderby'] = 'rand';
		} else {
			$atts['order']          = $args['order'];
			$atts['orderby']        = 'date';
			$sticky_atts['order']   = $args['order'];
			$sticky_atts['orderby'] = 'date';
		}
		/**
		 * Grab category and add the new argument
		 */
		$idObj = get_category_by_slug( $args['newspaper_x_category'] );
		if ( $idObj ) {
			$id                 = $idObj->term_id;
			$atts['cat']        = $id;
			$sticky_atts['cat'] = $id;
		}

		/**
		 * Initiate WP Query for the sticky posts
		 */
		$sticky          = new WP_Query( $sticky_atts );
		$sticky_post_ids = array();

		/**
		 * Start adding the IDS of the sticky posts in a new array
		 */
		if ( ! empty( $sticky->posts ) ) {
			foreach ( $sticky->posts as $post ) {
				$sticky_post_ids[] = $post->ID;
			}
		}
		wp_reset_postdata();

		/**
		 * Run the normal query
		 */
		$normal_posts = new WP_Query( $atts );

		/**
		 * In case we do not have sticky posts, we terminate here and return this result
		 */
		if ( empty( $sticky->posts ) ) {
			return $normal_posts;
		}

		/**
		 * We check if the post id is in the sticky post id array, and if not - we add it to the sticky posts result
		 */
		foreach ( $normal_posts->posts as $post ) {
			if ( in_array( $post->ID, $sticky_post_ids ) ) {
				continue;
			}

			$sticky->posts[] = $post;
		}

		$sticky->posts      = array_slice( $sticky->posts, 0, (int) $args['show_post'] );
		$sticky->post_count = count( $sticky->posts );

		return $sticky;
	}

	public function widget( $args, $instance ) {

		$defaults = array(
			'order'                => 'desc',
			'offset'               => 0,
			'cols'                 => 2,
			'show_post'            => 4,
			'show_date'            => 'on',
			'newspaper_x_category' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		if ( ! empty( $instance['newspaper_x_category'] ) ) {
			$newspaper_x_category = $instance['newspaper_x_category'];
		} else {
			$instance['newspaper_x_category'] = 'uncategorized';
		}

		extract( $args, EXTR_SKIP );

		echo $before_widget;

		$filepath = get_template_directory() . '/inc/libraries/widgets/widget-newspaper-x-posts-d/layouts/default.php';

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