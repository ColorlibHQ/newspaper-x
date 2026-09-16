<?php if ( ! empty( $instance['title'] ) ) {
    echo '<h3 class="widget-title">'. esc_html( $instance['title'] ).'</h3>' ;
}?>

<div class="textwidget contact-widget">
    <?php if(!empty($instance['phone'])){ ?>
        <div><span><?php echo esc_html__( 'Phone:', 'newspaper-x' ) ?></span> <a href="tel:<?php echo esc_attr( $instance['phone'] ); ?>"><?php echo esc_html( $instance['phone'] ); ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['email'])){ ?>
        <div><span><?php echo esc_html__( 'Email:', 'newspaper-x' ) ?></span> <a href="<?php echo esc_url( 'mailto:' . $instance['email'], array( 'mailto' ) ); ?>"><?php echo esc_html( $instance['email'] ); ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['address'])){ ?>
        <div><span><?php echo esc_html__( 'Address:', 'newspaper-x' ) ?></span> <?php echo esc_html( $instance['address'] ); ?></div>
    <?php }
    $social_menu = ! empty( $instance['social_menu'] ) ? wp_get_nav_menu_object( $instance['social_menu'] ) : false;
            if ( $social_menu ) {
                
                // The id has to be unique: this widget can be placed in more
                // than one area, and a fixed id produced duplicates. Styling
                // hangs off the class instead.
                $social_menu_args = array(
                    'fallback_cb'       => '',
                    'menu'              => $social_menu,
                    'menu_id'           => 'social-contact-' . $this->id,
                    'menu_class'        => 'newspaper-x-social-contact',
                    'container_class'   => 'author-social-menu',
                    'link_before'       => '<span>',
                    'link_after'        => '</span>'
                );
                wp_nav_menu( $social_menu_args );
            }
    ?>

</div>
