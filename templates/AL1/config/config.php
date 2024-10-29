<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 02.02.15
 * Time: 11:55
 */
$url = get_stylesheet_directory_uri() . '/public/images/';

return array(
    // Google Analytics
    'ssdma_analytics_tid' => '',

    // Google Fonts
    'ssdma_font_family_global_url' => 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800',
    'ssdma_font_family_global_name' => "font-family: 'Open Sans', sans-serif;",
    'ssdma_font_family_header_url' => '',
    'ssdma_font_family_header_name' => '',

    // Images
    'ssdma_images_logo_header' => $url . 'logo.png',
    'ssdma_images_logo_footer' => $url . 'logof.png',
    'ssdma_images_logo_favicon' => $url . 'favicon.ico',

    // Text
    'ssdma_text_line'       => __('Smarter Shopping, Better Living!', 'ssdma'),
    'ssdma_htextphone_line' => '<span class="b-social-icon-phone"></span> ' . __('24/7 Customer Service (800) 927-7671', 'ssdma'),
    'ssdma_htext_line'      => __('Order anytime and always receive <b>FAST, FREE Shipping</b> on all orders!', 'ssdma'),
    'ssdma_beforef1_line'   => '',
    'ssdma_beforef2_line'   => '',

    // Colors
    'ssdma_colors_links'          => '#ec555c',
    'ssdma_colors_links_hover'    => '#DA4249',
    'ssdma_colors_memu'           => '#FFA22E',
    'ssdma_colors_memu_hover'     => '#FF8F00',
    'ssdma_colors_links_border_r' => '#E67100',
    'ssdma_colors_links_border_l' => '#FFD9AD',

    // Menus
    'ssdma_nav_header' => 'menu_header',
    'ssdma_nav_main'   => 'menu_main',
    'ssdma_nav_footer' => 'menu_header',

    // WP Defaults
    'blogdescription'     => '',
    'posts_per_page'      => 20,
    'posts_per_rss'       => 20,
    'permalink_structure' => '/%category%/%postname%/',
    'category_base'       => '/cat',
    'tag_base'            => '/tag',
    'show_on_front'       => 'page',
);