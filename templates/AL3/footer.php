<?php global $ali3; ?></div></div>
<div class="footer">
    <div class="cell">
        <div class="container-fluid b-footer-before">
            <div class="container">
                <ul class="g-partner-icons">
                    <li class="g-partner-icons_title"><?php _e('Our Preferred Partners:', 'ssdma'); ?></li>
                    <li class="g-partner-icons_item"><span class="b-social-icon-glyph-3"></span></li>
                    <li class="g-partner-icons_item"><span class="b-social-icon-glyph-2"></span></li>
                    <li class="g-partner-icons_item"><span class="b-social-icon-glyph-5"></span></li>
                    <li class="g-partner-icons_other"><span class="b-social-icon-cc-visa"></span></li>
                    <li class="g-partner-icons_other"><span class="b-social-icon-cc-mastercard"></span></li>
                    <li class="g-partner-icons_item"><span class="b-social-icon-glyph"></span></li>
                </ul>
            </div>
        </div>
        <div class="container-fluid b-footer">
            <div class="container">
                <div
                    class="col-lg-5 col-md-5 col-sm-24 col-xs-24 b-footer__item"><?php $footer_logo = $ali3->ssdma_images_logo_footer;
                    if ($footer_logo): ?><a
                        href="<?php echo esc_url(home_url('/')); ?>"><?php echo ssdma_get_tag_image($footer_logo, get_option('blogdescription')); ?></a><?php endif; ?>
                </div>
                <div
                    class="col-lg-14 col-md-14 col-sm-24 col-xs-24 b-footer__item"><?php wp_nav_menu(array('menu' => $ali3->ssdma_nav_footer, 'theme_location' => $ali3->ssdma_nav_footer, 'depth' => 2, 'container' => '', 'container_class' => '', 'menu_class' => 'nav nav-c-footer', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker())); ?></div>
                <div class="col-lg-5 col-md-5 col-sm-24 col-xs-24 b-footer__item">
                    <ul class="b-social b-social_big b-social_gray_light"><?php get_template_part('templates/social'); ?></ul>
                </div>
				<div class="col-lg-24 col-sm-24 b-subscribe">
					<?php if ($ali3->ssdma_subscribe): ?>
						<h3><?php _e( 'Subscription', 'ssdma' ) ?></h3>
						<?php echo $ali3->ssdma_subscribe; ?>
					<?php endif; ?>
				</div>
            </div>
            <div class="container text-center">
				<?php $ssdma_copyright = $ali3->ssdma_copyright; ?><?php if ($ssdma_copyright): ?><?php echo $ssdma_copyright; ?><?php else: ?> &copy;&nbsp;<?php _e('Copyright', 'ssdma'); ?>&nbsp;<?php echo date('Y'); ?>.&nbsp;<?php _e('Powered By', 'ssdma'); ?>&nbsp;
                <a href="<?php echo esc_url('http://www.aliprice.com/'); ?>" target="_blank">aliprice.com</a><?php endif; ?></div>
        </div>
    </div>
</div>
<div class="header">
    <div class="cell">
        <div class="container-fluid b-top-menu">
            <div class="container">
                <div
                    class="col-lg-12 col-md-12 col-sm-24 col-xs-24"><?php wp_nav_menu(array('menu' => $ali3->ssdma_nav_header, 'theme_location' => $ali3->ssdma_nav_header, 'depth' => 2, 'container' => '', 'container_class' => '', 'menu_class' => 'nav nav-c-top', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker())); ?></div>
                <div
                    class="col-lg-12 col-md-12 col-sm-24 col-xs-24 text-right"><?php $phone_number = $ali3->ssdma_htextphone_line;
                    if ($phone_number): ?><span
                        class="b-text-pad-base"><?php echo $phone_number; ?></span><?php endif; ?>
                    <div class="mobile_menu"><img src="<?php echo get_template_directory_uri(); ?>/public/images/mobilemenu_mini.png">▼</div>
                    <ul class="b-social b-social_border b-social_gray_light"><?php get_template_part('templates/social'); ?></ul>
                </div>
            </div>
        </div>
        <div class="container-fluid b-header">
            <div class="container">
                <div
                    class="col-lg-7 col-md-7 col-sm-24 col-xs-24"><?php $header_logo = $ali3->ssdma_images_logo_header;
                    if ($header_logo): ?><a
                        href="<?php echo esc_url(home_url('/')); ?>"><?php echo ssdma_get_tag_image($header_logo, get_option('blogdescription')); ?></a><?php endif; ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-24 col-xs-24"><?php get_search_form(); ?></div>
                <div class="col-lg-4 col-md-4 <?php echo (is_rtl) ? '': 'col-lg-offset-1 col-md-offset-1' ?> col-sm-24 col-xs-24 textcentr forsecmenu">
                    <div class="second_menu_button"><img src="<?php echo get_template_directory_uri(); ?>/public/images/mobilemenu.png"></div>
	                <?php

	                $fs_image = $ali3->ssdma_images_fs;

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
        <div class="container-fluid b-main-menu">
            <div
                class="container"><?php wp_nav_menu(array('menu' => $ali3->ssdma_nav_main, 'theme_location' => $ali3->ssdma_nav_main, 'depth' => 2, 'container' => '', 'container_class' => '', 'menu_class' => 'nav nav-c-main-menu', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker())); ?></div>
        </div>
    </div>
</div><?php wp_footer(); ?></body>

</html>