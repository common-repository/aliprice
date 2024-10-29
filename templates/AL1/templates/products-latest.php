<?php ssdma_posts_process('products', array('posts_per_page' => 8, 'orderby' => 'ID', 'order' => 'DESC')); ?>
    <div class="b-products">
        <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('templates/product'); ?>
        <?php endwhile; ?>
    </div>
<?php wp_reset_query(); ?>