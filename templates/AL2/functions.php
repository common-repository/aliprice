<?php
/**
 * Created by AL2.
 * User: Dmitry Nizovsky
 * Date: 17.02.15
 * Time: 16:07
 */
if (!function_exists('ssdma_init')) {
    function ssdma_init() {
        add_editor_style(get_stylesheet_directory_uri() . '/style.css');
	
	global $ali2;
	$ali2 = new AL2Options();
    }
}

if (!isset($content_width)) {
    $content_width = 900;
}

if (!defined('SSDMA_OPT')) { define('SSDMA_OPT', 'ssdma_al2'); }

// Register Theme Features
function ssdma2_theme()
{
    add_theme_support( 'custom-header', array('width' => 900, 'height' => 347) );
	update_site_option('show_on_front', 'page');
}

add_action('after_setup_theme', 'ssdma2_theme');

/**
 * Register sidebars.
 *
 * @since Ghost 1.0
 */
function ssdma2_init()
{
    /**
     *    Sidebar
     */
    register_sidebar(array(
        'name' => __('Sidebar', 'ssdma'),
        'id' => 'sidebar',
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="text-header text-header__bg-blue"><h3 class="widget-title">',
        'after_title' => '</h3></div>'
    ));

}
add_action('init', 'ssdma2_init');


function ssdma2_widgets_init()
{
    require_once get_stylesheet_directory() . '/widgets/g-posts/G_Posts.php';
    require_once get_stylesheet_directory() . '/widgets/aliproducts/Ali_Products.php';
}
add_action('widgets_init', 'ssdma2_widgets_init');
function ssdma_assets_scripts2()
{
	wp_register_script( 'fotorama-js', plugins_url( '/aliprice/js/fotorama.js' ), array('jquery'), '4.6.4' );
	wp_enqueue_script('fotorama-js');
    wp_enqueue_script('ssdma', get_template_directory_uri() . '/public/js/index2.js', array('jquery', 'jquery-ui-slider', 'fotorama-js'),'', true);

    wp_register_style( 'fotorama-css', plugins_url('/aliprice/css/fotorama.css'), "", '4.6.4' );
	wp_enqueue_style('fotorama-css');
    // front-end css
   

	 wp_enqueue_style('ssdma', get_stylesheet_directory_uri() . '/style.css');
		if ( is_rtl() )
{
    wp_enqueue_style('ssdma2', get_stylesheet_directory_uri() . '/public/css/rtl.css');
}
}
add_action("wp_enqueue_scripts", 'ssdma_assets_scripts2', 10);
function ssdma_get_product_category($name, $selected = 0, $options = array())
{
    $args = array(
        'show_option_all'    => '',
        'show_option_none'   => '',
        'orderby'            => 'ID',
        'order'              => 'ASC',
        'show_count'         => 1,
        'hide_empty'         => 1,
        'child_of'           => 0,
        'exclude'            => '',
        'echo'               => 1,
        'selected'           => $selected,
        'hierarchical'       => 0,
        'name'               => $name,
        'id'                 => '',
        'class'              => 'postform',
        'depth'              => 0,
        'tab_index'          => 0,
        'taxonomy'           => 'shopcategory',
        'hide_if_empty'      => false,
        'walker'             => ''
    );

    $newargs = array_merge($args, $options);

    wp_dropdown_categories( $newargs );
}
