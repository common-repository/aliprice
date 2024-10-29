<?php /** * Created by AL2. * User: Dmitry Nizovsky * Date: 17.02.15 * Time: 17:19 */ ?><!DOCTYPE html><!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if IE 8]>
<html <?php language_attributes(); ?> class="no-js lt-ie9" itemscope itemtype="http://schema.org/WebPage"><![endif]--><!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js" itemscope itemtype="http://schema.org/WebPage"><!--<![endif]-->
<?php global $ali2;?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php echo get_option( 'ssdma_images_logo_favicon' ); ?>"/>
	<?php wp_head(); ?><!--[if gte IE 8]>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/public/css/style-ie.css" type="text/css"
	      media="all"><![endif]--><?php $tcolor = get_header_textcolor();
	$bcolor                                     = get_background_color();
	$links                                      = $ali2->ssdma_colors_links;
	$links_h                                    = $ali2->ssdma_colors_links_hover;
	$btn                                        = $ali2->ssdma_colors_htb;
	$btn_h                                      = $ali2->ssdma_colors_htb_h;
	$btn2                                       = $ali2->ssdma_colors_htb2;
	$btn_h2                                      = $ali2->ssdma_colors_htb_h2;
	$btn3                                        = $ali2->ssdma_colors_htb3;
	$btn_h3                                      = $ali2->ssdma_colors_htb_h3;
	$hline                                      = $ali2->ssdma_colors_h_line;
	$font_g_url                                 = $ali2->ssdma_font_family_global_url;
	$font_g_name                                = $ali2->ssdma_font_family_global_name;
	$font_h_url                                 = $ali2->ssdma_font_family_header_url;
	$font_h_name                                = $ali2->ssdma_font_family_header_name; ?>
    <?php if ( $font_g_url ): ?>
		<link rel="stylesheet" href="<?php echo $font_g_url; ?>" type="text/css"
		      media="all"><?php endif; ?><?php if ( $font_h_url ): ?>
		<link rel="stylesheet" href="<?php echo $font_h_url; ?>" type="text/css" media="all"><?php endif; ?>
	<style type="text/css"><?php if($font_h_url && $font_h_name):?>h1, h2, h3, h4, h5, h6 {
		<?php echo $font_h_name;?>
		}

		<?php endif;?><?php if($font_g_url && $font_g_name):?>body {
		<?php echo $font_g_name;?>
		}

		<?php endif;?><?php if($bcolor):?>.text-header:before {
			color: #<?php echo($bcolor) ? $bcolor:'fff';?>
		}

		<?php endif;?><?php if($tcolor):?>.b-header-img__caption {
			color: #<?php echo($tcolor) ? $tcolor:'fff';?>
		}

		<?php endif;?><?php if($btn):?>.btn.btn-cred {
			background: <?php echo $btn;?>;
			border-color: <?php echo($btn_h) ? $btn_h:$btn;?>
		}

		<?php endif;?><?php if($btn_h):?>.btn.btn-cred:hover, .btn.btn-cred:focus {
			background: <?php echo $btn_h;?>;
			border-color: <?php echo $btn_h;?>
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

		<?php endif;?><?php if($links):?>.b-search button, .g-posts__date, .text-header.text-header__bg-red, .b-product_description_tabs .nav.nav-tabs li.active a, .b-filter-slider .ui-slider-range {
			background: <?php echo $links;?>
		}

		.b-search button, .b-pagination li.active span {
			border-color: <?php echo $links;?>
		}

		.b-products .b-products__item .b-products__price, .b-product_price_now, a, a:hover, a:focus, .b-breadcrumb a, .b-posts a, .b-posts .b-posts_item .b-posts_item_content .entry-meta, .b-pagination li.active span, .b-nav-categories li a:hover, .b-nav-categories li a:focus, .b-product_store a {
			color: <?php echo $links;?>
		}

		<?php endif;?><?php if($links_h):?>.b-search button:hover, .b-search button:focus, .b-product_description_tabs .nav.nav-tabs a:hover, .b-product_description_tabs .nav.nav-tabs a:focus {
			background: <?php echo $links_h;?>
		}

		.b-search button:hover, .b-search button:focus {
			border-color: <?php echo $links_h;?>
		}

		.b-pagination li span:hover, .b-pagination li a:hover, .b-pagination li span:focus, .b-pagination li a:focus {
			color: <?php echo $links_h;?>
		}

		<?php endif;?><?php if($hline):?>.text-header.text-header__bg-blue {
			background: <?php echo $hline;?>
		}<?php endif; ?></style><?php echo $ali2->ssdma_analytics_tid; ?>
</head>
<body <?php body_class(); ?>>
<div class="content">
	<div class="cell">