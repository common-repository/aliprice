<?php
/**
 * Created by AL3.
 * User: Dmitry Nizovsky
 * Date: 20.02.15
 * Time: 11:14
 */

if (!isset($content_width)) {
    $content_width = 1200;
}
if (!function_exists('ssdma_init')) {
    function ssdma_init() {
        add_editor_style(get_stylesheet_directory_uri() . '/style.css');

        global $ali3;
        $ali3 = new AL3Options();
    }
}
if (!defined('SSDMA_OPT')) { define('SSDMA_OPT', 'ssdma_al3'); }

// Register Theme Features
function ssdma3_theme()
{
    add_theme_support( 'custom-header', array('width' => 1920, 'height' => 500) );
	update_site_option('show_on_front', 'page');
}

add_action('after_setup_theme', 'ssdma3_theme');
function ssdma_assets_scripts3()
{
    // front-end scripts
    wp_enqueue_script('ssdma', get_template_directory_uri() . '/public/js/index3.js', array('jquery', 'jquery-ui-slider'),'', true);

}
add_action("wp_enqueue_scripts", 'ssdma_assets_scripts3', 10);