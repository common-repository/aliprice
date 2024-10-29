<?php
/**
 * HTML comment list class.
 *
 * @package Ghost
 * @uses Walker
 * @since 1.0
 */
class wp_bootstrap_comments_walker extends Walker_Comment 
{
	/**
     * Start the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of comment.
     * @param array $args Uses 'style' argument for type of HTML list.
     */
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $GLOBALS['comment_depth'] = $depth + 1;
        switch ( $args['style'] ) {
            case 'div':
                    break;
            case 'ol':
                    $output .= '<ol class="media children">' . "\n";
                    break;
            default:
            case 'ul':
                    $output .= '<ul class="media children">' . "\n";
                    break;
        }
    }

    /**
    * Output a single comment.
    *
    * @access protected
    * @since 3.6.0
    *
    * @param object $comment Comment to display.
    * @param int    $depth   Depth of comment.
    * @param array  $args    An array of arguments. @see wp_list_comments()
    */
    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
                $tag = 'div';
                $add_below = 'comment';
        } else {
                $tag = 'li';
                $add_below = 'div-comment';
        }

        $class = empty( $args['has_children'] ) ? '' : 'parent';
        ?>

        <<?php echo $tag; ?> <?php comment_class( array($class, 'media') ); ?> id="comment-<?php comment_ID(); ?>">
        
            <a class="pull-left" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            </a>

            <?php if ( 'div' != $args['style'] ) : ?>
                <div class="media-body">
            <?php endif; ?>

            <h4 class="media-heading">
                <?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>                
                <span class="says">says:</span>
            </h4>

            <span>
                <?php printf( __('%1$s at %2$s', 'ssdma'), get_comment_date(),  get_comment_time()); ?>
                <?php edit_comment_link(__('(Edit)', 'ssdma'),'  ','' ); ?>
            </span>

            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', 'ssdma') ?></em>
            <?php endif; ?>

            <div class="reply">
                <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>

            <p><?php comment_text() ?></p>

            <?php if ( 'div' != $args['style'] ) : ?>
                </div>
            <?php endif; ?>

        <?php
    }

}