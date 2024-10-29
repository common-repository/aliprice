<?php
/**
 * Created by AL2.
 * User: Dmitry Nizovsky
 * Date: 19.02.15
 * Time: 12:29
 */

require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

require_once get_template_directory() . '/config/libs/GhostCategory.php';
require_once get_template_directory() . '/config/libs/GhostItem.php';
require_once get_template_directory() . '/config/libs/GhostMenu.php';
require_once get_template_directory() . '/config/libs/GhostOptions.php';
require_once get_template_directory() . '/config/libs/GhostPages.php';
require_once get_template_directory() . '/config/libs/GhostWidget.php';


function ssdma_setup_theme()
{
    global $wp_rewrite;

    if( !get_option(SSDMA_OPT) ) {
        update_option(SSDMA_OPT, 1);

        $options = include get_stylesheet_directory() . '/config/config.php';
        $theme_mods = include get_stylesheet_directory() . '/config/default.php';

        if(is_array($options)) {
            foreach($options as $name => $value) {
                update_option($name, $value);
            }
        }

        if(is_array($theme_mods)) {
            foreach($theme_mods as $name => $value) {
                set_theme_mod($name, $value);
            }
        }

        do_action("ssdma_theme_settings");
    }

    $wp_rewrite->set_permalink_structure( get_option('permalink_structure') );
    $wp_rewrite->flush_rules();
}
add_action('after_switch_theme', 'ssdma_setup_theme');

function ssdma_start_auto_settings()
{
    $wp_filesystem = new WP_Filesystem_Direct('');

    $loc = get_locale();
    if($loc == '') { $loc = 'en_US'; }

    $page_shopping_path = get_template_directory() . '/config/pages/shipping-and-delivery.'. $loc .'.html';
    $page_buyer_path    = get_template_directory() . '/config/pages/buyer-protection.'. $loc .'.html';

    if($wp_filesystem->exists($page_shopping_path)) {
        $page_shopping = $wp_filesystem->get_contents( $page_shopping_path );
    } else {
        $page_shopping = $wp_filesystem->get_contents( get_template_directory() . '/config/pages/shipping-and-delivery.en_US.html' );
    }
    if($wp_filesystem->exists($page_buyer_path)) {
        $page_buyer = $wp_filesystem->get_contents( $page_buyer_path );
    } else {
        $page_buyer = $wp_filesystem->get_contents( get_template_directory() . '/config/pages/buyer-protection.en_US.html' );
    }

    $blog  = new GhostCategory();
    if($blog->findById(1)) {
        $blog->setName(__('Blog', 'ssdma'))->setSlug('blog')->save();
    } else {
        $blog->setName(__('Blog', 'ssdma'))->save();
    }

    $pages = new GhostPages();

    if(!$pages->isPageByTitle(__('Shipping & Delivery', 'ssdma'))) {
        $shipping = new GhostPages();
        $shipping->setTitle(__('Shipping & Delivery', 'ssdma'));
        $shipping->setContent($page_shopping)->save();
    }

    if(!$pages->isPageByTitle(__('Buyer Protection', 'ssdma'))) {
        $buyer = new GhostPages();
        $buyer->setTitle(__('Buyer Protection', 'ssdma'));
        $buyer->setContent($page_buyer)->save();
    }

    // create menu header
    if(!is_nav_menu('menu_header')) {
        $menu_header = new GhostMenu();

        $home     = new GhostItem();
        $iblog    = new GhostItem();
        $products = new GhostItem();
        $shipping = new GhostItem();
        $buyer    = new GhostItem();

        $shippingPage = new GhostPages();
        $buyerPage    = new GhostPages();

        $shippingPage->findByTitle(__('Shipping & Delivery', 'ssdma'));
        $buyerPage->findByTitle(__('Buyer Protection', 'ssdma'));

        $home->setTitle(__('Home', 'ssdma'))->setUrl('/');
        $products->setTitle(__('Products', 'ssdma'))->setUrl('/products');

        $menu_header->addItem(array(
            $home,
            $iblog->setCategory($blog),
            $products,
            $shipping->setPage($shippingPage),
            $buyer->setPage($buyerPage),
        ));

        $menu_header->setName('menu_header')->save();
    }

    // create menu main
    ssdma_cat_menu_reset(null, true);

}
add_action('ssdma_theme_settings', 'ssdma_start_auto_settings');

function ssdma_cat_menu_reset($val = false, $opt = false) {
    if(isset($_POST['menu_reset']) || $opt) {

        $menu_main = new GhostMenu();

        if(is_nav_menu('menu_main')) {
            $menu_main->findByName('menu_main');

            $items_old = $menu_main->getItems();
            foreach($items_old as $item_old) { $item_old->delete(); }
        } else {
            $menu_main->setName('menu_main');
        }

        $products = new GhostCategory();
        $category = ssdma_cat_menu_reset_helper($products->findCategoryByName('shopcategory'), 4);

        $items = array();
        foreach($category as $key => $item) {
            $items[$key] = new GhostItem();
            $items[$key]->setCategory($item)->setObject('shopcategory')->setType('taxonomy');
        }

        $all_categories = new GhostItem();
        $all_categories->setTitle(__('All categories', 'ssdma'))->setTitleAttr('categories')->setUrl('/products');

        $items[] = $all_categories;

        $menu_main->addItem($items)->save();
    }
}
add_action('admin_init', 'ssdma_cat_menu_reset');

function ssdma_add_widget()
{
    ssdma_remove_widgets_in_sidebar('sidebar');

    $terms = get_terms('shopcategory');
    $default = 0;
    if( count($terms) ) {
        $term = array_shift($terms);
        $default = $term->term_id;
    }

    $menu_main  = new GhostMenu();
    $id = $menu_main->findByName('menu_main')->getId();

    // add widget
    $widget  = array(
        array(
            'id' => 'WP_Nav_Menu_Widget',
            'value' => array(
                'title' => __('Categories', 'ssdma'),
                'nav_menu'  => $id,
            ),
        ),
        array(
            'id' => 'Ali_Products',
            'value' => array(
                'title'   => '',
                'atitle'  => 1,
                'order'   => 'date',
                'count'   => 4,
                'cat'     => $default,
            ),
        ),
        array(
            'id' => 'G_Posts',
            'value' => array(
                'title'   => '',
                'atitle'  => 1,
                'order'   => 'date',
                'count'   => 4,
                'cat'     => 1,
            ),
        ),
    );

    ssdma_add_widgets_in_sidebar('sidebar', $widget);
}
add_action("ssdma_theme_settings", "ssdma_add_widget");

function ssdma_cat_menu_reset_helper($category = array(), $num = 3)
{
    if(is_array($category) && !count($category)) { return $category; }

    $firstres = array();
    foreach($category as $item) {
        $firstres[$item->getCount()] = $item;
    }
    sort($firstres);

    $i=0;
    $secondres = array();
    foreach($firstres as $item) {
        $secondres[$item->getName()] = $item;

        $i++;
        if($i > $num) { break; }
    }
    sort($secondres);

    return $secondres;
}