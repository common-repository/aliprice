<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 13.02.15
 * Time: 18:24
 */
function ssdma_customize_register_social($wp_customize)
{
    $wp_customize->add_section('ssdma_social_settings', array(
        'title' => __('Social', 'ssdma'),
        'priority' => 100,
    ));

    // Facebook
    $wp_customize->add_setting('ssdma_social_facebook', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_facebook', array(
        'priority' => 1,
        'label' => __('Facebook (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_facebook',
    ));



    // Twitter
    $wp_customize->add_setting('ssdma_social_twitter', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_twitter', array(
        'priority' => 1,
        'label' => __('Twitter (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_twitter',
    ));
    // Google +
    $wp_customize->add_setting('ssdma_social_gplus', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_gplus', array(
        'priority' => 1,
        'label' => __('Google Plus (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_gplus',
    ));
	// Youtube 
    $wp_customize->add_setting('ssdma_social_youtube', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_youtube', array(
        'priority' => 1,
        'label' => __('Youtube (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_youtube',
    ));
	// Pinterest 
    $wp_customize->add_setting('ssdma_social_pinterest', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_pinterest', array(
        'priority' => 1,
        'label' => __('Pinterest (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_pinterest',
    ));
	    // VK
    $wp_customize->add_setting('ssdma_social_vk', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_social_vk', array(
        'priority' => 1,
        'label' => __('VK (url)', 'ssdma'),
        'section' => 'ssdma_social_settings',
        'settings' => 'ssdma_social_vk',
    ));
}

add_action('customize_register', 'ssdma_customize_register_social');