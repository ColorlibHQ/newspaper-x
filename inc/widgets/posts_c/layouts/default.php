<?php
$i = 0;
if ( $posts->have_posts() ): ?>
	<?php if ( ! empty( $instance['title'] ) ) {
		echo $before_title . esc_html( $instance['title'] ) . $after_title;
	}
	?>
    <div class="row newspaper-x-layout-c-row">
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
            <div class="col-md-4 col-xs-6">
                <div class="newspaper-x-blog-post-layout-c">

                    <div class="newspaper-x-image">
                        <a href="<?php echo esc_url( get_the_permalink() ); ?>">
							<?php echo wp_kses( $new_image, $allowed_tags ); ?>
                        </a>
                    </div>
                    <div class="newspaper-x-title">
                        <h3>
                            <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo wp_trim_words( wp_kses_post( get_the_title() ), 8 ); ?></a>
                        </h3>
                    </div>

					<?php if ( $instance['show_date'] ): ?>
                        <div class="newspaper-x-post-meta">
							<?php echo Newspaper_X_Helper::get_post_meta( get_the_ID() ) ?>
                        </div>
					<?php endif; ?>

                    <div class="newspaper-x-content">
						<?php echo wp_kses_post( get_the_excerpt() ); ?>
                    </div>
                </div>
            </div>
			<?php

			if ( fmod( $i, (int) 3 ) == 0 && $i != (int) $posts->post_count ) {
				echo '</div><div class="row newspaper-x-layout-c-row">';
			} elseif ( $i == (int) $posts->post_count ) {
				continue;
			}

			?>
		<?php endwhile; ?>
    </div>
<?php endif; ?>