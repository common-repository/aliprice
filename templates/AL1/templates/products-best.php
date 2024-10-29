<?php
    global $info;

    $post_ids = $info->bestSellers(8);

    ssdma_posts_process('products', array( 'posts_per_page' => 8, 'post__in' => $post_ids ));
?>
    <div class="b-products">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'templates/product' ); ?>
        <?php endwhile; ?>
    </div>

<?php wp_reset_query(); ?>