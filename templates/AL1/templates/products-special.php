<?php

    global $info, $todays, $hotdeal;

    $info = new AEProducts();
    $todays = (get_option('aliprice-todaysdeal')) ? get_option('aliprice-todaysdeal') : '';
    $hotdeal = (get_option('aliprice-hotdeal')) ? get_option('aliprice-hotdeal') : '';

    $post_ids = $info->specials(8);

    ssdma_posts_process('products', array('posts_per_page' => 8, 'post__in' => $post_ids));
?>
<div class="b-products">
    <?php

        while (have_posts()) : the_post();

            $post_id = get_the_ID();

            $info->set($post_id);

            get_template_part('templates/product');

        endwhile;
    ?>
</div><?php wp_reset_query(); ?>