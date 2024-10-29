<?php
/**
 * Created by AL1.
 * User: Dmitry Nizovsky
 * Date: 13.02.15
 * Time: 18:26
 */
function ssdma_customize_register_analytics($wp_customize)
{
    $wp_customize->add_section('ssdma_analytics_settings', array(
        'title' => __('Google Analytics', 'ssdma'),
        'priority' => 110,
    ));

    // Facebook
    $wp_customize->add_setting('ssdma_analytics_tid', array(
        'default' => '',
        'capability' => 'edit_theme_options',
        'type' => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_analytics_tid', array(
        'label'    => __('Tracking Script', 'ssdma'),
        'section'  => 'ssdma_analytics_settings',
        'settings' => 'ssdma_analytics_tid',
        'priority' => 1,
    )));

}

add_action('customize_register', 'ssdma_customize_register_analytics');