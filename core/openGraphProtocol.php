<?php

/**
 * Add prifix to <html> tag
 * @param $language_attributes
 * @return string
 */
function aliprice_filter_to_attrib( $language_attributes ){

    return $language_attributes . ' prefix="og: http://ogp.me/ns#"';
}
add_filter('language_attributes', 'aliprice_filter_to_attrib');


/**
 * @param $title
 * @param $sep
 * @return mixed|string
 */
function aliprice_seo_wp_title( $title, $sep ) {

    global $post, $page, $paged;

    if ( is_feed() ){
        return $title;
    }
    elseif( is_singular( array('products') ) ) {

        $seotitle = get_post_meta($post->ID, 'aliprice_seo-title', true);

        if( !empty($seotitle) )
            $title = $seotitle . ' - ' . get_bloginfo( 'name' );
    }
    elseif( is_singular( array('post', 'page') ) ){

        $seotitle = get_post_meta($post->ID, 'seo-title', true);

        if( !empty($seotitle) )
            $title = $seotitle . ' - ' . get_bloginfo( 'name' );
    }

    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'aliprice' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'aliprice_seo_wp_title', 10, 2 );

/**
 * Filter for wp_head
 */
function aliprice_filter_wp_head( ) {

    $defaults = array(
        'locale' => get_locale(),
        'type'  => 'website',
        'title' => get_bloginfo('name') . " - " . get_bloginfo('description'),
        'url'   => get_bloginfo('url'),
        'site_name' => get_bloginfo('name')
    );

    $args = array();

    if( is_tax() || is_category() ) {

        $term_id = get_queried_object()->term_id;
        $taxonomy = get_queried_object()->taxonomy;
        $term = get_term_by('id', $term_id, $taxonomy);
        $args = array(
            'type' => 'object',
            'title' => __('Archive', 'aliprice') . ' ' . $term->name . ' - ' . get_bloginfo('name'),
            'url' => get_term_link($term)
        );

        $index = get_site_option( "noindex_$term_id" );
        if( $index && !empty($index) )
            $noindex = true;

    }
    elseif( is_singular( array('products') ) ){

        global $post;

        $obj = new AEProducts();
        $obj->set($post->ID);

        $keywords = $obj->getKeywords();

        $description = $obj->getSummary();
        if( empty($description) ) {
            $description = aliprice_get_post_excerpt( $post->post_content );
        }

        $index = get_post_meta($post->ID, 'aliprice_noindex', true);
        if( $index )
            $noindex = true;

        $seotitle = get_post_meta($post->ID, 'aliprice_seo-title', true);

        if( !empty($seotitle) )
            $title = $seotitle . ' - ' . get_bloginfo('name');
        else
            $title = get_the_title() . ' - ' . get_bloginfo('name');

        $args = array(
            'type'          => 'article',
            'title'         => $title,
            'description'   => $description,
            'url'           => get_permalink(),
            'image'         => $obj->getThumb('full')
        );
    }
    elseif( is_singular( array('post', 'page') ) ){

        global $post;

        $custom = get_post_custom( $post->ID );

        $keywords       = ( isset($custom['keywords'][0]) ) ? $custom['keywords'][0] : '';
        $description    = ( isset($custom['description'][0]) ) ? $custom['description'][0] : aliprice_get_post_excerpt( $post->post_content );
        $index          = ( isset($custom['noindex'][0]) && !empty($custom['noindex'][0]) ) ? true : false;
        $title          = ( isset($custom['seo-title'][0]) && !empty($custom['seo-title'][0]) ) ?
            $custom['seo-title'][0] . ' - ' . get_bloginfo('name') : get_the_title() . ' - ' . get_bloginfo('name');

        if( $index )
            $noindex = true;

        $args = array(
            'type'          => 'article',
            'title'         => $title,
            'description'   => $description,
            'url'           => get_permalink(),
            'image'         => aliprice_get_thumb($post->ID, 'full'),
        );
    }

    $args = wp_parse_args($args, $defaults);

    foreach( $args as $key => $val ) {

        $v = trim($val);

        if( !empty($v) )
            echo '<meta property="og:' . $key . '" content="' . $v . '" />' . "\n";
    }

    if( isset($keywords) && !empty($keywords) )
        echo '<meta name="keywords" content="' . $keywords . '">' . "\n";

    if( isset($description) && !empty($description) )
        echo '<meta name="description" content="' . $description . '">' . "\n";

    if( isset($noindex) )
        echo '<meta name="robots" content="noindex,follow">' . "\n";
}
add_action('wp_head','aliprice_filter_wp_head', 10);