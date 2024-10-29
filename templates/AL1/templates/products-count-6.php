<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 10.02.15 * Time: 19:45 */
global $post;
$cat_id = $post->post_parent;
$terms = wp_get_post_terms($post->ID, 'shopcategory');
$term = 0;
if ($terms && is_array($terms) & count($terms) > 0) {
    $term = array_pop($terms);
    if ($term) {
        $cat_id = $term->term_id;
    }
}
ssdma_posts_process('products', array('posts_per_page' => 6), $cat_id); ?><?php if (have_posts()): ?><?php while (have_posts()) : the_post(); ?><?php get_template_part('templates/product'); ?><?php endwhile; ?><?php else: ?><?php get_template_part('templates/content', 'none'); ?><?php endif; ?><?php wp_reset_query(); ?>