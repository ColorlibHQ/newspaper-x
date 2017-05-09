<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Newspaper X
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <div class="comments-form">
        <div class="container">
            <div class="col-md-8">
                <?php

                // If comments are closed and there are comments, let's leave a little note, shall we?
                if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

                    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'newspaper-x' ); ?></p>
                    <?php
                endif;

                comment_form();
                ?>
            </div>
        </div>
    </div>
</div><!-- #comments -->
