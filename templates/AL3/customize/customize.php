<?php

/* Parent options */
include get_template_directory() . '/customize/fonts.php';
include get_template_directory() . '/customize/analyticstracking.php';
include get_template_directory() . '/customize/images.php';
include get_template_directory() . '/customize/social.php';
include get_template_directory() . '/customize/nav.php';
include get_template_directory() . '/customize/products.php';
include get_template_directory() . '/customize/seo.php';
include get_template_directory() . '/customize/subscription.php';

/* Child options */
include get_stylesheet_directory() . '/customize/images.php';
include get_stylesheet_directory() . '/customize/products.php';
include get_stylesheet_directory() . '/customize/colors.php';
include get_stylesheet_directory() . '/customize/text.php';