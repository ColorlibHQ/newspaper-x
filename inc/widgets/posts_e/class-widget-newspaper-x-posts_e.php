<?php

class Widget_Newspaper_X_Posts_E extends WP_Widget {

    function __construct() {

        add_action( 'admin_init', array( $this, 'enqueue' ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'customize_preview_init', array( $this, 'enqueue' ) );

        parent::__construct( 'newspaper_x_widget_posts_e', esc_html__( 'Newspaper X - Banners', 'newspaper-x' ), array(
            'classname'                   => 'newspaper_x_widgets',
            'description'                 => esc_html__( 'Layout consists of a featured post thumbnail, followed by a handful of posts that are smaller in size. Perfect for emphasising important news.', 'newspaper-x' ),
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
                   value="<?php echo esc_attr( $instance['title']); ?>">
        </p>


    <?php }

    public function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance['title']                = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;

    }


    public function widget( $args, $instance ) {

        $defaults = array(
            'title'            => 'Banners'
        );
        $instance = wp_parse_args( (array) $instance, $defaults );


        echo $args['before_widget'];

        $filepath = get_template_directory() . '/inc/widgets/posts_e/layouts/default.php';

        if ( file_exists( $filepath ) ) {
            include $filepath;
        } else {
            echo esc_html__( 'Please configure your widget', 'newspaper-x' );
        }

        echo $args['after_widget'];
    }

}