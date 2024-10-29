<?php get_header(); ?>
    <div class="container base-mar-t-20">
        <?php get_template_part( 'templates/breadcrumbs' ); ?>
        <div class="clearfix"></div>
        <div class="grid-277 clearfix">
            <?php get_sidebar(); ?>
        </div>
        <div class="grid-900 grid-m-23 clearfix">
            <?php get_template_part( 'templates/filter' ); ?>
            <div class="text-header text-header__bg-blue base-mar-t-20">
                <?php get_template_part( 'templates/sort' ); ?>
            </div>

            <?php if ( have_posts() ): ?>
                <?php

                    global $info, $todays, $hotdeal;

                    $info   = new AEProducts();
                    $todays = (get_option('aliprice-todaysdeal')) ? get_option('aliprice-todaysdeal') : '';
                    $hotdeal = (get_option('aliprice-hotdeal')) ? get_option('aliprice-hotdeal') : '';

                ?>
                <div class="b-products text-md-left text-sm-center text-xs-center base-mar-b-20">
                    <?php while ( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/product' ); ?><?php endwhile; ?></div><div class="text-center"><?php ssdma_paging_nav(); ?></div><?php else: ?><?php get_template_part( 'templates/content', 'none' ); ?><?php endif; ?></div><div class="clearfix"></div></div><?php get_template_part( 'templates/footer-before' ); ?><?php get_footer(); ?>