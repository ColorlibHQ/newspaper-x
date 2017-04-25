<div class="col-md-4 col-xs-6">
	<div class="newspaper-x-blog-post-layout-b border">
		<div class="row">
			<div class="newspaper-x-image">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php echo wp_kses( $new_image, $allowed_tags ); ?>
				</a>
			</div>
			<div class="newspaper-x-title">
				<h4>
					<a href="<?php echo get_the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 8 ); ?></a>
				</h4>
			</div>

			<?php if ( $instance['show_date'] ): ?>
				<span class="newspaper-x-author">
					<a href="/author/<?php echo the_author_meta( 'nickname'); ?> "><?php echo esc_html( get_the_author()); ?></a> 
				</span>
				<span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
			<?php endif; ?>

			<div class="newspaper-x-content">
				<?php echo wp_trim_words( wp_kses_post( get_the_content() ), 16, ' <a href="' . esc_url( get_the_permalink() ) . '">...</a>' ) ?>
			</div>
		</div>
	</div>
</div>