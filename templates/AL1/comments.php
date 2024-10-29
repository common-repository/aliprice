<?php /** * The template for displaying Comments * * The area of the page that contains comments and the comment form. * * @package Ghost * @subpackage Ghost * @since Ghost 1.0 */ /* * If the current post is protected by a password and the visitor has not yet * entered the password we will return early without loading the comments. */
if (post_password_required()) {
    return;
}
if (is_singular()) {
    wp_enqueue_script('comment-reply');
} ?>
<?php if (comments_open()) : ?>
    <div class="clearfix"></div>
    <div class="comments-link">
        <?php comments_popup_link('<span class="leave-reply">' . __('Leave a reply', 'ssdma') . '</span>', __('1 Reply', 'ssdma'), __('% Replies', 'ssdma')); ?>
    </div>
<?php endif; ?>
<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <hr>
        <h2 class="comments-title">
            <?php printf(_n('One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'ssdma'), number_format_i18n(get_comments_number()), get_the_title()); ?></h2>
        <hr>
        <ol class="media-list">
        <?php wp_list_comments(array('walker' => new wp_bootstrap_comments_walker())); ?>
        </ol><?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation"><h1
                class="screen-reader-text"><?php _e('Comment navigation', 'ssdma'); ?></h1>

            <div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'ssdma')); ?></div>
            <div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'ssdma')); ?></div>
            </nav><?php endif; ?><?php if (!comments_open()) : ?><p
            class="no-comments"><?php _e('Comments are closed.', 'ssdma'); ?></p><?php endif; ?><?php endif; ?>
    <hr><?php ssdma_comment_form(); ?></div>