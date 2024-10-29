<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 02.02.15
 * Time: 11:47
 */
function ssdma_customize_register_seo($wp_customize)
{
    $wp_customize->add_section('ssdma_seo_settings', array(
        'title' => __('SEO', 'ssdma'),
        'priority' => 105,
    ));

    // seo keywords
    $wp_customize->add_setting('ssdma_seo_keywords', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_seo_keywords', array(
        'priority' => 1,
        'label' => __('Keywords', 'ssdma'),
        'section' => 'ssdma_seo_settings',
        'settings' => 'ssdma_seo_keywords',
    ));

    // seo description
    $wp_customize->add_setting('ssdma_seo_desc', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_seo_desc', array(
        'label'    => __('Description', 'ssdma'),
        'section'  => 'ssdma_seo_settings',
        'settings' => 'ssdma_seo_desc',
        'priority' => 2,
    )));
	
	    // seo main page
    $wp_customize->add_setting('ssdma_seo_main', array(
        'default'        => '<div class="container"></div>',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_seo_main', array(
        'label'    => __('SEO Article on home page (before footer)', 'ssdma'),
        'section'  => 'ssdma_seo_settings',
        'settings' => 'ssdma_seo_main',
        'priority' => 2,
    )));

}

add_action('customize_register', 'ssdma_customize_register_seo');