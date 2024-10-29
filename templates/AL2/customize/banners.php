<?php
/**
 * Created by AL2.
 * User: Dmitry Nizovsky
 * Date: 19.02.15
 * Time: 12:50
 */

function ssdma_customize_register_banners($wp_customize)
{
    $wp_customize->add_section( 'ssdma_banners_settings', array(
        'title' => __('Banners', 'ssdma'),
        'priority' => 110,
    ) );

    // Banner #1
    $wp_customize->add_setting('ssdma_banners_1', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_banners_1', array(
        'label'    => __('Banner', 'ssdma') . ' #1',
        'section'  => 'ssdma_banners_settings',
        'settings' => 'ssdma_banners_1',
        'priority' => 1,
    )));

    // Banner #2
    $wp_customize->add_setting('ssdma_banners_2', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_banners_2', array(
        'label'    => __('Banner', 'ssdma') . ' #2',
        'section'  => 'ssdma_banners_settings',
        'settings' => 'ssdma_banners_2',
        'priority' => 2,
    )));
}

add_action('customize_register', 'ssdma_customize_register_banners');