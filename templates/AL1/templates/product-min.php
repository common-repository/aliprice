<a href="<?php the_permalink() ?>" class="item" itemscope itemtype="http://schema.org/Offer" data-toggle="ctooltip">
    <div class="canvas">
        <img itemprop="image" src="<?php echo ssdma_notimage($post->imageUrl); ?>_50x50.jpg" width="50" height="50" alt="<?php the_title(); ?>" />
    </div>
    <div class="inside">
        <h3 itemprop="name" class="text-overflow" data-toggle="tooltip" data-placement="top" title="<?php the_title(); ?>">
            <?php the_title(); ?>
        </h3>
        <?php
            $price = aliprice_get_price($post->price);
            $sale  = aliprice_get_price($post->salePrice);
            $timer = aliprice_get_timer($post->timeleft);

            if($timer && $price && $sale && ($price != $sale) ): ?>
                <span class="price" itemprop="price"><?php echo $sale; ?></span>
                <span class="price old"><?php echo $price; ?></span>
            <?php elseif($sale): ?>
                <span class="price" itemprop="price"><?php echo $sale; ?></span>
            <?php else: ?>
                <span class="price" itemprop="price"><?php echo $price; ?></span>
            <?php endif; ?>
    </div>
</a>