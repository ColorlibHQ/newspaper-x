<?php if ( ! empty( $instance['title'] ) ) {
    echo '<h3 class="widget-title">'. esc_html( $instance['title'] ).'</h3>' ;
}?>

<div class="textwidget contact-widget">
    <?php if(!empty($instance['phone'])){ ?>
        <div><span><?php echo esc_html__( 'Phone:', 'newspaper-x' ) ?></span> <a href="tel:<?php echo $instance['phone']; ?>"><?php echo $instance['phone']; ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['email'])){ ?>
        <div><span><?php echo esc_html__( 'Email:', 'newspaper-x' ) ?></span> <a href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['address'])){ ?>
        <div><span><?php echo esc_html__( 'Address:', 'newspaper-x' ) ?></span> <?php echo $instance['address']; ?></div>
    <?php }?>
    <div>
        <ul class="social-contact">
            <?php if(!empty($instance['facebook'])){ ?>
                <li><a href="<?php echo $instance['facebook']; ?>"  class="facebook"><i class="fa fa-facebook"></i></a></li>
            <?php } ?>
            <?php if(!empty($instance['tumblr'])){ ?>
                <li><a href="<?php echo $instance['tumblr']; ?>"  class="tumblr"><i class="fa fa-tumblr"></i></a></li>
            <?php } ?>
            <?php if(!empty($instance['twitter'])){ ?>
                <li><a href="<?php echo $instance['twitter']; ?>"  class="twitter"><i class="fa fa-twitter"></i></a></li>
            <?php } ?>
            <?php if(!empty($instance['gplus'])){ ?>
                <li><a href="<?php echo $instance['gplus']; ?>"  class="gplus"><i class="fa fa-google-plus"></i></a></li>
            <?php } ?>
            <?php if(!empty($instance['youtube'])){ ?>
                <li><a href="<?php echo $instance['youtube']; ?>"  class="youtube"><i class="fa fa-youtube-play"></i></a></li>
            <?php } ?>
        </ul>
    </div>

</div>
