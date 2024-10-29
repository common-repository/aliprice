<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 02.02.15
 * Time: 11:47
 */
function ssdma_customize_register_text($wp_customize)
{
    $wp_customize->add_section('ssdma_text_settings', array(
        'title' => __('Text', 'ssdma'),
        'priority' => 45,
    ));

    // Text header phone
    $wp_customize->add_setting('ssdma_htextphone_line', array(
        'default' => '<span class="b-social-icon-phone"></span> 24/7 Customer Service (800) 927-7671',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_htextphone_line', array(
        'priority' => 3,
        'label' => __('Text top header', 'ssdma'),
        'section' => 'ssdma_text_settings',
        'settings' => 'ssdma_htextphone_line',
    ));

    // Text header
    $wp_customize->add_setting('ssdma_htext_line', array(
	'default' => '',
	'capability' => 'edit_theme_options',
	'type' => 'option',
	'sanitize_callback' => 'ssdma_nothing'
));
	$wp_customize->add_control('ssdma_htext_line', array(
		'priority' => 3,
		'label' => __('Text header', 'ssdma'),
		'section' => 'ssdma_text_settings',
		'settings' => 'ssdma_htext_line',
	));
	$wp_customize->add_setting('ssdma_htext_line2', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_htext_line2', array(
		'priority' => 3,
		'label' => __('Text header 2', 'ssdma'),
		'section' => 'ssdma_text_settings',
		'settings' => 'ssdma_htext_line2',
	));
	$wp_customize->add_setting('ssdma_htext_line3', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_htext_line3', array(
		'priority' => 3,
		'label' => __('Text header 3', 'ssdma'),
		'section' => 'ssdma_text_settings',
		'settings' => 'ssdma_htext_line3',
	));
    // Before footer 1
    $wp_customize->add_setting('ssdma_beforef1_line', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_beforef1_line', array(
        'label'    => __('Description', 'ssdma') . ' #1',
        'section'  => 'ssdma_text_settings',
        'settings' => 'ssdma_beforef1_line',
        'priority' => 4,
    )));

    // Before footer 2
    $wp_customize->add_setting('ssdma_beforef2_line', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_beforef2_line', array(
        'label'    => __('Description', 'ssdma') . ' #2',
        'section'  => 'ssdma_text_settings',
        'settings' => 'ssdma_beforef2_line',
        'priority' => 5,
    )));

    // Seo text header
    $wp_customize->add_setting('ssdma_htext_seoh', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_htext_seoh', array(
        'priority' => 6,
        'label' => __('Seo text header', 'ssdma'),
        'section' => 'ssdma_text_settings',
        'settings' => 'ssdma_htext_seoh',
    ));

    // Seo text description
    $wp_customize->add_setting('ssdma_htext_seod', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_htext_seod', array(
        'label'    => __('Seo text description', 'ssdma'),
        'section'  => 'ssdma_text_settings',
        'settings' => 'ssdma_htext_seod',
        'priority' => 7,
    )));
	
		    // Go to catalogue
    $wp_customize->add_setting('ssdma_catalogue', array(
        'default'        => 'Go to Catalogue',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_catalogue', array(
        'label'    => __('Catalogue text', 'ssdma'),
        'section'  => 'ssdma_text_settings',
        'settings' => 'ssdma_catalogue',
        'priority' => 4,
    ));
	$wp_customize->add_setting('ssdma_catalogue2', array(
		'default'        => 'Go to Catalogue',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_catalogue2', array(
		'label'    => __('Catalogue text 2', 'ssdma'),
		'section'  => 'ssdma_text_settings',
		'settings' => 'ssdma_catalogue2',
		'priority' => 4,
	));
	$wp_customize->add_setting('ssdma_catalogue3', array(
		'default'        => 'Go to Catalogue',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_catalogue3', array(
		'label'    => __('Catalogue text 3', 'ssdma'),
		'section'  => 'ssdma_text_settings',
		'settings' => 'ssdma_catalogue3',
		'priority' => 4,
	));
	// Order now
	$wp_customize->add_setting('ssdma_buynow', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_buynow', array(
		'priority' => 7,
		'label' => __('"Order Now" button text', 'ssdma'),
		'section' => 'ssdma_text_settings',
		'settings' => 'ssdma_buynow',
	));
	$wp_customize->add_setting('ssdma_buynow_text', array(
		'default' => '',
		'capability' => 'edit_theme_options',
		'type' => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control('ssdma_buynow_text', array(
		'priority' => 8,
		'label' => __('"from Aliexpress" text', 'ssdma'),
		'section' => 'ssdma_text_settings',
		'settings' => 'ssdma_buynow_text',
	));
    $wp_customize->add_setting('ssdma_copyright', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control('ssdma_copyright', array(
        'priority' => 8,
        'label' => __('"Powered by" text', 'ssdma'),
        'section' => 'ssdma_text_settings',
        'settings' => 'ssdma_copyright',
    ));
}

add_action('customize_register', 'ssdma_customize_register_text');