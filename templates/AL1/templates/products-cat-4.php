<?php
global $ali1;
 $cat_id = ($ali1->ssdma_products_cat4) ? $ali1->ssdma_products_cat4: 0;
ssdma_posts_process('products', array('posts_per_page' => 2), $cat_id); ?>
<h2 class="text-header th-products-mini">
<a href="<?php the_term_link($cat_id); ?>"><?php the_term_title($cat_id); ?></a>
</h2>
<div class="products-mini clearfix">
<?php while ( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/product-min' ); ?><?php endwhile; ?>
</div>
<?php wp_reset_query(); ?>