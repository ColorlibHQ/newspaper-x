<?php
/**
 * Template part for displaying pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */
$breadcrumbs_enabled = get_theme_mod( 'newspaper_x_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled ) {
    newspaper_x_breadcrumbs();
}
?>
<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php

        the_title( '<h1 class="entry-title">', '</h1>' );

        ?>
        <div class="newspaper-x-image">
            <?php
            if ( has_post_thumbnail() ) {
                $image = is_single() ? get_the_post_thumbnail( get_the_ID(), 'newspaper-x-single-post' ) : get_the_post_thumbnail( get_the_ID(), 'newspaper-x-recent-post-big' );
                $image_obj = array( 'id' => get_the_ID(), 'image' => $image );
                $new_image = apply_filters( 'newspaper_x_widget_image', $image_obj );

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

                echo ! is_page() ? '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' : '';

                echo wp_kses( $new_image, $allowed_tags );

                echo ! is_page() ? '</a>' : '';
            }
            ?>
        </div>
        <?php
        if ( ! is_page() ) {
            echo '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . wp_trim_words( get_the_title(), 8 ) . '</a></h4>';
        }
        if ( 'post' === get_post_type() ) : ?>
            <div class="newspaper-x-post-meta">
                <?php Newspaper_X_Helper::posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php
        endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
        if ( is_page() ) {
            the_content();

            wp_link_pages( array(
                'before' => '<ul class="newspaper-x-pager">',
                'after'  => '</ul>',
            ) );

            $prev = get_previous_post_link();
            $prev = str_replace( '&laquo;', '<span class="fa fa-caret-left"></span>', $prev );
            $next = get_next_post_link();
            $next = str_replace( '&raquo;', '<span class="fa fa-caret-right"></span>', $next );
            ?>
            <div class="newspaper-x-next-prev row">
                <div class="col-md-6 text-left">
                    <?php echo $prev ?>
                </div>
                <div class="col-md-6 text-right">
                    <?php echo $next ?>
                </div>
            </div>
            <?php
        } else {
            echo '<p class="archive" >' . wp_trim_words( get_the_content( esc_html__( 'Read More', 'newspaper-x' ) ), 35 ) . '</p>';
        }

        ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->

