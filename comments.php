<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php
    comment_form(array(
        'title_reply_before' => '<div id="reply-title" class="boxFormComments__title">',
        'title_reply_after' => '</div>',
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'comment_field' => '<div class="boxFormComments__title">Коментувати</div> <textarea placeholder="Залишити відповідь" id="comment" name="comment" aria-required="true"></textarea>',
        'fields' => array(
            'author' => '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '"  placeholder="Ваше Ім’я"' . $aria_req . '/>',
            'email' => '<input  placeholder="Ваш e-mail" id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . '/>',
            'url' => '',
        ),
        'class_form' => 'boxFormComments',
        'cancel_reply_link' => __('Cancel reply')
    ));
    ?>
    <?php if (have_comments()) : ?>
        <div class="postItemComments">

            <h3 class="modulePosts__title">
                <?php
                $comments_number = get_comments_number();
                if ('1' === $comments_number) {
                    /* translators: %s: post title */
                    echo $comments_number . " Коментар";
                } else {
                    echo $comments_number . " Коментарі ";
                }
                ?>
            </h3>


            <?php
            wp_list_comments(array(
                'style' => 'div',
                'short_ping' => true,
                'avatar_size' => 42,
                'walker' => new MyWalker_Comment
            ));
            ?>


        </div>
    <?php endif; // Check for have_comments(). ?>

    <?php
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments"><?php _e('Comments are closed.', 'twentysixteen'); ?></p>
    <?php endif; ?>

</div>
