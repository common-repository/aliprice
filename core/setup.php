<?php

add_action('init', 'aliprice_init_db');

function aliprice_init_db() {

    global $wpdb;

    $wpdb->products = $wpdb->prefix . "aliprice_products";
    $wpdb->review   = $wpdb->prefix . "aliprice_product_review";
}

/**
* Setup the plugin
*/
function aliprice_install( ) {

	global $wpdb;

	if ( !empty( $wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";

	require( dirname( __FILE__ ) . '/sql.php' );
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	foreach($sql as $key)
		dbDelta($key);

	aliprice_upgrade_sql();

	update_site_option( 'aliprice-version', ALIPRICE_VERSION  ); //wp_option里更新数据

	$foo = array(
		'aliprice-scheduled' 		    => serialize( array() ),
		'aliprice-autoupdate'		    => serialize( array() ),
		'aliprice-auto-current'	    => 0,
        'aliprice-appsignature'       => '',
		'aliprice-currency'		    => serialize( array() ),
		'aliprice-language'		    => 'en',
		'aliprice-program'		    => 'portals',
		'aliprice-delete'		        => 0,
		'aliprice-method'			    => 'file',
		'aliprice-max-price'		    => '100',
		'aliprice-hotdeal'		    => '0',
		'aliprice-todaysdeal'	        => '0',
		'aliprice-alibaba'		    => '0',
		'aliprice-alibaba_href'	    => '',
        'aliprice-partner_username'   => '',
        'aliprice-partner_password'   => '',
        'aliprice-app-key'            => '',
        'aliprice-tracking'           => ''

	);

	foreach( $foo as $key => $str )
		if ( !get_site_option( $key ) )
			update_site_option( $key, $str );
//сюда можно вставить апдейт кастома
  $url = get_stylesheet_directory_uri() . '/public/images/';
    $menus = wp_get_nav_menus();
    $slug_menus = array();
    $current_menus = '';
    foreach($menus as $item) {
        if (!$current_menus) {
            $current_menus = $item->slug;
        }
        $slug_menus[$item->slug] = $item->name;
    }
    $terms = get_terms('shopcategory');
    $default = 0;
    $categories = array();
    if( count($terms) ) {
        foreach( $terms as $term ) {
            if(!$default){
                $default = $term->term_id;
            }
            $categories[$term->term_id] = $term->name . ' (' . $term->count . ')';
        }
    }
	global $wpdb;
	$exist = $wpdb->get_var($wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s','AL1'));
	if(!$exist) {
	$fields = array(

'ssdma_analytics_tid'=>'',
'ssdma_colors_links'=>'#ec555c',
'ssdma_colors_links_hover'=>'#DA4249',
'ssdma_colors_memu'=>'#FFA22E',
'ssdma_colors_memu_hover'=>'#FF8F00',
'ssdma_colors_links_border_r'=>'#E67100',
'ssdma_colors_links_border_l'=>'#FFD9AD',
'ssdma_colors_htb2'=>'#FFCA00',
'ssdma_colors_htb_h2'=>'#D1A200',
'ssdma_colors_htb3'=>'#FFCA00',
'ssdma_colors_htb_h3'=>'#D1A200',
'ssdma_font_family_global_url'=>'',
'ssdma_font_family_global_name'=>'',
'ssdma_font_family_header_url'=>'',
'ssdma_font_family_header_name'=>'',
'ssdma_images_logo_header'=> $url . 'logo.png',
'ssdma_images_logo_footer'=> $url . 'logof.png',
'ssdma_images_logo_favicon'=>$url . 'favicon.ico',
'ssdma_images_fs'=>$url . 'free-shipping.jpg',
'ssdma_slider_image1'=> $url . 'header_img.jpg',
'ssdma_slider_image2'=>'',
'ssdma_slider_image3'=>'',
'ssdma_nav_header'=>$current_menus,
'ssdma_nav_main'=> $current_menus,
'ssdma_nav_footer'=> $current_menus,
'ssdma_products_cat1'=>$default,
'ssdma_products_cat2'=>$default,
'ssdma_products_cat3'=>$default,
'ssdma_products_cat4'=>$default,
'ssdma_seo_keywords'=>'',
'ssdma_seo_desc'=>'',
'ssdma_seo_main'=>'<div class="container"></div>',
'ssdma_social_facebook'=>'',
'ssdma_social_twitter'=>'',
'ssdma_social_gplus'=>'',
'ssdma_social_youtube'=>'',
'ssdma_social_pinterest'=>'',
'ssdma_social_vk'=>'',
'ssdma_subscribe'=>'',
'ssdma_text_line'=>'Smarter Shopping, Better Living!',
'ssdma_htextphone_line'=>'<span class="b-social-icon-phone"></span> 24/7 Customer Service (800) 927-7671',
'ssdma_htext_line'=>'',
'ssdma_htext_line2'=>'',
'ssdma_htext_line3'=>'',
'ssdma_beforef1_line'=>'',
'ssdma_beforef2_line'=>'',
'ssdma_catalogue'=>'Go to Catalogue',
'ssdma_catalogue2'=>'Go to Catalogue',
'ssdma_catalogue3'=>'Go to Catalogue',
'ssdma_buynow'=>'',
'ssdma_buynow_text'=>'',
'ssdma_copyright'=>'',
'ssdma_images_before_footer'=>'',
'ssdma_products_cat5'=>'',
'ssdma_htext_seoh'=>'',
'ssdma_htext_seod'=>'',
'ssdma_banners_1'=>'',
'ssdma_banners_2'=>'',
'ssdma_colors_htb_h'=>'',
'ssdma_colors_htb'=>'',
'ssdma_colors_h_line'=>''
);

foreach($fields as $k=>$v){
 $q = $wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s',$k);
 $fields[$k] = $wpdb->get_var( $q );
}
        if( $fields['ssdma_slider_image1'] = ''){ $fields['ssdma_slider_image1'] = get_header_image();}

update_option( 'AL1', $fields );
}
    $existal2 = get_site_option( 'stylesheet' );

    if ($existal2 == 'AL2'){
        $exist2 = $wpdb->get_var( $wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s','AL2') );
        if(!$exist2) {
            $fields = array(

                'ssdma_analytics_tid'=>'',
                'ssdma_colors_links'=>'#00AAD5',
                'ssdma_colors_links_hover'=>'#59bdd6',
                'ssdma_colors_memu'=>'#FFA22E',
                'ssdma_colors_memu_hover'=>'#FF8F00',
                'ssdma_colors_links_border_r'=>'#E67100',
                'ssdma_colors_links_border_l'=>'#FFD9AD',
                'ssdma_colors_htb2'=>'#FFCA00',
                'ssdma_colors_htb_h2'=>'#D1A200',
                'ssdma_colors_htb3'=>'#FFCA00',
                'ssdma_colors_htb_h3'=>'#D1A200',
                'ssdma_font_family_global_url'=>'',
                'ssdma_font_family_global_name'=>'',
                'ssdma_font_family_header_url'=>'',
                'ssdma_font_family_header_name'=>'',
                'ssdma_images_logo_header'=> $url . 'logo.png',
                'ssdma_images_logo_footer'=> $url . 'logof.png',
                'ssdma_images_logo_favicon'=>$url . 'favicon.ico',
                'ssdma_images_fs'=>$url . 'free-shipping.jpg',
                'ssdma_slider_image1'=> $url . 'header_img.jpg',
                'ssdma_slider_image2'=>'',
                'ssdma_slider_image3'=>'',
                'ssdma_nav_header'=>$current_menus,
                'ssdma_nav_main'=> $current_menus,
                'ssdma_nav_footer'=> $current_menus,
                'ssdma_products_cat1'=>$default,
                'ssdma_products_cat2'=>$default,
                'ssdma_products_cat3'=>$default,
                'ssdma_products_cat4'=>$default,
                'ssdma_seo_keywords'=>'',
                'ssdma_seo_desc'=>'',
                'ssdma_seo_main'=>'<div class="container"></div>',
                'ssdma_social_facebook'=>'',
                'ssdma_social_twitter'=>'',
                'ssdma_social_gplus'=>'',
                'ssdma_social_youtube'=>'',
                'ssdma_social_pinterest'=>'',
                'ssdma_social_vk'=>'',
                'ssdma_subscribe'=>'',
                'ssdma_text_line'=>'Smarter Shopping, Better Living!',
                'ssdma_htextphone_line'=>'<span class="b-social-icon-phone"></span> 24/7 Customer Service (800) 927-7671',
                'ssdma_htext_line'=>'',
                'ssdma_htext_line2'=>'',
                'ssdma_htext_line3'=>'',
                'ssdma_beforef1_line'=>'',
                'ssdma_beforef2_line'=>'',
                'ssdma_catalogue'=>'Go to Catalogue',
                'ssdma_catalogue2'=>'Go to Catalogue',
                'ssdma_catalogue3'=>'Go to Catalogue',
                'ssdma_buynow'=>'',
                'ssdma_buynow_text'=>'',
                'ssdma_copyright'=>'',
                'ssdma_images_before_footer'=>'',
                'ssdma_products_cat5'=>'',
                'ssdma_htext_seoh'=>'',
                'ssdma_htext_seod'=>'',
                'ssdma_banners_1'=>'',
                'ssdma_banners_2'=>'',
                'ssdma_colors_htb'=>'#FFCA00',
                'ssdma_colors_htb_h'=>'#D1A200',
                'ssdma_colors_h_line'=>'#00AAD5'
            );

            foreach($fields as $k=>$v){
                $q = $wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s',$k);
                $fields[$k] = $wpdb->get_var( $q );
            }
            if( $fields['ssdma_slider_image1'] = ''){ $fields['ssdma_slider_image1'] = get_header_image();}
            update_option( 'AL2', $fields );
        }
    }
    $existal3= get_site_option( 'stylesheet' );

    if ($existal3 == 'AL3'){
        $exist3 = $wpdb->get_var( $wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s','AL3') );
        if(!$exist3) {
            $fields = array(

                'ssdma_analytics_tid'=>'',
                'ssdma_colors_links'=>'#ec555c',
                'ssdma_colors_links_hover'=>'#DA4249',
                'ssdma_colors_memu'=>'#FFA22E',
                'ssdma_colors_memu_hover'=>'#FF8F00',
                'ssdma_colors_links_border_r'=>'#E67100',
                'ssdma_colors_links_border_l'=>'#FFD9AD',
                'ssdma_colors_htb2'=>'#FFCA00',
                'ssdma_colors_htb_h2'=>'#D1A200',
                'ssdma_colors_htb3'=>'#FFCA00',
                'ssdma_colors_htb_h3'=>'#D1A200',
                'ssdma_font_family_global_url'=>'',
                'ssdma_font_family_global_name'=>'',
                'ssdma_font_family_header_url'=>'',
                'ssdma_font_family_header_name'=>'',
                'ssdma_images_logo_header'=> $url . 'logo.png',
                'ssdma_images_logo_footer'=> $url . 'logof.png',
                'ssdma_images_logo_favicon'=>$url . 'favicon.ico',
                'ssdma_images_fs'=>$url . 'free-shipping.jpg',
                'ssdma_slider_image1'=> $url . 'header_img.jpg',
                'ssdma_slider_image2'=>'',
                'ssdma_slider_image3'=>'',
                'ssdma_nav_header'=>$current_menus,
                'ssdma_nav_main'=> $current_menus,
                'ssdma_nav_footer'=> $current_menus,
                'ssdma_products_cat1'=>$default,
                'ssdma_products_cat2'=>$default,
                'ssdma_products_cat3'=>$default,
                'ssdma_products_cat4'=>$default,
                'ssdma_seo_keywords'=>'',
                'ssdma_seo_desc'=>'',
                'ssdma_seo_main'=>'<div class="container"></div>',
                'ssdma_social_facebook'=>'',
                'ssdma_social_twitter'=>'',
                'ssdma_social_gplus'=>'',
                'ssdma_social_youtube'=>'',
                'ssdma_social_pinterest'=>'',
                'ssdma_social_vk'=>'',
                'ssdma_subscribe'=>'',
                'ssdma_text_line'=>'Smarter Shopping, Better Living!',
                'ssdma_htextphone_line'=>'<span class="b-social-icon-phone"></span> 24/7 Customer Service (800) 927-7671',
                'ssdma_htext_line'=>'',
                'ssdma_htext_line2'=>'',
                'ssdma_htext_line3'=>'',
                'ssdma_beforef1_line'=>'',
                'ssdma_beforef2_line'=>'',
                'ssdma_catalogue'=>'Go to Catalogue',
                'ssdma_catalogue2'=>'Go to Catalogue',
                'ssdma_catalogue3'=>'Go to Catalogue',
                'ssdma_buynow'=>'',
                'ssdma_buynow_text'=>'',
                'ssdma_copyright'=>'',
                'ssdma_images_before_footer'=>'',
                'ssdma_products_cat5'=>'',
                'ssdma_htext_seoh'=>'',
                'ssdma_htext_seod'=>'',
                'ssdma_banners_1'=>'',
                'ssdma_banners_2'=>'',
                'ssdma_colors_htb_h'=>'',
                'ssdma_colors_htb'=>'',
                'ssdma_colors_h_line'=>''
            );

            foreach($fields as $k=>$v){
                $q = $wpdb->prepare('SELECT `option_value` FROM `wp_options` WHERE `option_name`=%s',$k);
                $fields[$k] = $wpdb->get_var( $q );
            }
            if( $fields['ssdma_slider_image1'] = ''){ $fields['ssdma_slider_image1'] = get_header_image();}
            update_option( 'AL3', $fields );
        }
    }
	do_action('aliprice_switch');
}

add_action('aliprice_switch', 'aliprice_switch_theme');
function aliprice_switch_theme( ) {

	if ( !get_site_option( 'aliprice_activate_theme' ) ) {
		update_site_option('aliprice_activate_theme', 1);
		switch_theme('AL1');
	}
}

/**
* Uninstall plugin
*/
function aliprice_uninstall( ) {
	delete_site_option('aliprice_activate_theme');
}

add_action( 'admin_menu', 'aliprice_installed' );
function aliprice_installed( ){

	if ( !current_user_can('install_plugins') ) return;

	if ( get_site_option( 'aliprice-version' ) < ALIPRICE_VERSION )
		aliprice_install( );
}

function aliprice_upgrade_sql( ) {

	global $wpdb;

	maybe_add_column($wpdb->prefix . 'aliprice_products', 'owncat', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `owncat` INT(1) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'validTime', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `validTime` DATETIME NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'productUrl', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `productUrl` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'evaluateScore', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `evaluateScore` DECIMAL(2,1) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'storeName', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `storeName` VARCHAR(255) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'storeUrl', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `storeUrl` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'storeUrlAff', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `storeUrlAff` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'countReview', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `countReview` INT(11) NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'sku', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `sku` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'pack', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `pack` TEXT NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aliprice_products', 'quantity', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `quantity` INT(11) unsigned NOT NULL;");
	maybe_add_column($wpdb->prefix . 'aaliprice_products', 'timeleft', "ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD `timeleft` INT(11) unsigned NOT NULL;");

	$foo = array('productId', 'post_id');
	$too = array();
	$res = $wpdb->get_results("SHOW INDEXES FROM `{$wpdb->prefix}aliprice_products`");

	if($res) foreach( $res as $r ){
		$too[] = $r->Column_name;
	}

	$result = array_diff ($foo, $too);

	if( count($result) > 0 ){

		foreach($result as $key => $val)
			$wpdb->query("ALTER TABLE `{$wpdb->prefix}aliprice_products` ADD INDEX `{$val}` (`{$val}`)");
	}
}



function aliprice_activate( ) {

	aliprice_installed();

	do_action( 'aliprice_activate' );
}

function aliprice_deactivate( ) {

	do_action( 'aliprice_deactivate' );
}

/**
*	Check current template type. Default or Not
*/
//add_action('init', 'aliprice_template_type');
function aliprice_template_type( ) {

	$tmpl = get_site_option( 'aliprice-appearance' );

	$tmpl = ( !empty($tmpl) && $tmpl == 1 ) ? 1 : 0;

	if ( !defined('ALIPRICE_TMPL') ) define( 'ALIPRICE_TMPL', $tmpl );
}

/**
 * Get fields from schema
 * @return mixed
 */
function aliprice_get_db_fields( ) {

    global $wpdb;

    return $wpdb->get_results(
        $wpdb->prepare(
            "SELECT `DATA_TYPE`, `CHARACTER_MAXIMUM_LENGTH`, `COLUMN_NAME`
                  FROM `information_schema`.`COLUMNS`
                  WHERE `TABLE_SCHEMA` = '%s'
                  AND `TABLE_NAME` = '{$wpdb->products}'",
            DB_NAME
        )
    );
}

/**
 * Check count fields which need to update
 * @return int
 */
function aliprice_check_db_fields( ) {

    $count = 0;
    $cols = aliprice_get_db_fields();
    $foo = aliprice_db_queries();
    if( $cols ){
        foreach($cols as $col) {

            if( isset($foo[$col->COLUMN_NAME]) ) {

                if(
                    $col->DATA_TYPE != $foo[$col->COLUMN_NAME]['type'] ||
                    $col->CHARACTER_MAXIMUM_LENGTH < $foo[$col->COLUMN_NAME]['numb']
                ) {
                    $count++;
                }
            }
        }
    }

    return $count;
}

/**
 * Update fields
 * @return bool
 */
function aliprice_update_db_fields( ) {

    global $wpdb;

    $cols = aliprice_get_db_fields();
    $foo = aliprice_db_queries();
    if( $cols ){
        foreach($cols as $col) {

            if( isset($foo[$col->COLUMN_NAME]) ) {

                if(
                    $col->DATA_TYPE != $foo[$col->COLUMN_NAME]['type'] ||
                    $col->CHARACTER_MAXIMUM_LENGTH < $foo[$col->COLUMN_NAME]['numb']
                ) {
                    $wpdb->query($foo[$col->COLUMN_NAME]['query']);
                }
            }
        }
    }

    return true;
}

/**
 * Constant queries
 * @return array
 */
function aliprice_db_queries( ) {

    global $wpdb;
    return array(
        'price' => array(
            'query' => "ALTER TABLE  `{$wpdb->products}` CHANGE  `price`  `price` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
            'type'  => "varchar",
            'numb'  => 40,
        ),
        'salePrice' => array(
            'query' => "ALTER TABLE  `{$wpdb->products}` CHANGE  `salePrice`  `salePrice` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL",
            'type'  => "varchar",
            'numb'  => 40,
        ),
    );
}

/**
 * Change fields
 */
function aliprice_set_db_changes( ) {

    if ( isset( $_POST['aliprice_migrate'] ) && wp_verify_nonce( $_POST['aliprice_migrate'], 'aliprice_migrate_action' ) ){

        aliprice_update_db_fields( );

        wp_redirect( admin_url( 'admin.php?page=aliprice' ) );

        die();
    }
}
add_action('admin_init', 'aliprice_set_db_changes');