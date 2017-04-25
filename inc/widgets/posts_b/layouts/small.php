<div class="row">
	<div class="col-sm-5 col-xs-12">
		<div class="newspaper-x-image">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>">
				<?php echo wp_kses( $new_image, $allowed_tags ); ?>
			</a>
		</div>
	</div>
	<div class="col-sm-7 col-xs-12">
		<div class="newspaper-x-title">
			<h3>
				<a href="<?php echo get_the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 8 ); ?></a>
			</h3>
		</div>
		<?php if ( $instance['show_date'] ): ?>
			<span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
		<?php endif; ?>
	</div>
</div>