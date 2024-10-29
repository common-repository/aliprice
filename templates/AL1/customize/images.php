<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 03.02.15
 * Time: 12:55
 */
function ssdma_customize_register_images($wp_customize)
{
    $url = get_stylesheet_directory_uri() . '/public/images/';

    $wp_customize->add_section( 'ssdma_images_settings', array(
        'title' => __('Logo & Favicon', 'ssdma'),
        'priority' => 65,
    ) );

    // Upload header logo
    $wp_customize->add_setting('ssdma_images_logo_header', array(
        'default'    => $url . 'logo.png',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'ssdma_images_logo_header', array(
        'label'    => __('Header', 'ssdma') . ' (180x60)',
        'section'  => 'ssdma_images_settings',
        'settings' => 'ssdma_images_logo_header',
    )));

    // Upload footer logo
    $wp_customize->add_setting('ssdma_images_logo_footer', array(
        'default'    => $url . 'logof.png',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'ssdma_images_logo_footer', array(
        'label'    => __('Footer', 'ssdma') . ' (180x60)',
        'section'  => 'ssdma_images_settings',
        'settings' => 'ssdma_images_logo_footer',
    )));

    // Upload favicon logo
    $wp_customize->add_setting('ssdma_images_logo_favicon', array(
        'default'    => $url . 'favicon.ico',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ssdma_images_logo_favicon', array(
        'label'    => __('Favicon', 'ssdma') . ' (16x16)',
        'section'  => 'ssdma_images_settings',
        'settings' => 'ssdma_images_logo_favicon',
    )));
	// Upload freeshipping
	$wp_customize->add_setting('ssdma_images_fs', array(
		'default'    => $url . 'free-shipping.jpg',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ssdma_images_fs', array(
		'label'    => __('Free Shipping image', 'ssdma') . ' (180x42)',
		'section'  => 'ssdma_images_settings',
		'settings' => 'ssdma_images_fs',
	)));
	$wp_customize->add_setting('ssdma_slider_image2', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ssdma_slider_image2', array(
		'label'    => __('Slider image 2', 'ssdma'),
		'section'  => 'ssdma_images_settings',
		'settings' => 'ssdma_slider_image2',
	)));
	$wp_customize->add_setting('ssdma_slider_image3', array(
		'default'    => '',
		'capability' => 'edit_theme_options',
		'type'       => 'option',
		'sanitize_callback' => 'ssdma_nothing'
	));
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ssdma_slider_image3', array(
		'label'    => __('Slider image 3', 'ssdma'),
		'section'  => 'ssdma_images_settings',
		'settings' => 'ssdma_slider_image3',
	)));
}

add_action('customize_register', 'ssdma_customize_register_images');