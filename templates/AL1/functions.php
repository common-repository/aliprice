<?php

if (!isset($content_width)) {
    $content_width = 1200;
}

if (!defined('SSDMA_OPT')) { define('SSDMA_OPT', 'ssdma_al1'); }

include get_template_directory() . '/walkers/ssdma_customize_textarea_control.php';

/**
 *   This include file customize font style on site;
 */
include get_stylesheet_directory() . '/libs/customize.php';
//include get_stylesheet_directory() . '/customize/customize.php';

/**
 *  This File stared auto settings theme;
 */
include get_stylesheet_directory() . '/config/init.php';

/**
 *   This include walkers in bootstrap style;
 */
include_once 'walkers/wp-bootstrap-comments/wp_bootstrap_comments.php';
include_once 'walkers/wp-bootstrap-navwalker-master/wp_bootstrap_navwalker.php';

// Register Theme Features
function ssdma_theme()
{
    // Add theme support for Automatic Feed Links
    add_theme_support('automatic-feed-links');

    // Add theme support for Post Formats
    add_theme_support('post-formats', array('gallery', 'image', 'video', 'audio'));

    // Add theme support for Featured Images
    add_theme_support('post-thumbnails');

    add_theme_support('menus');

    // Add theme support for Custom Background
    add_theme_support('custom-background');

    // Add theme support for Custom Header
    add_theme_support('custom-header');

    add_theme_support( 'custom-header', array('width' => 1200, 'height' => 410) );

    // Add theme support for HTML5 Semantic Markup
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    // Add theme support for document Title tag
    add_theme_support('title-tag');

    // Add theme support for Translation
    load_theme_textdomain('ssdma', get_template_directory() . '/languages');

	update_site_option('show_on_front', 'page');
}

add_action('after_setup_theme', 'ssdma_theme');



add_image_size( 'featured', 1440, 500, true );

function _remove_script_version( $src ){
    $num = strrpos($src, '?');
    if($num > 0) {
        $src = substr($src, 0, $num);
    }

    return $src;
}
if(!is_user_logged_in()) {
    add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
    add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
}

function custom_clean_head() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);


    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);


}

add_action( 'wp_enqueue_scripts', 'custom_clean_head' );

function ssdma_admin_init()
{
    if(isset($_POST['ssdma_copyright'])) {
        update_option('ssdma_copyright', $_POST['ssdma_copyright']);
    }
}
add_action('admin_init', 'ssdma_admin_init');
if (!function_exists('ssdma_init')) {
function ssdma_init()
{
    add_editor_style(get_stylesheet_directory_uri() . '/style.css');
	
	global $ali1;
	$ali1 = new AL1Options();
}
}
add_action('init', 'ssdma_init');

function ssdma_excerpt_more()
{
    return ' ...';
}
add_filter('excerpt_more', 'ssdma_excerpt_more');

function ssdma_sort_array($first = false, $key = false)
{
    $arr = array(
        'promotionVolume' => array(
            'name' => __('Best sellers', 'ssdma'),
            'sort' => false,
        ),
        'latest' => array(
            'name' => __('Latest', 'ssdma'),
            'sort' => false,
        ),
        'evaluateScore' => array(
            'name' => __('Ratings', 'ssdma'),
            'sort' => true,
        ),
        'price' => array(
            'name' => __('Price', 'ssdma'),
            'sort' => true,
        ),
    );

    if($key) { $arr = array_keys($arr); }
    if($first) { $arr = current($arr);  }

    return $arr;
}

function ssdma_is_tax($query)
{
    if(
        is_tax('shopcategory') && isset($query->query_vars['shopcategory']) ||
        (isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'products') ||
        (is_search() && !isset($query->query_vars['post_type']))
    ) {
        return true;
    }

    return false;
}

function ssdma_notimage($string)
{
    if($string !== '') {
        return $string;
    }

    return get_template_directory_uri() . '/public/images/image-not-available.jpg';
}

function ssdma_get_term_ids($flug = false)
{
    $ids = ssdma_is_var_in_get('ids', true);

    if(!empty($ids)) {
        $ids = explode('-', $ids);
    }

    if(is_array($ids) && count($ids) && $flug) {
        $ids = current($ids);
    }

    return $ids;
}

function ssdma_products_filter($query)
{
    if(ssdma_is_tax($query)) {
        if( is_search() ) { $query->set('post_type', 'products'); }

        $ids = ssdma_get_term_ids();
        if(count($ids) && !isset($query->query_vars['pre_process'])) {

            if(is_array($ids) && count($ids)) {
                $query->set('tax_query',array(
                    array(
                        'taxonomy' => 'shopcategory',
                        'field'    => 'id',
                        'terms'    => $ids
                    ),
                ));
            }
        }

    } /* end */

    return $query;
}
if( !is_admin() ) { add_action('pre_get_posts', 'ssdma_products_filter'); }

function ssdma_posts_clauses($pieces)
{
    global $wp_query, $wpdb;
    if(ssdma_is_tax($wp_query)) {
        $min     = aliprice_get_default_price(abs(floatval(ssdma_is_var_in_get('pmin', true))), false);
        $max     = aliprice_get_default_price(abs(floatval(ssdma_is_var_in_get('pmax', true))), false);
        $orderby = ssdma_is_var_in_get(
            'orderby',
            false,
            false,
            array('string', ssdma_sort_array(false, true), false)
        );
        $order  = ssdma_is_var_in_get('order', false, false, array('string', array('ASC', 'DESC'), false));

        $pieces['join'] .= ", `{$wpdb->prefix}aliprice_products` pr";
        $pieces['fields'] .= ', pr.price, pr.salePrice, pr.promotionVolume, pr.evaluateScore, pr.lotNum, pr.packageType, pr.storeName, pr.imageUrl, pr.timeleft, pr.quantity';

        if($min > -1 || $max > -1 || $orderby == 'price') {
            $pieces['join'] .= ", (SELECT id, CAST( SUBSTRING_INDEX( IF( salePrice <> '', salePrice, price), '$', -1 ) AS DECIMAL( 10, 2 ) ) AS pp FROM `{$wpdb->prefix}aliprice_products`
	) AS pu";

            $pieces['where'] = "AND pu.id = pr.id " . $pieces['where'] . " AND {$wpdb->posts}.ID = pr.post_id";

            if($min < $max) {
                $pieces['where'] .= " AND pu.pp <= '{$max}'";
                $pieces['where'] .= " AND pu.pp >= '{$min}'";
            } elseif($min) {
                $pieces['where'] .= " AND pu.pp >= '{$min}'";
            } elseif($max) {
                $pieces['where'] .= " AND pu.pp <= '{$max}'";
            }
        } else {
            $pieces['where'] .= " AND {$wpdb->posts}.ID = pr.post_id";
        }

        if($orderby == 'price') {
            $pieces['orderby'] = "pu.pp " . $order;
        } elseif($orderby == 'promotionVolume') {
            $pieces['orderby'] = "CAST(promotionVolume as UNSIGNED) " . $order;
        } elseif($orderby == 'evaluateScore') {
            $pieces['orderby'] = "evaluateScore " . $order;
        } elseif(!$orderby) {
            $pieces['orderby'] = "rand() " . $order;
        }
    }

    return $pieces;
}
if( !is_admin() ) { add_filter( 'posts_clauses', 'ssdma_posts_clauses' ); }

/**
 * Register sidebars.
 *
 * @since Ghost 1.0
 */
function ssdma_widgets_init()
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
        'before_title' => '<h3 class="widgettitle">',
        'after_title' => '</h3>'
    ));

}

add_action('widgets_init', 'ssdma_widgets_init');

function ssdma_nothing($value)
{
    return $value;
}

/**
 *	This function do customize pagination archive;
 */
function ssdma_paging_nav()
{
    global $wp_query;

    $posts_per_page = (isset($wp_query->query_vars['posts_per_page']) && intval($wp_query->query_vars['posts_per_page'])) ?
        $wp_query->query_vars['posts_per_page'] : intval(get_option('posts_per_page'));

    $big   = 999999999;
    $paged = max( 1, get_query_var('paged') );
    $count = $wp_query->found_posts;
    $total = ceil($count / $posts_per_page);
    $links = paginate_links(array(
        'base'         => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'       => '/page/%#%',
        'total'        => $total,
        'current'      => $paged,
        'type'         => 'array',
        'prev_text'    => '&laquo;',
        'next_text'    => '&raquo;'
    ));

    $pagination = array();
    if($links) {
        foreach($links as $link) {
            $pagination[] = array(
                'active' => ssdma_search_current($link),
                'link'   => $link,
            );
        }
    }

    if(count($pagination)) {
        echo '<ul class="b-pagination" role="navigation">';
            foreach($pagination as $link) {
                $class = ''; if( $link['active'] ) { $class=' class="active" '; }
                echo '<li'.$class.'>'.$link['link'].'</li>';
            }
        echo '</ul>';
    }
}
function ssdma_paginate_links($link)
{
    return strtok( $link, '?' ) . ssdma_get_to_string();
}
add_filter( 'paginate_links', 'ssdma_paginate_links' );

/**
 *	This function do find active item;
 */
function ssdma_search_current($string)
{
    if(preg_match('/(current)/', $string)) {
        return true;
    }
    return false;
}

function ssdma_image_get_alt($images, $once = false)
{
    if(!is_array($images)) { return array(); }

    $result = array();
    foreach($images as $val) {
        $alta = explode('/', $val);
        $alta = $alta[count($alta)-1];
        $alt  = str_replace('-', ' ', substr($alta, 0, strpos($alta, '.')));

        $result[] = array(
            'url' => $val,
            'alt' => $alt
        );
    }

    if($once && count($result)) { $result = array_shift($result); }

    return $result;
}

function ssdma_breadcrumbs()
{
    $text['home'] = __('Home', 'ssdma');
    $text['category'] = __('Archive article "%s"', 'ssdma', get_the_date());
    $text['search'] = __('Search Results for: %s', 'ssdma', get_search_query());
    $text['tag'] = __('Tag Archives: %s', 'ssdma', single_tag_title('', false));
    $text['author'] = __('All posts by %s', 'ssdma', get_the_author());
    $text['404'] = __('Not Found', 'ssdma');

    $show_current = 1;
    $show_on_home = 0;
    $show_home_link = 1;
    $show_title = 1;
    $delimiter = ' &rsaquo; ';
    $before = '<span class="current">';
    $after = '</span>';

    global $post;
    $home_link = home_url('/');
    $link_before = '<span typeof="v:Breadcrumb">';
    $link_after = '</span>';
    $link_attr = ' rel="v:url" property="v:title"';
    $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $parent_id = $parent_id_2 = (isset($post->post_parent)) ? $post->post_parent: null;
    $frontpage_id = get_option('page_on_front');

    if (is_home() || is_front_page()) {

        if ($show_on_home == 1) {
            echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';
        }

    } else {

        echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
        if ($show_home_link == 1) {
            echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) {
                echo $delimiter;
            }
        }

        if (is_category()) {
            $this_cat = get_category(get_query_var('cat'), false);
            if ($this_cat->parent != 0) {
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            if ($show_current == 1) {
                echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
            }

        } elseif (is_search()) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif (is_day()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif (is_month()) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;

        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                $tax = (get_post_taxonomies()) ? current(get_post_taxonomies()) : 'post';
                $terms = wp_get_post_terms($post->ID, $tax);

                printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->name);
                echo $delimiter;

                if($terms) {
                    foreach($terms as $term) {
                        printf($link, esc_url($home_link . $tax . '/' . $term->slug), $term->name);
                        echo $delimiter;
                    }
                }

                if ($show_current == 1) {
                    echo $before . get_the_title() . $after;
                }
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0) {
                    $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                }
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) {
                    $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                }
                echo $cats;
                if ($show_current == 1) {
                    echo $before . get_the_title() . $after;
                }
            }

        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {

            $post_type = get_post_type_object(get_post_type());

            $terms = '';
            if(isset($post->ID)) {
                $terms = get_the_terms($post->ID, get_query_var( 'taxonomy' ));
            }
            $term_p = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

            if($term_p && $post_type) {
                printf($link, esc_url($home_link . $post_type->rewrite['slug']), $post_type->labels->name);
                echo $delimiter;
            }

            if($term_p && $term_p->parent) {
                if($terms) {
                    $last_term = array_pop($terms);

                    foreach($terms as $term) {
                        printf($link, esc_url($home_link . get_query_var( 'taxonomy' ) . '/' . $term->slug), $term->name);
                        echo $delimiter;
                    }

                    echo $before . $last_term->name . $after;
                } elseif($post_type) {
                    echo $before . $post_type->labels->name . $after;
                }
            } elseif($term_p) {
                echo $before . $term_p->name . $after;
            } elseif($post_type) {
                echo $before . $post_type->labels->name . $after;
            }
        } elseif (is_attachment()) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) {
                    $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                }
                echo $cats;
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) {
                echo $delimiter . $before . get_the_title() . $after;
            }

        } elseif (is_page() && !$parent_id) {
            if ($show_current == 1) {
                echo $before . get_the_title() . $after;
            }

        } elseif (is_page() && $parent_id) {
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs) - 1) {
                        echo $delimiter;
                    }
                }
            }
            if ($show_current == 1) {
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) {
                    echo $delimiter;
                }
                echo $before . get_the_title() . $after;
            }

        } elseif (is_tag()) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif (is_404()) {
            echo $before . $text['404'] . $after;

        } elseif (has_post_format() && !is_singular()) {
            echo get_post_format_string(get_post_format());
        }

        if (get_query_var('paged') > 1) {
            echo ' (' . __('Page', 'ssdma') . ' ' . get_query_var('paged') . ')';
        }

        echo '</div><!-- .breadcrumbs -->';
    }
}

function ssdma_categories($tax = 'shopcategory') {
    $terms = get_terms($tax);

    $categories_menu = array(0 => '', 1 => '', 2 => '');
    if( count($terms) ) {
        $alphabet = array();
        foreach( $terms as $term ) {
            $first_letter = substr(strtoupper($term->name), 0, 1);
            $alphabet[$first_letter][] = array(
                'link' => get_term_link( $term, $tax ),
                'name' => $term->name,
                'count' => $term->count,
            );
        }

        $i   = 0;
        $j   = 0;
        $max = ceil(count($alphabet) / 3);
        foreach($alphabet as $letter => $cats) {

            if($max < $j) { $i++; $j = 0; }

            $categories_menu[$i] .= '<ul id="letter-'.$letter.'" class="letter">';
            $categories_menu[$i] .= '<p>'.$letter.'</p>';

            foreach($cats as $cat) {
                $categories_menu[$i] .= '<li><a href="'.$cat['link']
                    .'" title="'.__('More about', 'ssdma')
                    .' '.$cat['name'].'">'.$cat['name'].'</a><span> ('
                    .$cat['count'].')</span></li>';
            }
            $categories_menu[$i] .= '</ul>';
            $j++;
        }

        echo '<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-24 col-xs-24">'.$categories_menu[0].'</div>
				<div class="col-lg-8 col-md-8 col-sm-24 col-xs-24">'.$categories_menu[1].'</div>
				<div class="col-lg-8 col-md-8 col-sm-24 col-xs-24">'.$categories_menu[2].'</div>
			</div>';
    }
}

function ssdma_categories_menu($id = 0, $tax = 'shopcategory') {
    $terms = get_terms($tax, array('parent' => $id));

    $categories_menu = array();
    if( count($terms) ) {
        foreach( $terms as $term ) {
            $categories_menu[] = array(
                'id'    => $term->term_id,
                'link'  => get_term_link( $term, $tax ),
                'name'  => $term->name,
                'count' => $term->count,
            );
        }
    }

    return $categories_menu;
}

/**
 *    This function do subscribe on hook comment_form_default_fields;
 */
function ssdma_bootstrap3_comment_form_fields($fields)
{
    $commenter = wp_get_current_commenter();

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html5 = current_theme_supports('html5', 'comment-form') ? 1 : 0;

    $fields = array(
        'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . __('Name', 'ssdma') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
            '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
        'email' => '<div class="form-group comment-form-email"><label for="email">' . __('Email', 'ssdma') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
            '<input class="form-control" id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
        'url' => '<div class="form-group comment-form-url"><label for="url">' . __('Website', 'ssdma') . '</label> ' .
            '<input class="form-control" id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>',

    );

    return $fields;
}

add_filter('comment_form_default_fields', 'ssdma_bootstrap3_comment_form_fields');

/**
 *    This function do subscribe on hook comment_form_defaults;
 */
function ssdma_bootstrap3_comment_form($args)
{
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . __('Comment', 'ssdma') . '</label>
            <textarea class="form-control" id="comment" name="comment" rows="8" aria-required="true"></textarea>
        </div>';
    $args['comment_notes_after'] = '<p class="form-allowed-tags">You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>&lt;a href="" title=""&gt;</code> <code>&lt;abbr title=""&gt;</code> <code>&lt;acronym title=""&gt;</code> <code>&lt;b&gt;</code> <code>&lt;blockquote cite=""&gt;</code> <code>&lt;cite&gt;</code> <code>&lt;code&gt;</code> <code>&lt;del datetime=""&gt;</code> <code>&lt;em&gt;</code> <code>&lt;i&gt;</code> <code>&lt;q cite=""&gt;</code> <code>&lt;strike&gt;</code> <code>&lt;strong&gt;</code></p>';
    return $args;
}

add_filter('comment_form_defaults', 'ssdma_bootstrap3_comment_form');

/**
 *    This function do customize function comment_form;
 */
function ssdma_comment_form($args = array(), $post_id = null)
{
    if (null === $post_id) {
        $post_id = get_the_ID();
    } else {
        $id = $post_id;
    }

    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = wp_parse_args($args);
    if (!isset($args['format'])) {
        $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';
    }

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $html5 = 'html5' === $args['format'];
    $fields = array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', 'ssdma') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
            '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="comment-form-email"><label for="email">' . __('Email', 'ssdma') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
            '<input id="email" name="email" ' . ($html5 ? 'type="email"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
        'url' => '<p class="comment-form-url"><label for="url">' . __('Website', 'ssdma') . '</label> ' .
            '<input id="url" name="url" ' . ($html5 ? 'type="url"' : 'type="text"') . ' value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
    );

    $required_text = sprintf(' ' . __('Required fields are marked %s', 'ssdma'), '<span class="required">*</span>');

    /**
     * Filter the default comment form fields.
     *
     * @since 3.0.0
     *
     * @param array $fields The default comment fields.
     */
    $fields = apply_filters('comment_form_default_fields', $fields);
    $defaults = array(
        'fields' => $fields,
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __('Comment', 'ssdma') . '</label> <textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
        'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', 'ssdma'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'ssdma'), get_edit_user_link(), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.', 'ssdma') . ($req ? $required_text : '') . '</p>',
        'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf(__('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'ssdma'), ' <code>' . allowed_tags() . '</code>') . '</p>',
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => __('Leave a Reply', 'ssdma'),
        'title_reply_to' => __('Leave a Reply to %s', 'ssdma'),
        'cancel_reply_link' => __('Cancel reply', 'ssdma'),
        'label_submit' => __('Post Comment', 'ssdma'),
        'format' => 'xhtml',
    );

    /**
     * Filter the comment form default arguments.
     *
     * Use 'comment_form_default_fields' to filter the comment fields.
     *
     * @since 3.0.0
     *
     * @param array $defaults The default comment form arguments.
     */
    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

    include get_template_directory() . '/templates/comments.php';
}

function ssdma_set_youtube_as_featured_image($post_id)
{
    // only want to do this if the post has no thumbnail
    if (!has_post_thumbnail($post_id) && has_post_format('video', $post_id)) {

        // find the youtube url
        $post_array = get_post($post_id, ARRAY_A);
        $content = $post_array['post_content'];
        $title = $post_array['post_title'];
        $youtube_id = get_youtube_id($content);

        if ($youtube_id) {
            // build the thumbnail string
            $youtube_thumb_url = 'http://img.youtube.com/vi/' . $youtube_id . '/0.jpg';

            // next, download the URL of the youtube image
            media_sideload_image($youtube_thumb_url, $post_id, $title);

            // find the most recent attachment for the given post
            $attachments = get_posts(
                array(
                    'post_type' => 'attachment',
                    'numberposts' => 1,
                    'order' => 'ASC',
                    'post_parent' => $post_id
                )
            );
            $attachment = $attachments[0];

            // and set it as the post thumbnail
            set_post_thumbnail($post_id, $attachment->ID);
        }

    } // end if

} // set_youtube_as_featured_image
add_action('save_post', 'ssdma_set_youtube_as_featured_image');

function get_youtube_id($content)
{
    if (preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $urls) && isset($urls[0])) {
        $u = $urls[0];
        $youtube = false;
        foreach ($u as $url) {
            if (strpos($url, 'youtu') && !$youtube) {
                $url = str_replace('http://youtu.be/', '', $url);
                $youtube = str_replace('https://www.youtube.com/watch?v=', '', $url);
            }
        }
        if ($youtube) {
            return $youtube;
        }
    }

    return false;
}

function ssdma_get_to_string(array $var = array())
{
    return (count($_GET) || count($var)) ? '?' . http_build_query(array_merge($_GET, $var)) : '';
}

/**
*   This function do validate data
*/
function ssdma_is_var_in_get($name, $var = false, $default = false, $valid = array())
{
    $error = false;

    if(isset($_GET[$name])) {

        if(count($valid)) {
            if($valid[0] == 'number' && ssdma_valid_number($_GET[$name], $valid[1])) {
                $error = true;
            } elseif($valid[0] == 'string' && ssdma_valid_string($_GET[$name], $valid[1])) {
                $error = true;
            }
        } else {
            $error = true;
        }

        if($var === false) {
            if($error) {
                return $_GET[$name];
            } else {
                return $valid[2];
            }
        } elseif($var == $_GET[$name]) {
            if($error) {
                return $_GET[$name];
            } else {
                return $valid[2];
            }
        }
    }

    return $default;
}

function ssdma_valid_number($num, $is = array())
{
    if(!count($is)) { return false; }

    if(isset($is['min'])) { $min = intval($is['min']); }
    if(isset($is['max'])) { $max = intval($is['max']); }

    if(isset($min) && isset($max)) {
        if($min < $num && $max > $num) {
            return true;
        }
    } elseif(isset($min)) {
        if($min < $num) {
            return true;
        }
    } elseif(isset($max)) {
        if($max > $num) {
            return true;
        }
    }

    return false;
}

function ssdma_valid_string($str, $is = array())
{
    if(!count($is)) { return false; }

    if(in_array($str, $is)) {
        return true;
    }

    return false;
}

function ssdma_count_posts($flugs = false)
{
    global $wp_query;

    if($flugs) {
        return $wp_query->found_posts;
    }
    return $wp_query->post_count;
}

function ssdma_rating_percentage($number = 0.0, $max = 5.0)
{
    $number = floatval($number);
    $max    = floatval($max);

    return ($number*100)/$max;
}

function ssdma_rating($number = 0.0, $max = 5)
{
    $number = intval($number);
    $empty = $max - $number;
    $star = array();

    for($i=0; $i < $number; $i++) {
        $star[] = true;
    }
    for($i=0; $i < $empty; $i++) {
        $star[] = false;
    }

    return $star;
}

function the_term_link($id, $taxonomy = 'shopcategory')
{
    $term_link = get_term_link( intval($id), $taxonomy );
    if( !is_wp_error( $term_link ) )
        echo $term_link;
}

function the_term_title($id, $taxonomy = 'shopcategory')
{
    $term = get_term_by('id', intval($id), $taxonomy);

    if($term)
        echo $term->name;
}

function ssdma_str_length($string, $lenght = 40)
{
    if(strlen($string) > $lenght) {
        $string = wordwrap($string, $lenght, "}|{", true);
        $string = substr($string, 0, strpos($string, "}|{"));
    }

    return $string;
}

function ssdma_posts_process($post_type = 'post', $args = array(), $cat_id = 0)
{
    if(!$post_type) { return; }

    $params = array(
        'paged'       => max( 0, get_query_var('paged') ),
        'post_status' => 'publish',
        'post_type'   => $post_type,
    );

    if($cat_id) {
        $params['tax_query'] = array(
            array(
                'taxonomy' => 'shopcategory',
                'field'    => 'id',
                'terms'    => $cat_id,
            ));
    }

    $params = array_merge($params, $args);
    query_posts($params);

    return true;
}

function ssdma_abouttheme_add_menu()
{
    add_theme_page(
        __('About', 'ssdma'),
        __('About', 'ssdma'),
        'manage_options',
        'ssdma_about_theme',
        'ssdma_about_theme_page',
        'dashicons-info'
    );
}
add_action('admin_menu', 'ssdma_abouttheme_add_menu');

function ssdma_about_theme_page()
{
    get_template_part( 'templates/about-theme' );
}

function ssdma_add_video_embed_note($html, $url, $attr)
{
    return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'ssdma_add_video_embed_note', 10, 3);

/**
 *  This code secret; Needs too upload files
 */

function ssdma_admin_enqueue_scripts()
{
    if(isset($_GET['page']) && $_GET['page'] == 'ssdma_about_theme') {
        wp_enqueue_script('plupload-all');
    }
}
add_action('admin_enqueue_scripts', 'ssdma_admin_enqueue_scripts');

function ssdma_wp_ajax_upload()
{
    check_ajax_referer('upload');

    add_filter( 'upload_dir', 'ssdma_upload_dir' );

    // you can use WP's wp_handle_upload() function:
    $file   = $_FILES['async-upload'];
    $status = wp_handle_upload($file, array(
        'test_form' => false,
        'action'    => 'upload',
        'unique_filename_callback' => 'ssdma_rename',
    ));

    // and output the results or something...
    echo json_encode($status);

    remove_filter( 'upload_dir', 'ssdma_upload_dir' );

    exit;
}
add_action('wp_ajax_upload', 'ssdma_wp_ajax_upload');

function ssdma_upload_dir( $dir )
{
    return array(
        'path'   => get_stylesheet_directory() . '/public/images',
        'url'    => get_stylesheet_directory_uri() . '/public/images',
        'subdir' => '/public/images',
    ) + $dir;
}

function ssdma_rename($dir, $filename, $ext)
{
    $file = $dir . '/' . $filename . $ext;

    if(file_exists($file)) {
        @unlink($file);
    }

    return $filename . $ext;
};

function ssdma_get_uploadparams()
{
    $plupload_init = array(
        'runtimes'            => 'html5,silverlight,flash,html4',
        'browse_button'       => 'plupload-browse-button',
        'container'           => 'plupload-upload-ui',
        'drop_element'        => 'drag-drop-area',
        'file_data_name'      => 'async-upload',
        'multiple_queues'     => true,
        'max_file_size'       => wp_max_upload_size().'b',
        'url'                 => admin_url('admin-ajax.php'),
        'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
        'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
        'filters'             => array(array('title' => __('Allowed Files', 'ssdma'), 'extensions' => '*')),
        'multipart'           => true,
        'urlstream_upload'    => true,

        // additional post data to send to our ajax hook
        'multipart_params'    => array(
            '_ajax_nonce' => wp_create_nonce('upload'),
            'action'      => 'upload',            // the ajax action name
        ),
    );

    return apply_filters('plupload_init', $plupload_init);
}

function ssdma_filter_theme_uri($template_dir_uri) {

    $abs = str_replace('\\', '/', ABSPATH);
    $uri = str_replace('\\', '/', $template_dir_uri);
    $uri = str_replace($abs, get_option( 'siteurl' ) . "/", $uri );

    return $uri;
}
add_filter( 'theme_root_uri', 'ssdma_filter_theme_uri', 30,3 );

function ssdma_get_tag_image($path, $alt = '')
{
    $img = '<img src="{src}" alt="{alt}"/>';
/*	try{
        if(function_exists('getimagesize')) {

            try{
                $info = getimagesize($path);

                if(count($info)) {
                    list($width, $height, $type, $attr) = $info;
                    $img = str_replace('{size}', $attr, $img);
                }
            }
            catch( Exception $e ){
                $img = str_replace('{size}', '', $img);
            }
        }
	}
    catch( Exception $e ){
	    $img = str_replace('{size}', '', $img);
    }
*/
    $img = str_replace('{src}', $path, $img);
    $img = str_replace('{alt}', $alt, $img);

    return $img;
}

function ssdma_seo_head()
{
    if(is_home()) {
        $seo_keyword = get_option('ssdma_seo_keywords');
        $seo_desc    = get_option('ssdma_seo_desc');

        if($seo_keyword) {
            echo '<meta name="keywords" content="'.$seo_keyword.'">';
        }
        if($seo_desc) {
            echo '<meta name="description" content="'.$seo_desc.'">';
        }
    }
}
add_action('wp_head', 'ssdma_seo_head');

function ssdma_assets_scripts()
{
    // front-end scripts
	wp_register_script( 'fotorama-js', plugins_url( '/aliprice/js/fotorama.js' ), array('jquery'), '4.6.4' );
	wp_enqueue_script('fotorama-js');
    wp_enqueue_script('ssdma', get_template_directory_uri() . '/public/js/index.js', array('jquery', 'jquery-ui-slider', 'fotorama-js'),'', true);

    wp_register_style( 'fotorama-css', plugins_url('/aliprice/css/fotorama.css'), "", '4.6.4' );
	wp_enqueue_style('fotorama-css');
    // front-end css
   

	 wp_enqueue_style('ssdma', get_stylesheet_directory_uri() . '/style.css');
		if ( is_rtl() )
{
    wp_enqueue_style('ssdma2', get_stylesheet_directory_uri() . '/public/css/rtl.css');
}
}
add_action("wp_enqueue_scripts", 'ssdma_assets_scripts', 10);

function ssdma_getPackageType($any = '') {

    $foo = array(
        'piece' => __('piece', 'aliprice'),
        'lot' => __('lot', 'aliprice')
    );

    return isset( $foo[$any] ) ? $foo[$any] : $any;
}
/**
 * Show SKU parameters from product
 *
 * @param $sku
 */
function pr_showSKU( $sku ) {

    foreach ( $sku as $k => $v ) {

        if ( !empty( $v['params'] ) ) {

            $items  = '';

            foreach ( $v['params'] as $key => $val ) {

                if ( !empty( $val ) ) {

                    if ( aliprice_is_url( $val ) )
                        $items .= sprintf(
                            '<span class="meta-item-img sku-set"><img src="%1$s" class="img-responsive"></span>',
                            $val
                        );
                    else
                        $items .= sprintf(
                            '<span class="meta-item sku-set">%1$s</span>',
                            $val
                        );
                }
            }

            if ( $items != '' )
                printf(
                    '<dl class="item-sku">
                        <dt>%1$s</dt><dd>%2$s</dd>
                    </dl>',
                    $v[ 'title' ],
                    $items
                );
        }
    }
}