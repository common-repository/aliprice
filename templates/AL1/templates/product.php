<a href="<?php the_permalink() ?>" class="b-products__item" itemscope itemtype="http://schema.org/Offer" data-toggle="ctooltip">
    <div class="b-products__warp">
        <div class="b-products__image">
            <img itemprop="image" src="<?php echo ssdma_notimage($post->imageUrl); ?>_220x220.jpg" width="220" height="220" alt="<?php the_title(); ?>"/>
        </div>
        <h3 itemprop="name" class="b-products__title text-overflow" data-toggle="tooltip" data-placement="top" title="<?php the_title(); ?>">
            <?php the_title(); ?>
        </h3>
        <div class="b-products__price">
            <?php

            global $info, $todays, $hotdeal;

            $price = aliprice_get_price($post->price);
            $sale  = aliprice_get_price($post->salePrice);
            $timer = aliprice_get_timer($post->timeleft);
            if( $hotdeal == 1 )
                $timer = aliprice_get_timer();

            if ( $timer && $price && $sale && ($price != $sale) ): ?>

                <span itemprop="price"><?php echo $sale; ?></span>
                <strong> / <?php echo ssdma_getPackageType($post->packageType); ?></strong><br/>
                <strong class="b-products__price_old">
                    <?php echo $price; ?> / <?php echo ssdma_getPackageType($post->packageType); ?>
                </strong>

            <?php elseif ($sale) : ?>
                <span itemprop="price"><?php echo $sale; ?></span>
                <strong> / <?php echo ssdma_getPackageType($post->packageType); ?></strong><br/><br/>
            <?php else: ?>
                <span itemprop="price"><?php echo $price; ?></span>
                <strong> / <?php echo ssdma_getPackageType($post->packageType); ?></strong><br/><br/>
            <?php endif; ?>

        </div>
        <div class="b-product_rate fs10">
            <?php
                $ratings = $post->evaluateScore;;
                $int = intval($ratings);
                if ($ratings == 0.0 || $int == 0) {
                    $ratings = mt_rand(3, 5);
                }
            ?>

            <?php foreach (ssdma_rating($ratings) as $star): ?>
                <span class="b-social-icon b-social-icon-star<?php if (!$star): ?>-empty<?php endif; ?>"></span>
            <?php endforeach; ?>
        </div>
    </div>
</a>