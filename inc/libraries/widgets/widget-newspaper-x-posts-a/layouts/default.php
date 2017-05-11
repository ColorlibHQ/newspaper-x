<?php
$i = 0;
if ( $posts->have_posts() ): ?>
    <?php if ( ! empty( $instance['title'] ) ) {
        echo $before_title . esc_html( $instance['title'] ) . $after_title;
    }
    ?>

    <div class="site-content newspaper-spacer-a">
        <div class="row">
            <div class="col-md-12">
                <div class="newspaper-x-recent-posts newspaper-x-recent-posts-a">
                    <ul>
                        <?php while ( $posts->have_posts() ) : $posts->the_post();
                            $i ++;

                            $cat         = get_the_category();
                            $cat_link    = get_category_link( $cat[0]->term_id );
                            $cat         = $cat[0]->name;
                            $image       = get_template_directory_uri() . '/assets/images/picture_placeholder.jpg';
                            $placeholder = $image;
                            $h= 'h6';


                            if ( has_post_thumbnail() ) {
                                $src = wp_get_attachment_image_src( get_post_thumbnail_id(),
                                    'newspaper-x-recent-post-big',
                                    false,
                                    '' );

                                $srcsmall = wp_get_attachment_image_src( get_post_thumbnail_id(),
                                    'newspaper-x-recent-post-list-image',
                                    false,
                                    '' );

                                $image       = $src[0];
                                $placeholder = $srcsmall[0];
                            }
                            ?>

                            <li class="blazy <?php if ( is_active_sidebar('sidebar-homepage') ) { echo 'newspaper-x-post-sidebar';} ?>" id="newspaper-x-recent-post-4" data-src="<?php echo esc_url( $image ) ?>"
                                style="background-image:url('<?php echo esc_url( $placeholder ) ?>')">
                                <div class="newspaper-x-post-info">
                                    <h6>
                                        <a href="<?php echo esc_url( get_permalink() ) ?>">
                                            <?php echo wp_trim_words( get_the_title(), 6 ); ?>
                                        </a>
                                    </h6>
                                    <span class="newspaper-x-category">
										<a href="<?php echo esc_url( $cat_link ) ?>"><?php echo esc_html( $cat ) ?></a> 
									</span>
                                    <?php if ( $instance['show_date'] ): ?>
                                        <span class="newspaper-x-date"><?php echo esc_html( get_the_date() ) ?></span>
                                    <?php endif; ?>
                                </div>
                            </li>

                            <?php
                            if ( fmod( $i, (int) 4 ) == 0 && $i != (int) $posts->post_count ) {
                                echo '<ul></div><div class="newspaper-x-recent-posts newspapper-spacer"><ul>';
                            } elseif ( $i == (int) $posts->post_count ) {
                                continue;
                            }
                        endwhile;
                        ?>
                    </ul>
                </div> <!-- recent posts-->
            </div> <!-- col-md-12 -->
        </div> <!-- row -->
    </div> <!-- posts a-->
<?php endif; ?>