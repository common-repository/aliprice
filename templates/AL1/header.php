<?php /** * Created by SSDMAThemes. * User: Dmitry Nizovsky * Date: 13.01.15 * Time: 15:56 */ ?>
<?php  if (isset($font_g_url)):  ?>
    <link rel="stylesheet" href="<?php echo $font_g_url; ?>" type="text/css" media="all"><?php endif; ?>
<?php  if (isset($font_h_url)):  ?>
    <link rel="stylesheet" href="<?php echo $font_h_url; ?>" type="text/css" media="all"><?php endif; ?>
<!DOCTYPE html><!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 8]>
<html <?php language_attributes(); ?> class="no-js lt-ie9" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js" itemscope itemtype="http://schema.org/WebPage"><!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo $ali1->ssdma_images_logo_favicon; ?>"/>
    <?php wp_head(); ?><!--[if gte IE 8]>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/public/css/style-ie.css" type="text/css"
          media="all"><![endif]-->
    <?php 
	global $ali1;
	$tcolor = get_header_textcolor();
    $links = $ali1->ssdma_colors_links;
    $links_h = $ali1->ssdma_colors_links_hover;
    $menu = $ali1->ssdma_colors_memu;
    $menu_h = $ali1->ssdma_colors_memu_hover;
    $menu_b_r = $ali1->ssdma_colors_links_border_r;
    $menu_b_l = $ali1->ssdma_colors_links_border_l;
    $btn2   = $ali1->ssdma_colors_htb2;
    $btn_h2 = $ali1->ssdma_colors_htb_h2;
    $btn3   = $ali1->ssdma_colors_htb3;
    $btn_h3 = $ali1->ssdma_colors_htb_h3;
    $tw = get_option('thumbnail_size_w');
    $th = get_option('thumbnail_size_h');
    $mw = get_option('medium_size_w');
    $mh = get_option('medium_size_h');
    $lw = get_option('large_size_w');
    $lh = get_option('large_size_h');
    $font_g_url = $ali1->ssdma_font_family_global_url;
    $font_g_name = $ali1->ssdma_font_family_global_name;
    $font_h_url = $ali1->ssdma_font_family_header_url;
    $font_h_name = $ali1->ssdma_font_family_header_name; ?>
    <style>
        <?php if($font_h_url && $font_h_name):?>h1, h2, h3, h4, h5, h6 {
        <?php echo $font_h_name;?>
        }

        <?php endif;?><?php if($font_g_url && $font_g_name):?>body {
        <?php echo $font_g_name;?>
        }

        <?php endif;?>.gallery-size-thumbnail .gallery-item {
            width: <?php echo $tw;?>px;
            height: <?php echo $th;?>px
        }

        .gallery-size-medium .gallery-item {
            width: <?php echo $mw;?>px;
            height: <?php echo $mh;?>px
        }

        .gallery-size-large .gallery-item {
            width: <?php echo $lw;?>px;
            height: <?php echo $lh;?>px
        }

        .b-header-img__caption {
            color: #<?php echo $tcolor;?>
        }

        <?php if($menu):?>.b-main-menu {
            background-color: <?php echo $menu;?>
        }

        .nav-c-main-menu li a:hover, .nav-c-main-menu li a:focus, .nav-c-main-menu li.active a, .nav-c-main-menu li a.categories {
            background-color: <?php echo($menu_h) ? $menu_h:$menu;?>
        }

        .nav-c-main-menu li:after, .nav-c-main-menu:after {
            border-left: 1px solid <?php echo $menu_b_l;?>;
            border-right: 1px solid <?php echo $menu_b_r;?>
        }

        <?php endif;?><?php if($links):?>a, a:hover, a:focus, .btn.btn-cwhite, .b-c-tabs li a:hover, .b-c-tabs li a:focus, .b-posts a, .b-posts .b-posts_item .b-posts_item_content .entry-meta, .b-pagination li.active span, .b-pagination li span:hover, .b-pagination li a:hover, .b-pagination li span:focus, .b-pagination li a:focus, .h-left-sidebar, .b-nav-categories li a:hover, .b-nav-categories li a:focus, .b-filter-slider .ui-slider-handle, .b-product-sort li.active a, .b-product-sort li.active a:hover, .b-product-sort li.active a:focus, .b-product-sort li a:hover, .b-product-sort li a:focus, .b-product_price_now, .b-product_store a, .b-product_preview__item.b-product_preview__item_first:before {
            color: <?php echo $links;?>
        }

        .b-products .b-products__item .b-products__price, .b-products .b-products__item .b-products__price_old, .b-c-tabs li.active a, .products-mini .item .price {
            color: <?php echo $links;?>
        }

        .b-search button, .b-pagination li.active span, .b-product_preview__item.b-product_preview__item_first {
            border-color: <?php echo $links;?>
        }

        .b-search button, .b-text-inline, .btn.btn-cred, .b-filter-slider .ui-slider-range {
            background-color: <?php echo $links;?>
        }

        .btn.btn-cred {
            border-bottom: 2px solid <?php echo($links_h) ? $links_h:$links;?>
        }

        .b-search button:hover, .btn.btn-cred:hover, .b-search button:focus, .btn.btn-cred:focus {
            background-color: <?php echo($links_h) ? $links_h:$links;?>
        }

        .btn.btn-cred {
            border-bottom: 0 solid <?php echo($links_h) ? $links_h:$links;?>
        }
        <?php endif;?><?php if($btn2):?>.btn.btn-cred.slider_btn2 {
            background: <?php echo $btn2;?>;
            border-color: <?php echo($btn_h2) ? $btn_h2:$btn2;?>
        }

        <?php endif;?><?php if($btn_h2):?>.btn.btn-cred.slider_btn2:hover, .btn.btn-cred.slider_btn2:focus {
            background: <?php echo $btn_h2;?>;
            border-color: <?php echo $btn_h2;?>
        }
        <?php endif;?><?php if($btn3):?>.btn.btn-cred.slider_btn3 {
            background: <?php echo $btn3;?>;
            border-color: <?php echo($btn_h3) ? $btn_h3:$btn3;?>
        }

        <?php endif;?><?php if($btn_h3):?>.btn.btn-cred.slider_btn3:hover, .btn.btn-cred.slider_btn3:focus {
            background: <?php echo $btn_h3;?>;
            border-color: <?php echo $btn_h3;?>
        }
        .b-search button:hover, .b-search button:focus {
            border-color: <?php echo($links_h) ? $links_h:$links;?>
        }<?php endif; ?></style><?php echo $ali1->ssdma_analytics_tid; ?>
</head>
<body <?php body_class(); ?>>
<div class="content">
    <div class="cell">