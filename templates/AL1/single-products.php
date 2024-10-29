<?php get_header(); ?>

    <?php
        $post_id = get_the_ID();
        $info    = new AEProducts();
        $list = $info->set($post_id);
        $arrayOfObjs = aliprice_Review($post_id);
        $stat        = aliprice_getStat( $arrayOfObjs );
        $images      = ssdma_image_get_alt( unserialize($info->getImages()) );
        $image       = ssdma_image_get_alt( array($info->getThumb()), true );
        
        if (!count($image) && $images) {
            $image = current($images);
        }
    ?>

    <div class="container b-product b-margin-base">

        <?php get_template_part('templates/breadcrumbs'); ?>

        <div class="b-grid-left text-center">
            <div class="b-product_preview b-redirect">
                <div class="b-product_preview__main">
                    <?php
                        if ( count($image) ) :
                            printf(
                                '<img src="%1$s" alt="%2$s" width="%3$d" height="%3$d">',
                                $image['url'], $image['alt'], 418
                            );
                        else :
                            printf(
                                '<img src="%1$s" alt="%2$s" width="%3$d" height="%4$d">',
                                get_template_directory_uri() . '/public/images/image-not-available.jpg',
                                __('Image not available', 'ssdma'), 400, 300
                            );
                        endif;
                    ?>
                </div>
                <div class="b-product_preview__context clearfix"><?php _e('Click to see details', 'ssdma'); ?></div>

                <?php
                    foreach ( $images as $k => $img ) {

                        if( $k == 3 ) continue;

                        $class = $k == 0 ? 'b-product_preview__item_first' : '';

                        printf(
                            '<div class="b-product_preview__item %1$s">
                                <img src="%2$s_%3$dx%3$d.jpg" width="%3$d" height="%3$d" alt="%4$s">
                            </div>',
                            $class, $img['url'], 220, $img['alt']
                        );
                    }
                ?>
            </div>
        </div>
        <div class="b-grid-title wrap-meta">
            <h1><?php the_title(); ?></h1>

            <div class="b-product_rate">
                <?php
                    $ratings  = $info->getRating();
                    $int      = intval($ratings);
                    $ratings  = ($ratings == 0.0 || $int == 0) ? mt_rand(3, 5) : $ratings;
                    $quantity = ( $info->getQuantity() == 0 ) ?
                        sprintf('<div style="color:green">%s</div>', __('Availability: in stock', 'ssdma')) :
                        sprintf('<div style="color:red">%s</div>', __('Availability: out of stock', 'ssdma'));
                    foreach ( ssdma_rating($ratings) as $star ) {

                        $class = !$star ? '-empty' : '';

                        printf('<span class="b-social-icon b-social-icon-star%s"></span>', $class);
                    }

                    echo ssdma_rating_percentage( $ratings ) . ' % ';

                    _e('of buyers enjoyed this product!', 'ssdma');
                echo $quantity;
                ?>
            </div>

            <?php $sku = $info->getSKU();?>
            <div class="sku-listing">
                <?php if ( !empty($sku) ) pr_showSKU( $sku ); ?>
            </div>

            <div class="b-grid-content">
                <?php
                    $price   = aliprice_get_price($info->getPrice());
                    $sale    = aliprice_get_price($info->getSalePrice());
                    $timer   = aliprice_get_timer($info->getTimeLeft());
                    $todays = (get_option('aliprice-todaysdeal')) ? get_option('aliprice-todaysdeal') : '';
                    $hotdeal = (get_option('aliprice-hotdeal')) ? get_option('aliprice-hotdeal') : 0;

                    if( $hotdeal == 1 )
                        $timer = aliprice_get_timer();

                    if( $timer && $price && $sale && $price != $sale && ($todays == 1 || $hotdeal == 1) ) {
                        ?>
                        <div class="todays_all">
                            <span class="pull-left"><?php _e("TODAY'S DEAL", 'ssdma') ?></span>
                            <span class="pull-right">
                                <?php if( $timer['type'] == 'time' ){ ?>
                                    <?php _e('Ends in', 'ssdma') ?>:
                                    <span id="my_timer" style="color: #f00;"><?php echo $timer['value'] ?></span>
                                <?php }
                                    else { ?>
                                    <?php _e('Days Left', 'ssdma') ?>:
                                    <span id="time-left" style="color: #f00;"><?php echo $timer['value'] ?></span>
                                <?php } ?>
                            </span>
                        </div>
                        <?php
                    }
                ?>

                <div class="effect2 b-product_price">
                    <?php if( $price && $sale && $price != $sale ) : ?>
                            <div>
                                <span class="b-product_price_title"><?php _e('Price', 'ssdma'); ?>:&nbsp;</span>
                                <span class="b-product_price_old"><?php echo $price; ?></span>
                                <strong class="b-product_min"> / <?php echo $info->getPackageType(); ?></strong>
                            </div>
                            <div>
                                <span class="b-product_price_title"><?php _e('Sale Price', 'ssdma'); ?>:&nbsp;</span>
                                <span class="b-product_price_now" itemprop="price"><?php echo $sale; ?></span>
                                <strong class="b-product_max"> / <?php echo $info->getPackageType(); ?></strong>
                            </div>
                    <?php
                        elseif ($price || $sale) :

                            if ($price) : ?>

                                <div>
                                    <span class="b-product_price_title"><?php _e('Price', 'ssdma'); ?>:&nbsp;</span>
                                    <span class="b-product_price_now" itemprop="price"><?php echo $price; ?></span>
                                    <strong class="b-product_max"> / <?php echo $info->getPackageType(); ?></strong>
                                </div>

                            <?php else : ?>

                                <div>
                                    <span class="b-product_price_title"><?php _e('Price', 'ssdma'); ?>:&nbsp;</span>
                                    <span class="b-product_price_old"><?php echo $sale; ?></span>
                                    <strong class="b-product_min"> / <?php echo $info->getPackageType(); ?></strong>
                                </div>
                    <?php endif; endif; ?>

                    <div class="text-center">
                        <?php
                            $Buynow      = $ali1->ssdma_buynow;
                            $Buynow_text = $ali1->ssdma_buynow_text;
                            $btn_text    = ($Buynow && $Buynow != '') ? $Buynow : __( 'Order Now', 'ssdma' );
                            $buy_now_txt = ($Buynow_text && $Buynow_text != '') ? $Buynow_text :
                                __( 'from AliExpress', 'ssdma' );
                        ?>
                        <input type="hidden" name="product_id" value="<?php echo $post_id ?>">
                        <a href="<?php echo $list->productUrl; ?>" target="_blank" class="btn btn-orange"><?php echo $btn_text; ?></a>

                        <?php if( get_option('aliprice-alibaba') ) : ?>

                            <div class="alibaba_href">
                                <?php _e('or', 'ssdma') ?><br>
                                <a href="#modal"  role="button" data-toggle="modal" id="modal_call_alibaba">
                                    <?php _e('Learn How to Buy it Even Cheaper!', 'ssdma'); ?></a>
                            </div>

                        <?php else : ?>
                            <i><?php echo $buy_now_txt ?></i>
                        <?php endif;?>
                    </div>
                </div>
                <div class="b-product_desc">
                    <table>
                        <tr>
                            <th><img src="<?php echo get_template_directory_uri(); ?>/public/images/box-single.jpg"
                                     width="45" height="39" alt="45 days Money back"/></th>
                            <td>
                                <strong><?php _e('45 days Money back', 'ssdma'); ?></strong>
                                <?php _e('Returns accepted if product not as described, buyer pays return shipping; or keep the product & agree refund with seller.', 'ssdma'); ?>
                            </td>
                        </tr>
                        <tr>
                            <th><img src="<?php echo get_template_directory_uri(); ?>/public/images/car-single.jpg"
                                     width="45" height="40" alt="On-time Delivery"/></th>
                            <td>
                                <strong><?php _e('On-time Delivery', 'ssdma'); ?></strong><br/>
                                <?php _e('Guarantees: On-time Delivery 60 days', 'ssdma'); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="b-grid-right">
                <!--<div class="b-product_favorite">
                    <h3><?php _e('Sort By', 'ssdma'); ?></h3>
                    <table>
                        <tr>
                            <th><span class="b-social-icon-award"></span></th>
                            <td><?php _e('Top-rated Seller', 'ssdma'); ?></td>
                        </tr>
                    </table>
                </div>-->
                <?php

                //    $surl  = $info->getStoreUrl();
                //    $sname = $info->getStoreName();

                //    if ($surl && $sname): ?>
                     <!--   <div class="b-product_store">
                            <a rel="nofollow" href="<?php // echo $surl; ?>"><?php // echo $sname; ?></a>
                        </div>-->
                    <?php
                //    endif;
                ?>
                <div class="b-social-squared">
                    <h3><?php _e('Share', 'ssdma'); ?>:</h3>
                    <?php get_template_part('templates/social-more'); ?>
                </div>
                <hr class="hidden-xs"/>
                <h3 class="text-center base-he2 hidden-xs"><?php _e('Most Popular from Category', 'ssdma'); ?></h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="b-grid-tabs">
            <div role="tabpanel" class="b-product_description_tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#product" aria-controls="product" role="tab" data-toggle="tab">
                            <?php _e('Product Description', 'ssdma'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#reviews" aria-controls="reviews" role="tab" data-toggle="tab">
                            <?php _e('Reviews', 'ssdma'); ?> <?php comments_number('', '(1)', '(%)'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">
                            <?php _e('Shipping and payment', 'ssdma'); ?>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#sellers" aria-controls="sellers" role="tab" data-toggle="tab">
                            <?php _e("Seller Guarantees", "ssdma"); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="product">
                        <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="reviews">
					    <div class="row">
                            <div class="col-lg-12 pad60">
                                <div class="stars col-lg-12">
                                    <?php
                                        $average      = aliprice_averageStar($arrayOfObjs);
                                        $averageStar  = $average[0];
                                        $averageCount = $average[1];

                                        aliprice_renderStarRating($averageStar);
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <?php _e('Average Star Rating:', 'ssdma') ?><br>
                                    <?php printf(
                                            '<b><span class="in5">%1$s</span> %3$s 5 (%2$s %4$s)</b>',
                                            $averageStar,
                                            $averageCount,
                                            __('out of', 'ssdma'),
                                            __('Ratings', 'ssdma')
                                            );
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <span class="feedback_title"><?php _e('Feedback Rating for This Product', 'ssdma') ?></span>
                                <table class="feedback_average_table">
                                    <tr>
                                        <td rowspan="2"><?php _e('Positive', 'ssdma') ?> (<?php echo $stat['positive'] ?>%)</td>
                                        <td>
                                            <span class="progress_title"><?php _e('5 Stars', 'ssdma') ?> (<?php echo $stat['stars'][5]['count'] ?>)</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $stat['stars'][5]['percent']; ?>"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?php echo $stat['stars'][5]['percent']; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="progress_title"><?php _e('4 Stars', 'ssdma') ?> (<?php echo $stat['stars'][4]['count'] ?>)</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $stat['stars'][4]['percent']; ?>"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?php echo $stat['stars'][4]['percent']; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php _e('Neutral', 'ssdma') ?> (<?php echo $stat['neutral'] ?>%)</td>
                                        <td>
                                            <span class="progress_title"><?php _e('3 Stars', 'ssdma') ?> (<?php echo $stat['stars'][3]['count'] ?>)</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $stat['stars'][3]['percent']; ?>"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?php echo $stat['stars'][3]['percent']; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2"><?php _e('Neutral', 'ssdma') ?> (<?php echo $stat['neutral'] ?>%)</td>
                                        <td>
                                            <span class="progress_title"><?php _e('2 Stars', 'ssdma') ?> (<?php echo $stat['stars'][2]['count'] ?>)</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $stat['stars'][2]['percent']; ?>"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?php echo $stat['stars'][2]['percent']; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="progress_title"><?php _e('1 Star', 'ssdma') ?> (<?php echo $stat['stars'][1]['count'] ?>)</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     aria-valuenow="<?php echo $stat['stars'][1]['percent']; ?>"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                     style="width: <?php echo $stat['stars'][1]['percent']; ?>%;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-24">
                                <table class="review_table">
                                    <tr class="th">
                                        <th><?php _e('Name', 'ssdma') ?></th>
                                        <th><?php _e('Rating', 'ssdma') ?></th>
                                        <th class="date_review"><?php _e('Feedback', 'ssdma') ?></th>
                                    </tr>

                                    <?php $date_format = get_option('date_format'); ?>

                                    <?php foreach ($arrayOfObjs as $key => $obj) : ?>

                                        <tr>
                                            <td class="star-text">
                                                <b><?php echo $obj->name?></b>
                                                <span><img src="<?php echo get_template_directory_uri(); ?>/public/images/flags/<? echo strtoupper($obj->flag)?>.gif"/></span>
                                            </td>
                                            <td class="star-text">
                                                <div class="b-product_rate">
                                                    <p><?php foreach (ssdma_rating($obj->star) as $star): ?>
                                                        <span class="b-social-icon dib b-social-icon-star<?php if (!$star): ?>-empty<?php endif; ?>"></span>
                                                        <?php endforeach; ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="date_review">
                                                <span><?php echo date_i18n( $date_format, strtotime( $obj->date ) ) ?></span>
                                                <?php echo $obj->feedback == '' ? __('No Feedback Score', 'ssdma') : $obj->feedback ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
				        </div>
				    </div>
					<div role="tabpanel" class="tab-pane" id="payment">
						<table class="table table-responsive table-bordered">
							<thead>
							<tr>
								<th><?php _e('Shipping Company', 'ssdma'); ?></th>
								<th><?php _e('Shipping Cost', 'ssdma'); ?></th>
								<th><?php _e('Estimated Delivery Time', 'ssdma'); ?></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<th><img src="<?php echo get_template_directory_uri(); ?>/public/images/icon-dhl.jpg"
										 width="90" height="30" alt="DHL"/></th>
								<td></td>
								<td>3&nbsp;-&nbsp;7&nbsp;<?php _e('days', 'ssdma'); ?></td>
							</tr>
							<tr>
								<th><img src="<?php echo get_template_directory_uri(); ?>/public/images/icon-ups-e.gif"
										 width="82" height="34" alt="UPS Expedited"/></th>
								<td></td>
								<td>3&nbsp;-&nbsp;7&nbsp;<?php _e('days', 'ssdma'); ?></td>
							</tr>
							<tr>
								<th><img src="<?php echo get_template_directory_uri(); ?>/public/images/icon-ems.jpg"
										 width="70" height="30" alt="EMS"/></th>
								<td></td>
								<td>5&nbsp;-&nbsp;14&nbsp;<?php _e('days', 'ssdma'); ?></td>
							</tr>
							<tr>
								<th><?php _e('Post Air Mail', 'ssdma'); ?></th>
								<td><?php _e('Free Shipping', 'ssdma'); ?></td>
								<td>15&nbsp;-&nbsp;45&nbsp;<?php _e('days', 'ssdma'); ?></td>
							</tr>
							</tbody>
						</table>
					</div>
                    <div role="tabpanel" class="tab-pane" id="sellers">
                        <table class="table table-responsive table-bordered">
                            <tbody>
                            <tr>
                                <th><?php _e('Return Policy', 'ssdma'); ?></th>
                                <td><?php _e('If the product you receive is not as described or low quality, the seller promises that you may return it before order completion (when you click "Confirm Order Received" or exceed confirmation timeframe) and receive a full refund. The return shipping fee will be paid by you. Or, you can choose to keep the product and agree the refund amount directly with the seller.', 'ssdma'); ?>
                                    <br/><br/><?php _e('N.B.: If the seller provides the "Longer Protection" service on this product, you may ask for refund up to 15 days after order completion.', 'ssdma'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th><?php _e('Seller Service', 'ssdma'); ?></th>
                                <td>
                                    <strong><?php _e('On-time Delivery', 'ssdma'); ?></strong><?php _e('If you do not receive your purchase within 60 days, you can ask for a full refund before order completion (when you click "Confirm Order Received" or exceed confirmation timeframe). ', 'ssdma'); ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            <div class="b-grid-right hidden-md hidden-sm hidden-xs">
            <div class="b-products b-products__min text-right"><?php get_template_part('templates/products-count-2'); ?></div>
            </div>
        <div class="clearfix"></div>

        <hr class="visible-xs-block">
        <h3 class="text-center base-he2 mobilepopular"><?php _e('Most Popular from Category', 'ssdma'); ?></h3>
        <hr class="visible-xs-block">

        <div class="b-products b-products__min"><?php get_template_part('templates/products-count-6'); ?></div>
    </div>

    <?php get_template_part('templates/text-line'); ?>
<div class="buy-window">
<form method="POST" action="<?php echo esc_html( home_url('/') ) ?>" class="b-product_order">
	 <?php if( $price && $sale && $price != $sale ) : ?>
	<div class="bw-price">
	<span><?php _e('Price', 'ssdma'); ?>:&nbsp;</span>
	<span><?php echo $price; ?></span>
	/ <?php echo $info->getPackageType(); ?>
	</div>
	<div class="bw-saleprice">
	<?php _e('Sale Price', 'ssdma'); ?>:&nbsp;
	<span><?php echo $sale; ?></span>
	 / <?php echo $info->getPackageType(); ?>
	</div>
	<?php
    elseif ($price || $sale) :
         if ($price) : ?>
		 <div class="bw-saleprice">
		<?php _e('Price', 'ssdma'); ?>:&nbsp;
		<span><?php echo $price; ?></span>
		/ <?php echo $info->getPackageType(); ?>
		</div>
		<?php else : ?>
		<div class="bw-saleprice">
		<?php _e('Price', 'ssdma'); ?>:&nbsp;
		<span><?php echo $sale; ?></span>
		/ <?php echo $info->getPackageType(); ?>
		</div>
		<?php endif; endif; ?>
	 <input type="hidden" name="product_id" value="<?php echo $post_id ?>">
     <input type="submit" name="ae_submit" value="<?php echo $btn_text ?>" class="btn btn-orange">
                            <?php if( get_option('aliprice-alibaba') ) : ?>
                                <div class="alibaba_href">
                                    <?php _e('or', 'ssdma') ?><br>
                                    <a href="#modal"  role="button" data-toggle="modal" id="modal_call_alibaba">
                                        <?php _e('Learn How to Buy it Even Cheaper!', 'ssdma'); ?></a>
                                </div>
                            <?php else : ?>
                                <i><?php echo $buy_now_txt ?></i>
                            <?php endif;?>
	</form>
</div>
      

    <div id="modal_form">
        <span id="modal_close">X</span>
        <div class="modal_title text-center">
            <?php _e('Do you know that you can <span>save up to 90%</span> on your<br> online shopping, buying directly from manufacturers?', 'ssdma') ?>
        </div>
        <div class="modal_subtitle"><?php _e('And it is very easy:', 'ssdma') ?></div>
        <ul class="modal_ul">
            <li><?php _e('Go to', 'ssdma') ?> <a href="<?php echo get_option( 'aliprice-alibaba_href' )?>" target="_blank">Alibaba.com</a>
                <?php _e('and enter the wanted item into search field.', 'ssdma') ?></li>
            <li><?php _e('Having made your choice, click "Contact supplier" button on the right', 'ssdma') ?></li>
            <li><?php _e('On the next page enter your request and click "Send" button.', 'ssdma') ?></li>
            <li><?php _e('Upon clicking you will be asked to get registered. Do it and wait for the reply.', 'ssdma') ?></li>
        </ul>
        <div class="text-center modal_ready"><?php _e('ARE YOU READY TO SAVE UP TO 90%?', 'ssdma') ?></div>
        <a class="btn btn-orange text-center" href="<?php echo get_option( 'aliprice-alibaba_href' )?>" target="_blank">
            <?php _e('GO TO ALIBABA', 'ssdma') ?>
        </a>
    </div>
    <div id="overlay"></div>
    <script>
                (function startTimer() {
            var my_timer = document.getElementById("my_timer");

            if( my_timer !== null && my_timer.length !== 0 ){
                var time = my_timer.innerHTML;
                var arr = time.split(":");
                var h = arr[0];
                var m = arr[1];
                var s = arr[2];
                if (s == 0) {
                    if (m == 0) {
                        if (h == 0) {
                            window.location.reload();
                            return;
                        }
                        h--;
                        m = 60;
                        if (h < 10) h = "0" + h;
                    }
                    m--;
                    if (m < 10) m = "0" + m;
                    s = 59;
                }
                else s--;
                if (s < 10) s = "0" + s;
                document.getElementById("my_timer").innerHTML = h+":"+m+":"+s;
                setTimeout(startTimer, 1000);
            }
        }());
    </script>
<?php get_footer(); ?>