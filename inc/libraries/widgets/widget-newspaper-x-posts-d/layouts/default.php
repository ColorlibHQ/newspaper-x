<?php
$i = 0;
$big = get_template_directory() . '/inc/libraries/widgets/widget-newspaper-x-posts-d/layouts/big.php';
$small = get_template_directory() . '/inc/libraries/widgets/widget-newspaper-x-posts-d/layouts/small.php';
if ( $posts->have_posts() ): ?>
    <?php if ( ! empty( $instance['title'] ) ) {
        echo $before_title . esc_html( $instance['title'] ) . $after_title;
    }
    ?>
    <div class="row newspaper-x-layout-b-row">
        <?php while ( $posts->have_posts() ) : $posts->the_post();
            $i ++;
            $image = '<img class="attachment-newspaper-x-recent-post-big size-newspaper-x-recent-post-big wp-post-image" alt="" src="' . get_template_directory_uri() . '/assets/images/picture_placeholder.jpg" />';
            if ( has_post_thumbnail() ) {
                $image = get_the_post_thumbnail( get_the_ID(), 'newspaper-x-recent-post-big' );
            }

            $image_obj    = array( 'id' => get_the_ID(), 'image' => $image );
            $new_image    = apply_filters( 'newspaper_x_widget_image', $image_obj );
            $allowed_tags = array(
                'img'      => array(
                    'data-srcset' => true,
                    'data-src'    => true,
                    'srcset'      => true,
                    'sizes'       => true,
                    'src'         => true,
                    'class'       => true,
                    'alt'         => true,
                    'width'       => true,
                    'height'      => true
                ),
                'noscript' => array()
            );
            if($instance['cols'] == '3'){
                if ( file_exists( $small ) ) {
                    include $small;
                } else {
                    echo esc_html__( 'Please configure your widget', 'newspaper-x' );
                }
            }else{
                if ( file_exists( $big ) ) {
                    include $big;
                } else {
                    echo esc_html__( 'Please configure your widget', 'newspaper-x' );
                }
            }



            ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>