<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 02.02.15
 * Time: 12:55
 */
function ssdma_customize_register_nav($wp_customize)
{
    $menus = wp_get_nav_menus();
    $slug_menus = array();
    $current_menus = '';
    foreach($menus as $item) {
        if(!$current_menus) { $current_menus = $item->slug; }
        $slug_menus[$item->slug] = $item->name;
    }

    /* Nav */
    $wp_customize->add_section( 'ssdma_nav_settings', array(
        'title' => __('Navigation', 'ssdma'),
        'priority' => 55,
    ) );

    /* Header menu */
    $wp_customize->add_setting( 'ssdma_nav_header', array(
        'default' => $current_menus,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_nav_header', array(
        'priority' => 1,
        'settings' => 'ssdma_nav_header',
        'label'    => __('Header menu', 'ssdma'),
        'section'  => 'ssdma_nav_settings',
        'type'     => 'select',
        'choices'  => $slug_menus,
    ) );

    /* main menu */
    $wp_customize->add_setting( 'ssdma_nav_main', array(
        'default' => $current_menus,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_nav_main', array(
        'priority' => 2,
        'settings' => 'ssdma_nav_main',
        'label'    => __('Main menu', 'ssdma'),
        'section'  => 'ssdma_nav_settings',
        'type'     => 'select',
        'choices'  => $slug_menus,
    ) );

    /* Footer menu */
    $wp_customize->add_setting( 'ssdma_nav_footer', array(
        'default' => $current_menus,
        'type'    => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ) );
    $wp_customize->add_control( 'ssdma_nav_footer', array(
        'priority' => 2,
        'settings' => 'ssdma_nav_footer',
        'label'    => __('Footer menu', 'ssdma'),
        'section'  => 'ssdma_nav_settings',
        'type'     => 'select',
        'choices'  => $slug_menus,
    ) );
}

add_action('customize_register', 'ssdma_customize_register_nav');