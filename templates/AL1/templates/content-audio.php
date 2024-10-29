<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 16.01.15 * Time: 13:09 */ ?><article id="post-<?php the_ID(); ?>" class="b-posts_item"><?php if ( has_post_thumbnail() ): ?><div class="b-posts_item_canvas"><?php the_post_thumbnail(); ?></div><?php endif; ?><div class="b-posts_item_content <?php if ( has_post_thumbnail() ): ?>b-posts_item_other<?php endif; ?>"><header class="entry-header"><h3><a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php the_title(); ?></a></h3><p><?php the_time( get_option('date_format') ); ?>,&nbsp;<?php the_author_posts_link(); ?>&nbsp;<?php _e('has blogged', 'ssdma'); ?>&nbsp;<?php the_author_posts(); ?>&nbsp;<?php _e('posts', 'ssdma'); ?></p></header><div class="entry-summary"><?php the_excerpt(); ?></div><?php if( get_the_tags() ): ?><footer class="entry-meta"><span class="b-social-icon-tag"></span>&nbsp;&nbsp;<?php the_tags('',', ',''); ?></footer><?php endif; ?></div></article>