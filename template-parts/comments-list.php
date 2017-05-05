<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open()) :
    global $post_id;
    $args = array(
        'status'  => 'all',
        'number'  => '5',
        'post_id' => $post_id
    );

    $comments = get_comments($args);
    if ($comments):
        foreach($comments as $comment) :
            ?>
            <div class="comments-list row">
                <div class="avatar text-center">
                    <img src="<?php echo get_avatar_url($comment->user_id,array('size' => 75))?>" />
                </div>
                <div class="comment">
                    <h6><?php echo $comment->comment_author; ?></h6>
                    <p><?php echo $comment->comment_content; ?></p>
                </div>
                    <?php echo echo_social_media();?>
            </div>
            <?php
        endforeach;
    endif; // Check if are comments.
endif; // Check if comments are open.
?>


