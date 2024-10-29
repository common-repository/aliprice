<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 28.01.15
 * Time: 15:45
 */
function ssdma_customize_register_fonts($wp_customize)
{
    $wp_customize->add_section('ssdma_fonts_settings', array(
        'title' => __('Google Fonts', 'ssdma'),
        'priority' => 35,
        'description' => 'This settings add Google fonts your website'
    ));

    // url for font (Global)
    $wp_customize->add_setting('ssdma_font_family_global_url', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_link_to_url'
    ));
    $wp_customize->add_control('ssdma_font_family_global_url', array(
        'priority' => 1,
        'label' => __('Url for font (Global)', 'ssdma'),
        'section' => 'ssdma_fonts_settings',
        'settings' => 'ssdma_font_family_global_url',
    ));

    // name font for insert into website
    $wp_customize->add_setting('ssdma_font_family_global_name', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_font_family_global_name', array(
        'priority' => 2,
        'label' => __('Name font (Global)', 'ssdma'),
        'section' => 'ssdma_fonts_settings',
        'settings' => 'ssdma_font_family_global_name',
    ));

    // url for font (Header)
    $wp_customize->add_setting('ssdma_font_family_header_url', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_link_to_url'
    ));
    $wp_customize->add_control('ssdma_font_family_header_url', array(
        'priority' => 3,
        'label' => __('Url for font (Header)', 'ssdma'),
        'section' => 'ssdma_fonts_settings',
        'settings' => 'ssdma_font_family_header_url',
    ));

    // name font for insert into website
    $wp_customize->add_setting('ssdma_font_family_header_name', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_font_family_header_name', array(
        'priority' => 4,
        'label' => __('Name font (Header)', 'ssdma'),
        'section' => 'ssdma_fonts_settings',
        'settings' => 'ssdma_font_family_header_name',
    ));
}

add_action('customize_register', 'ssdma_customize_register_fonts');

function ssdma_link_to_url($value)
{
    $pattern = '/((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s(\"|\')]*))/';

    if (preg_match($pattern, $value, $matches) && isset($matches[0])) {
        $value = $matches[0];
    }

    return $value;
}