<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 10.02.15
 * Time: 16:59
 */
function ssdma_customize_register_products($wp_customize)
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

    $wp_customize->add_section( 'ssdma_products_settings', array(
        'title' => __('Products', 'ssdma'),
        'priority' => 75,
    ) );

    /* Category #1 */
    $wp_customize->add_setting( 'ssdma_products_cat1', array(
        'default' => $default,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_products_cat1', array(
        'priority' => 1,
        'settings' => 'ssdma_products_cat1',
        'label'    => __('Category', 'ssdma') . ' #1',
        'section'  => 'ssdma_products_settings',
        'type'     => 'select',
        'choices'  => $categories,
    ) );

    /* Category #2 */
    $wp_customize->add_setting( 'ssdma_products_cat2', array(
        'default' => $default,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_products_cat2', array(
        'priority' => 2,
        'settings' => 'ssdma_products_cat2',
        'label'    => __('Category', 'ssdma') . ' #2',
        'section'  => 'ssdma_products_settings',
        'type'     => 'select',
        'choices'  => $categories,
    ) );

    /* Category #3 */
    $wp_customize->add_setting( 'ssdma_products_cat3', array(
        'default' => $default,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_products_cat3', array(
        'priority' => 3,
        'settings' => 'ssdma_products_cat3',
        'label'    => __('Category', 'ssdma') . ' #3',
        'section'  => 'ssdma_products_settings',
        'type'     => 'select',
        'choices'  => $categories,
    ) );

    /* Category #4 */
    $wp_customize->add_setting( 'ssdma_products_cat4', array(
        'default' => $default,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_products_cat4', array(
        'priority' => 4,
        'settings' => 'ssdma_products_cat4',
        'label'    => __('Category', 'ssdma') . ' #4',
        'section'  => 'ssdma_products_settings',
        'type'     => 'select',
        'choices'  => $categories,
    ) );
}

add_action('customize_register', 'ssdma_customize_register_products');