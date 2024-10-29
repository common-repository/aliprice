<?php
global $ali2;
$cat_id = ($ali2->ssdma_products_cat1) ? $ali2->ssdma_products_cat1 : 0;
ssdma_posts_process('products', array('posts_per_page' => 8), $cat_id); ?>
    <div class="text-header text-header__bg-blue"><h2><a
            href="<?php the_term_link($cat_id); ?>"><?php the_term_title($cat_id); ?></a></h2></div>
    <div
        class="b-products base-mar-b-20 text-md-left text-sm-center text-xs-center"><?php while (have_posts()) : the_post(); ?><?php get_template_part('templates/product'); ?><?php endwhile; ?></div><?php wp_reset_query(); ?>