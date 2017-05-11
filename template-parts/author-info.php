<?php
/**
 * Template part for displaying author info.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */
// Grab the current author
$curauth        = get_userdata( $post->post_author );
$enabled_author = get_theme_mod( 'newspaper_x_enable_author_box', true );
$url            = get_the_author_meta( 'url' );
if ( is_single() && ! empty( $curauth->description ) && $enabled_author ) { ?>
    <!-- Author description -->
    <div class="row author-description">
        <!-- Avatar -->
        <div class="col-md-2 tpl-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 85 ); ?>
        </div>
        <!-- .Avatar -->
        <!-- Short Description -->
        <div class="col-md-10" itemscope="" itemtype="http://schema.org/Person">
            <h4 class="post-author"><?php echo get_the_author_posts_link(); ?></h4>

			<?php if ( ! empty( $url ) ): ?>
                <a class="post-author-website" href="<?php echo esc_url( get_the_author_meta( 'url' ) ) ?>"><?php echo
					get_the_author_meta( 'url' ) ?></a>
			<?php endif; ?>

			<?php Newspaper_X_Profile_Fields::echo_social_media(); ?>
            <p><?php the_author_meta( 'description' ); ?></p>
        </div>
        <!-- .Short Description -->
    </div>
    <!-- .Author description -->
<?php } ?>
