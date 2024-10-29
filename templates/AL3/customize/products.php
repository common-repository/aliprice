<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 10.02.15
 * Time: 16:59
 */
function ssdma_customize_register_products_child($wp_customize)
{
    $terms = get_terms('shopcategory');
    $default = 0;
    $categories = array();
    if( count($terms) ) {
        foreach( $terms as $term ) {
            if(!$default){
                $default = $term->term_id;
            }
            $categories[$term->term_id] = $term->name . ' (' . $term->count . ')';
        }
    }

    /* Category #5 */
    $wp_customize->add_setting( 'ssdma_products_cat5', array(
        'default' => $default,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_products_cat5', array(
        'priority' => 11,
        'settings' => 'ssdma_products_cat5',
        'label'    => __('Category', 'ssdma') . ' #5',
        'section'  => 'ssdma_products_settings',
        'type'     => 'select',
        'choices'  => $categories,
    ) );
}

add_action('customize_register', 'ssdma_customize_register_products_child');