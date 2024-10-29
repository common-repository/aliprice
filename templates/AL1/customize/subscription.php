<?php
function ssdma_customize_register_subscription($wp_customize)
{
    $wp_customize->add_section('ssdma_subscription_settings', array(
        'title' => __('Subscription', 'ssdma'),
        'priority' => 105,
    ));

    // subscription all
    $wp_customize->add_setting('ssdma_subscribe', array(
        'default'        => '',
        'capability'     => 'edit_theme_options',
        'type'           => 'option',
        'sanitize_callback' => 'ssdma_nothing'
    ));
    $wp_customize->add_control( new ssdma_customize_textarea_control( $wp_customize, 'ssdma_subscribe', array(
        'label'    => __('Insert the code from AWeber, MailChimp, etc.', 'ssdma'),
        'section'  => 'ssdma_subscription_settings',
        'settings' => 'ssdma_subscribe',
        'priority' => 2,
    )));

}

add_action('customize_register', 'ssdma_customize_register_subscription');