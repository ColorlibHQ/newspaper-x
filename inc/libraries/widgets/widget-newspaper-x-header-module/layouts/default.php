<?php if ( $posts->have_posts() ): $i = 0; ?>
    <div class="newspaper-x-recent-posts <?php echo ( $args['id'] === 'header-widget-area' ) ? 'container' : '' ?>">
		<?php
		if ( $instance['title'] ): ?>
            <h3 class="page-title"><span><?php echo wp_kses_post( $instance['title'] ) ?></M></span></h3>
		<?php endif; ?>
        <ul>
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
				<?php
				$cat         = get_the_category( get_the_ID() );
				$cat_link    = get_category_link( $cat[0]->term_id );
				$cat         = $cat[0]->name;
				$image       = get_template_directory_uri() . '/assets/images/picture_placeholder.jpg';
				$placeholder = $image;
				$h           = 'h6';
				if ( has_post_thumbnail() ) {
					$src         = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),
					                                            'newspaper-x-recent-post-big',
					                                            false,
					                                            '' );
					$srcsmall    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),
					                                            'newspaper-x-recent-post-list-image',
					                                            false,
					                                            '' );
					$image       = $src[0];
					$placeholder = $srcsmall[0];
				}

				if ( $i == 0 ) {
					$h = 'h1';
				}
				?>
                <li class="blazy" id="newspaper-x-recent-post-<?php echo $i; ?>"
                    data-src="<?php echo esc_url( $image ) ?>"
                    style="background-image:url('<?php echo esc_url( $placeholder ) ?>')">
                    <div class="newspaper-x-post-info">
                        <<?php echo $h; ?>>
                        <a href="<?php echo esc_url( get_permalink( get_the_ID() ) ) ?>">
							<?php echo wp_kses_post( wp_trim_words( get_the_title(), 6, $more = '&hellip;' ) ) ?>
                        </a>
                    </<?php echo $h; ?>>
                    <span class="newspaper-x-category">
                            <a href="<?php echo esc_url( $cat_link ) ?>"><?php echo esc_html( $cat ) ?></a>
                        </span>
                    <span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
                </li>
				<?php $i ++; ?>
			<?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>

