<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 03.02.15
 * Time: 12:55
 */
function ssdma_customize_register_images_child($wp_customize)
{
    $url = get_stylesheet_directory_uri() . '/public/images/';

    // Upload footer logo
    $wp_customize->add_setting('ssdma_images_before_footer', array(
        'default'    => $url . 'footer_img.jpg',
        'capability' => 'edit_theme_options',
        'type'       => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'ssdma_images_before_footer', array(
        'label'    => __('Before Footer', 'ssdma') . ' (1920x360)',
        'section'  => 'ssdma_images_settings',
        'settings' => 'ssdma_images_before_footer',
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

add_action('customize_register', 'ssdma_customize_register_images_child');