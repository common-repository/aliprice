<?php
global $ali3;
$cat_id = ($ali3->ssdma_products_cat5) ? $ali3->ssdma_products_cat5: 0;
ssdma_posts_process('products', array('posts_per_page' => 12), $cat_id); ?>
    <h2 class="text-header text-header-strike b-products__min">
        <?php if($cat_id): ?><span><a href="<?php the_term_link($cat_id); ?>">
                <?php the_term_title($cat_id); ?></a></span>
        <?php else: ?><span><a href="<?php echo esc_url(home_url( '/products' )); ?>">
                <?php _e('Featured', 'ssdma') ?></a>
            </span><?php endif; ?></h2>
    <div class="b-products b-products__min clearfix">
<?php while ( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/product' ); ?>
<?php endwhile; ?></div><?php wp_reset_query(); ?>