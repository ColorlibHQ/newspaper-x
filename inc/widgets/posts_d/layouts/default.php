<?php if ( ! empty( $instance['title'] ) ) {
    echo '<h3 class="widget-title">'. esc_html( $instance['title'] ).'</h3>' ;
}?>

<div class="textwidget contact-widget">
    <?php if(!empty($instance['phone'])){ ?>
        <div><span>Phone:</span> <a href="tel:<?php echo $instance['phone']; ?>"><?php echo $instance['phone']; ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['email'])){ ?>
        <div><span>Email:</span> <a href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></div>
    <?php } ?>
    <?php if(!empty($instance['address'])){ ?>
        <div><span>Address:</span> <?php echo $instance['address']; ?></div>
    <?php }?>
    <div>
        <ul class="social-contact">
            <?php if(!empty($instance['facebook'])){ ?>
                <a href="<?php echo $instance['facebook']; ?>"><li class="facebook"><i class="fa fa-facebook"></i></li></a>
            <?php } ?>
            <?php if(!empty($instance['tumblr'])){ ?>
                <a href="<?php echo $instance['tumblr']; ?>"><li class="tumblr"><i class="fa fa-tumblr"></i></li></a>
            <?php } ?>
            <?php if(!empty($instance['twitter'])){ ?>
                <a href="<?php echo $instance['twitter']; ?>"><li class="twitter"><i class="fa fa-twitter"></i></li></a>
            <?php } ?>
            <?php if(!empty($instance['gplus'])){ ?>
                <a href="<?php echo $instance['gplus']; ?>"><li class="gplus"><i class="fa fa-google-plus"></i></li></a>
            <?php } ?>
            <?php if(!empty($instance['youtube'])){ ?>
                <a href="<?php echo $instance['youtube']; ?>"><li class="youtube"><i class="fa fa-youtube-play"></i></li></a>
            <?php } ?>
        </ul>
    </div>

</div>
