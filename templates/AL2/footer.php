<?php
global $ali2;
?>
</div></div>
<div class="footer">
    <div class="cell">
        <div class="container-fluid b-footer">
            <div class="container">
                <div
                    class="col-lg-5 col-md-5 col-sm-24 col-xs-24 b-footer__item"><?php $footer_logo = $ali2->ssdma_images_logo_footer;
                    if ($footer_logo): ?><a
                        href="<?php echo esc_url(home_url('/')); ?>"><?php echo ssdma_get_tag_image($footer_logo, get_option('blogdescription')); ?></a><?php endif; ?>
                </div>
                <div
                    class="col-lg-14 col-md-14 col-sm-24 col-xs-24 b-footer__item"><?php wp_nav_menu(array('menu' => $ali2->ssdma_nav_footer, 'theme_location' => $ali2->ssdma_nav_footer, 'depth' => 2, 'container' => '', 'container_class' => '', 'menu_class' => 'nav nav-c-footer', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker())); ?></div>
                <div class="col-lg-5 col-md-5 col-sm-24 col-xs-24 b-footer__item">
                    <ul class="b-social b-social_big b-social_gray_light"><?php get_template_part('templates/social'); ?></ul>

                </div>
				<div class="col-lg-24 col-sm-24 b-subscribe">
					<?php if ($ali2->ssdma_subscribe): ?>
						<h3><?php _e( 'Subscription', 'ssdma' ) ?></h3>
						<?php echo $ali2->ssdma_subscribe; ?>
					<?php endif; ?>
				</div>
            </div>
            <div
                class="container text-center"><?php $ssdma_copyright = $ali2->ssdma_copyright; ?><?php if ($ssdma_copyright): ?><?php echo $ssdma_copyright; ?><?php else: ?> &copy;&nbsp;<?php _e('Copyright', 'ssdma'); ?>&nbsp;<?php echo date('Y'); ?>.&nbsp;<?php _e('Powered By', 'ssdma'); ?>&nbsp;
                <a href="<?php echo esc_url('http://www.aliplugin.com/'); ?>" target="_blank">
                        AliPlugin.com</a><?php endif; ?></div>
        </div>
    </div>
</div>
<div class="header base-bg-white">
    <div class="cell">
        <div class="container-fluid">
            <div class="container">
                <div
                    class="col-lg-7 col-md-24 col-sm-24 col-xs-24 base-top-20"><?php $header_logo = $ali2->ssdma_images_logo_header;
                    if ($header_logo): ?><a
                        href="<?php echo esc_url(home_url('/')); ?>"><?php echo ssdma_get_tag_image($header_logo, get_option('blogdescription')); ?></a><?php endif; ?>
                </div>
                <div
                    class="col-lg-10 col-md-20 col-sm-20 col-xs-20"><?php $phone_number = $ali2->ssdma_htextphone_line;
                    if ($phone_number): ?>
                        <div class="clearfix base-pad-g-10"><?php echo $phone_number; ?>
                        <div class="mobile_menu"><img src="<?php echo get_template_directory_uri(); ?>/public/images/mobilemenu_mini.png">▼</div>
                        </div><?php endif; ?>
                    <div class="clearfix"><?php get_search_form(); ?></div>
                </div>
                <div class="col-lg-6 col-md-28 text-left <?php echo (is_rtl) ? '': 'col-lg-offset-1 col-md-offset-1' ?> col-sm-28 col-xs-28 ">
                    <div class="clearfix">
                        <ul class="b-social b-social_border b-social_gray_light pull-right"><?php get_template_part('templates/social'); ?></ul>
                    </div>

                    <div class="clearfix base-top-20 textcentr forsecmenu">
                        <div class="second_menu_button"><img src="<?php echo get_template_directory_uri(); ?>/public/images/mobilemenu.png"></div>
	                    <?php

	                    $fs_image = $ali2->ssdma_images_fs;

	                    if ( $fs_image && $fs_image != '' ):
		                    echo ssdma_get_tag_image($fs_image, get_option('free shipping'));
	                    else:
		                    echo ssdma_get_tag_image(
			                    get_template_directory_uri() . "/public/images/free-shipping.jpg", ''
		                    );
	                    endif;
	                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid base-bg-white b-menu-header">
            <div class="container">
                <div
                    class="col-lg-17 col-md-24 col-sm-24 col-xs-24"><?php wp_nav_menu(array('menu' => $ali2->ssdma_nav_header, 'theme_location' => $ali2->ssdma_nav_header, 'depth' => 2, 'container' => '', 'container_class' => '', 'menu_class' => 'nav nav-c-header', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker())); ?></div>
                <div class="col-lg-7 col-md-24 col-sm-24 col-xs-24 b-menu-header_logos">
                    <ul class="g-partner-icons clearfix">
                        <li class="g-partner-icons_item"><span class="b-social-icon-glyph-3"></span></li>
                        <li class="g-partner-icons_item"><span class="b-social-icon-glyph-5"></span></li>
                        <li class="g-partner-icons_other"><span class="b-social-icon-cc-visa"></span></li>
                        <li class="g-partner-icons_other"><span class="b-social-icon-cc-mastercard"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><?php wp_footer(); ?></body></html>