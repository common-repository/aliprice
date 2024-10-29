<?php global $ali3; ?><!DOCTYPE html><!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 8]>
<html <?php language_attributes(); ?> class="no-js lt-ie9" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js" itemscope itemtype="http://schema.org/WebPage"><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo $ali3->ssdma_images_logo_favicon; ?>"/>
	<?php wp_head(); ?><!--[if gte IE 8]>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/public/css/style-ie.css" type="text/css"
	      media="all"><![endif]--><?php $tcolor = get_header_textcolor();
	$bcolor                                     = get_background_color();
	$img                                        = $ali3->ssdma_slider_image1;
	$img_fb                                     = $ali3->ssdma_images_before_footer;
	$img_fb                                     = ( $img_fb ) ? $img_fb : get_stylesheet_directory_uri() . '/public/images/footer_img.jpg';
	$links                                      = $ali3->ssdma_colors_links;
	$links_h                                    = $ali3->ssdma_colors_links_hover;
	$btn                                        = $ali3->ssdma_colors_htb;
	$btn_h                                      = $ali3->ssdma_colors_htb_h;
    $btn2                                       = $ali3->ssdma_colors_htb2;
    $btn_h2                                      = $ali3->ssdma_colors_htb_h2;
    $btn3                                        = $ali3->ssdma_colors_htb3;
    $btn_h3                                      = $ali3->ssdma_colors_htb_h3;
	$font_g_url                                 = $ali3->ssdma_font_family_global_url;
	$font_g_name                                = $ali3->ssdma_font_family_global_name;
	$font_h_url                                 = $ali3->ssdma_font_family_header_url;
	$font_h_name                                = $ali3->ssdma_font_family_header_name; ?><?php if ( $font_g_url ): ?>
		<link rel="stylesheet" href="<?php echo $font_g_url; ?>" type="text/css"
		      media="all"><?php endif; ?><?php if ( $font_h_url ): ?>
		<link rel="stylesheet" href="<?php echo $font_h_url; ?>" type="text/css" media="all"><?php endif; ?>
	<style type="text/css"><?php if($font_h_url && $font_h_name):?>h1, h2, h3, h4, h5, h6 {
		<?php echo $font_h_name;?>
		}

		<?php endif;?><?php if($font_g_url && $font_g_name):?>body {
		<?php echo $font_g_name;?>
		}

		<?php endif;?><?php if($img_fb):?>.b-text-inline {
			background: url('<?php echo $img_fb; ?>') no-repeat top center;
			background-size: cover
		}

		<?php endif;?><?php if($bcolor):?>.text-header.text-header-strike span, .b-c-tabs:before {
			background-color: #<?php echo($bcolor) ? $bcolor:'fff';?>
		}

		<?php endif;?><?php if($tcolor):?>.b-header-img__caption {
			color: #<?php echo($tcolor) ? $tcolor:'fff';?>
		}

		<?php endif;?><?php if($img):?>.b-header-img {
			background: url('<?php echo $ali3->ssdma_slider_image1; ?>') no-repeat top center;
			background-size: cover
		}

		<?php endif;?><?php if($links):?>a, a:hover, a:focus, .b-c-tabs li a:hover, .b-c-tabs li a:focus, .b-posts a, .b-posts .b-posts_item .b-posts_item_content .entry-meta, .b-pagination li.active span, .b-pagination li span:hover, .b-pagination li a:hover, .b-pagination li span:focus, .b-pagination li a:focus, .h-left-sidebar, .b-nav-categories li a:hover, .b-nav-categories li a:focus, .b-filter-slider .ui-slider-handle, .b-product-sort li.active a, .b-product-sort li.active a:hover, .b-product-sort li.active a:focus, .b-product-sort li a:hover, .b-product-sort li a:focus, .b-product_price_now, .b-product_store a, .b-product_preview__item.b-product_preview__item_first:before, .text-header.text-header-strike a, .text-header.text-header-strike a:hover, .text-header.text-header-strike a:focus {
			color: <?php echo $links;?>
		}

		.b-products .b-products__item .b-products__price, .b-products .b-products__item .b-products__price_old, .b-c-tabs li.active a, .products-mini .item .price {
			color: <?php echo $links;?>
		}

		.b-search button, .b-pagination li.active span, .b-product_preview__item.b-product_preview__item_first {
			border-color: <?php echo $links;?>
		}

		.b-search button, .b-text-inline, .btn.btn-cred, .b-filter-slider .ui-slider-range, .text-header.text-header-strike:before {
			background-color: <?php echo $links;?>
		}

		.btn.btn-cred {
			border-bottom: 0 solid <?php echo($links_h) ? $links_h:$links;?>
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
		}<?php endif; ?></style><?php echo $ali3->ssdma_analytics_tid; ?></head>
<body <?php body_class(); ?>>
<div class="content">
	<div class="cell">