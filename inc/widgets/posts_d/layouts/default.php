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
					<li class="facebook"><a href="<?php echo $instance['facebook']; ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(!empty($instance['tumblr'])){ ?>	
					<li class="tumblr"><a href="<?php echo $instance['tumblr']; ?>"><i class="fa fa-tumblr"></i></a></li>
				<?php } ?>
				<?php if(!empty($instance['twitter'])){ ?>
					<li class="twitter"><a href="<?php echo $instance['twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(!empty($instance['gplus'])){ ?>
					<li class="gplus"><a href="<?php echo $instance['gplus']; ?>"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(!empty($instance['youtube'])){ ?>
					<li class="youtube"><a href="<?php echo $instance['youtube']; ?>"><i class="fa fa-youtube-play"></i></a></li>
				<?php } ?>
			</ul>
		</div>

	</div>
