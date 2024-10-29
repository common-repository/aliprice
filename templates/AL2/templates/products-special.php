<?php

    global $info;
    $info     = new AEProducts();
    $post_ids = $info->specials( 8 );
    ssdma_posts_process( 'products', array( 'posts_per_page' => 8, 'post__in' => $post_ids ) ); ?>

    <div class="text-header text-header__bg-blue"><h3><?php _e( 'Special', 'ssdma' ); ?></h3></div>
	<div class="b-products text-md-left text-sm-center text-xs-center base-mar-b-20">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'templates/product' ); ?>
        <?php endwhile; ?>
    </div>

<?php wp_reset_query(); ?>