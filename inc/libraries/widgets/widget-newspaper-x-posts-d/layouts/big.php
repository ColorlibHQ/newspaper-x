<div class="col-md-6 col-xs-6  <?php if ( is_active_sidebar('sidebar-homepage') ) { echo 'newspaper-x-post-d-sidebar';} ?>">
    <div class="newspaper-x-blog-post-layout-b border">
        <div class="row">
            <div class="col-sm-4 col-xs-12">
                <div class="newspaper-x-image">
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                        <?php echo wp_kses( $new_image, $allowed_tags ); ?>
                    </a>
                </div>
            </div>
            <div class="col-sm-7 col-xs-12 card-info">
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
            </div>
        </div>
    </div>
</div>
<?php
if ( fmod( $i, (int) 2 ) == 0 && $i != (int) $posts->post_count )  {
    echo '</div><div class="row newspaper-x-layout-b-row">';
}
?>