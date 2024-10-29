<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 13.02.15
 * Time: 12:19
 */

function ssdma_customize_register_colors($wp_customize)
{

    // Upload header logo
    // colors

    // color link, button, price
    $wp_customize->add_setting('ssdma_colors_links', array(
        'default'           => '#ec555c',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_links', array(
        'label'    => __('Color (Search, Catalog, Links, Tabs, Price)', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_links',
    )));

    // color link, button, price hover
    $wp_customize->add_setting('ssdma_colors_links_hover', array(
        'default'           => '#DA4249',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_links_hover', array(
        'label'    => __('Color (Search, Catalog, Links, Tabs, Price) Hover', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_links_hover',
    )));

    // Main menu color
    $wp_customize->add_setting('ssdma_colors_memu', array(
        'default'           => '#FFA22E',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_memu', array(
        'label'    => __('Color (Menu)', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_memu',
    )));

    // Main menu color hover
    $wp_customize->add_setting('ssdma_colors_memu_hover', array(
        'default'           => '#FF8F00',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_memu_hover', array(
        'label'    => __('Color (Menu) Hover', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_memu_hover',
    )));

    // Main menu color border right
    $wp_customize->add_setting('ssdma_colors_links_border_r', array(
        'default'           => '#E67100',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_links_border_r', array(
        'label'    => __('Color (Menu) Border Right', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_links_border_r',
    )));

    // Main menu color border left
    $wp_customize->add_setting('ssdma_colors_links_border_l', array(
        'default'           => '#FFD9AD',
        'sanitize_callback' => 'sanitize_hex_color',
        'capability'        => 'edit_theme_options',
        'type'              => 'option',
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_links_border_l', array(
        'label'    => __('Color (Menu) Border Left', 'ssdma'),
        'section'  => 'colors',
        'settings' => 'ssdma_colors_links_border_l',
    )));
	// header text button 2
	$wp_customize->add_setting('ssdma_colors_htb2', array(
		'default'           => '#FFCA00',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_htb2', array(
		'label'    => __('Header(slider) text button 2', 'ssdma'),
		'section'  => 'colors',
		'settings' => 'ssdma_colors_htb2',
	)));
	// header text button hover 2
	$wp_customize->add_setting('ssdma_colors_htb_h2', array(
		'default'           => '#D1A200',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_htb_h2', array(
		'label'    => __('Header(slider) text button 2(hover)', 'ssdma'),
		'section'  => 'colors',
		'settings' => 'ssdma_colors_htb_h2',
	)));
	// header text button 3
	$wp_customize->add_setting('ssdma_colors_htb3', array(
		'default'           => '#FFCA00',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_htb3', array(
		'label'    => __('Header(slider) text button 3', 'ssdma'),
		'section'  => 'colors',
		'settings' => 'ssdma_colors_htb3',
	)));
	// header text button hover 3
	$wp_customize->add_setting('ssdma_colors_htb_h3', array(
		'default'           => '#D1A200',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
	));
	$wp_customize->add_control( new WP_Customize_Color_Control($wp_customize, 'ssdma_colors_htb_h3', array(
		'label'    => __('Header(slider) text button 3(hover)', 'ssdma'),
		'section'  => 'colors',
		'settings' => 'ssdma_colors_htb_h3',
	)));
}

add_action('customize_register', 'ssdma_customize_register_colors');