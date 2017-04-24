

	<?php  ?>

	<?php if ( ! empty( $instance['title'] ) ) {
		echo '<h3 class="widget-title">'. esc_html( $instance['title'] ).'</h3>' ;
	}
	var_dump($instance['address']);
	?>

	<div class="textwidget contact-widget">
		<?php if(!empty($instance['phone'])){ ?>
			<div><span>Phone:</span> <a href="tel:#"></a></div>
		<?php
			}elseif (!empty($instance['email'])){
		 ?>
			<div><span>Email:</span> <a href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a></div>
		<?php
			}elseif (!empty($instance['address'])){
		 ?>
			<div><span>Address:</span></div>
		<?php }?>
		<div>
			<ul class="social-contact">
				<li class="facebook"><a href=""><i class="fa fa-facebook"></i></a></li>
				<li class="tumblr"><a href=""><i class="fa fa-tumblr"></i></a></li>
				<li class="twitter"><a href=""><i class="fa fa-twitter"></i></a></li>
				<li class="gplus"><a href=""><i class="fa fa-google-plus"></i></a></li>
				<li class="youtube"><a href=""><i class="fa fa-youtube-play"></i></a></li>
			</ul>
		</div>

	</div>
