<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 09.02.15 * Time: 17:31 */ ?>
    <?php get_header(); ?>
    <div class="container">
        <?php get_template_part( 'templates/breadcrumbs' ); ?>

        <div class="b-grid-a-left b-margin-base">
            <?php get_template_part( 'templates/filter' ); ?>
        </div>
        <div class="b-grid-a-right b-margin-base">
            <?php get_template_part( 'templates/sort' ); ?>

            <?php if ( have_posts() ): ?>
                <div class="b-products b-products__min">

                    <?php
                        global $info, $todays, $hotdeal;

                        $info   = new AEProducts();

                        $todays = (get_option('aliprice-todaysdeal')) ? get_option('aliprice-todaysdeal') : '';
                        $hotdeal = (get_option('aliprice-hotdeal')) ? get_option('aliprice-hotdeal') : '';

                        while ( have_posts() ) : the_post();

                            $post_id = get_the_ID();

                            $info->set($post_id);

                            get_template_part( 'templates/product' );

                        endwhile;

                    ?>
                </div>
                <div class="text-center">
                    <?php ssdma_paging_nav(); ?>
                </div>
            <?php else: ?>
                <?php get_template_part( 'templates/content', 'none' ); ?>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer(); ?>