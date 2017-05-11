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
        <div class="avatar text-center">
            <img src="<?php echo get_avatar_url (get_the_author_meta( 'ID' ),array('size' => 75))?>" />
        </div>
        <div class="description">
            <h6><?php echo get_the_author_posts_link(); ?></h6>
            <!-- Short Description -->
            <p><?php the_author_meta( 'description' ); ?></p>
        </div>
        <?php Newspaper_X_Profile_Fields::echo_social_media(); ?>
    </div>
    <!-- .Author description -->
<?php } ?>
