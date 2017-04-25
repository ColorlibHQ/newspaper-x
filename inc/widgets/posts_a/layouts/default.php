<?php
$i = 0;
if ( $posts->have_posts() ): ?>
	<?php if ( ! empty( $instance['title'] ) ) {
		echo $before_title . esc_html( $instance['title'] ) . $after_title;
	}
	?>
	<div class="row newspaper-x-layout-a-row">
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
			?>
			<div class="col-sm-3 col-xs-6">
				<div class="newspaper-x-blog-post-layout-a">
					<div class="newspaper-x-image">
						<a href="<?php echo esc_url( get_the_permalink() ); ?>">
							<?php echo wp_kses( $new_image, $allowed_tags ); ?>
						</a>
					</div>
					<div class="newspaper-x-title">
						<h3>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo wp_trim_words( esc_html( get_the_title() ), 9 );
								?></a></h3>
					</div>
					<?php if ( $instance['show_date'] ): ?>
						<span class="newspaper-x-author">
							<a href="/author/<?php echo the_author_meta( 'nickname'); ?> "><?php echo esc_html( get_the_author()); ?></a> 
						</span>
						<span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
					<?php endif; ?>
					<div class="newspaper-x-content-a">
						<?php echo wp_trim_words( wp_kses_post( get_the_content() ), 15, ' <a href="' . esc_url( get_the_permalink() ) . '">...</a>' ) ?>
					</div>
				</div>
			</div>
			<?php

			if ( fmod( $i, (int) 4 ) == 0 && $i != (int) $posts->post_count ) {
				echo '</div><div class="row newspaper-x-layout-a-row">';
			} elseif ( $i == (int) $posts->post_count ) {
				continue;
			}

			?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>