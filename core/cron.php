<?php

/**
* 	On an early action hook, check if the hook is scheduled - if not, schedule it.
*	Sheduled to auto update products
*/
add_action( 'admin_init', 'aliprice_setup_schedule' );
function aliprice_setup_schedule( ) {

	if ( !wp_next_scheduled( 'aliprice_cron_event' ) ) {

		$defaults = array(
			'inteval' => 'daily',
			'enabled' => '0'
		);

		$args = get_site_option('aliprice-autoupdate');
		$args = ( !$args ) ? array() : unserialize($args);

		$args = wp_parse_args( $args, $defaults );

		extract( $args, EXTR_OVERWRITE );

		if( $enabled == 1 )
			wp_schedule_event( time(), $inteval, 'aliprice_cron_event');
		else
			wp_clear_scheduled_hook( 'aliprice_cron_event' );
	}

	if ( !wp_next_scheduled( 'aliprice_cron_currency' ) ) {

		$defaults = array(
			'inteval'	=> 'daily',
			'enabled'	=> '0',
			'currency'	=> ''
		);

		$args = get_site_option('aliprice-currency');
		$args = ( !$args ) ? array() : unserialize($args);

		$args = wp_parse_args( $args, $defaults );

		extract( $args, EXTR_OVERWRITE );

		if( $enabled == 1 )
			wp_schedule_event( time(), $inteval, 'aliprice_cron_currency');
		else
			wp_clear_scheduled_hook( 'aliprice_cron_currency' );
	}
}

/**
* 	On an early action hook, check if the hook is scheduled - if not, schedule it.
*	Scheduled to auto import products
*/
add_action( 'admin_init', 'aliprice_setup_schedule_import' );
function aliprice_setup_schedule_import( ) {

	if ( !wp_next_scheduled( 'aliprice_cron_import' ) ) {

		$defaults = array(
			'categories' 		=> '',
			'keywords' 			=> '',
			'promotionfrom' 	=> '10',
			'promotionto' 		=> '5000',
			'pricefrom' 		=> '',
			'priceto' 			=> '',
			'inteval' 			=> 'daily',
			'enabled' 			=> '0',
			'creditScoreFrom'	=> '',
			'creditScoreTo'		=> '',
            'dropcat'		    => '',
            'status'		    => '',
            'fs'		        => '',
            'unitType'		    => '',
		);

		$args = get_site_option('aliprice-scheduled');
		$args = ( !$args ) ? array() : unserialize($args);

		$args = wp_parse_args( $args, $defaults );

		extract( $args, EXTR_OVERWRITE );

		if( $enabled == 1 )
			wp_schedule_event( time(), $inteval, 'aliprice_cron_import' );
		else
			wp_clear_scheduled_hook( 'aliprice_cron_import' );
	}
}

/**
*	Clean wrong products
*/
add_action( 'admin_init', 'aliprice_setup_schedule_clean' );
function aliprice_setup_schedule_clean( ) {

	if ( !wp_next_scheduled( 'aliprice_cron_clean' ) )
		wp_schedule_event( time(), 'daily', 'aliprice_cron_clean');
}

/**
* 	Auto update products
*/
add_action( 'aliprice_cron_event', 'aliprice_do_cron_event' );
function aliprice_do_cron_event() {

	global $wpdb;

	$current = get_site_option('aliprice-auto-current');
	$delete = get_site_option('aliprice-delete');

	$count = $wpdb->get_var("SELECT count(`id`) as `con` FROM `{$wpdb->prefix}aliprice_products` WHERE `post_id` <> 0");

	if( $current > $count ) $current = 0;

	$insert = new AliExpressInsert();

	$result = $insert->updateProductsDetailsMini( $current, 25 );

	if( !is_array($result)) {

		update_site_option( 'aliprice-auto-current', $current + 25 );

		return;
	}

	foreach( $result as $key => $productId ) {

		if( isset($productId['error']) ){

			if( isset($productId['id']) ) {

				if( !empty($productId['post_id']) ) {
					if( $delete == 1 ){
						wp_delete_post($productId['post_id'], true);
						$wpdb->delete( $wpdb->prefix . "aliprice_products", array( 'post_id' => $productId['post_id'] ), array( '%d' ) );
					}
					else{
						$wpdb->update(
							$wpdb->prefix . "aliprice_products",
							array( 'availability' => 0 ),
							array( 'post_id' => $productId['post_id'] ),
							array( '%d' ),
							array( '%d' )
						);
					}
				}
			}
		}
		else {

			if (!$productId) continue;
		}
	}

	update_site_option( 'aliprice-auto-current', $current + 25 );

	aliprice_set_max_price();
}

/**
* 	Auto update real currency
*/
add_action( 'aliprice_cron_currency', 'aliprice_do_cron_currency' );
function aliprice_do_cron_currency() {

	$defaults = array(
		'inteval'	=> 'daily',
		'enabled'	=> '0',
		'currency'	=> '',
		'value'		=> ''
	);

	$args = get_site_option('aliprice-currency');
	$args = ( !$args ) ? array() : unserialize($args);

	$args = wp_parse_args( $args, $defaults );

	extract( $args, EXTR_OVERWRITE );

	$value = aliprice_convertCurrency( 1, 'USD', $currency );

	if( !$value )
		return;

	$foo = array(
		'inteval'	=> $inteval,
		'enabled'	=> $enabled,
		'currency'	=> $currency,
		'value'		=> $value,
		'round'		=> $round
	);

	update_site_option( 'aliprice-currency', serialize($foo) );
}

/**
* 	Auto import products
*/
add_action( 'aliprice_cron_import', 'aliprice_do_cron_import' );
function aliprice_do_cron_import( ) {

	$defaults = array(
		'categories' 		=> '',
		'keywords' 			=> '',
		'promotionfrom' 	=> '10',
		'promotionto' 		=> '5000',
		'pricefrom' 		=> 0,
		'priceto' 			=> 0,
		'inteval' 			=> 'daily',
		'enabled' 			=> '0',
		'creditScoreFrom'	=> '',
		'creditScoreTo'		=> '',
		'page_no'			=> 1,
		'count_import'		=> 10,
		'all_match'			=> 10,
		'fs'                => 0,
		'unitType'          => '',
        'publishstatus'     => 'publish',
	);

	$args = get_site_option('aliprice-scheduled');

	$args = ( !$args ) ? array() : unserialize($args);

	$args = wp_parse_args( $args, $defaults );

	if( $args['enabled'] == 0 ) return;

	$limit = $now = $args['all_match'] - $args['page_no'] * $args['count_import'];
	if( $now < 0 )
		$now = $args['count_import'] - ($args['page_no'] * $args['count_import'] - $args['all_match']);

	if( $now <= 0 ) { //end of sheduled import

		$args['enabled'] = 0;

		update_site_option( 'aliprice-scheduled', serialize( $args ) );

		wp_clear_scheduled_hook( 'aliprice_cron_import' );

		return;
	}

	$fs = ( $args['fs'] === 0 ) ? false : true;
	$unitType = ( isset($args['unitType']) && in_array($args['unitType'], array('piece', 'lot')) ) ? $args['unitType'] : '';

    $ourcat = $args['dropcat'];
    $status = !empty($args['publishstatus']) ? $args['publishstatus'] : 'publish';

	$obj = new AliExpressInsert();

	$obj->set_frees($fs);
	$obj->set_unit_type($unitType);

	$search = $obj->searchByCategory(
        $args['categories'],
        $args['page_no'],
        array(
            'keywords' 				=> $args['keywords'],
            'originalPriceFrom' 	=> aliprice_floatvalue($args['pricefrom']),
            'originalPriceTo' 		=> aliprice_floatvalue($args['priceto']),
            'volumeFrom' 			=> intval($args['promotionfrom']),
            'volumeTo' 				=> intval($args['promotionto']),
            'startCreditScore' 		=> intval($args['creditScoreFrom']),
            'endCreditScore' 		=> intval($args['creditScoreTo'])
        ),
        $args['count_import']
    );

	if( isset($search['error']) ) return; // 

	$arguments = $search['result']->products;

	$i = $fail = $success = 0;

	foreach( $arguments as $data ) {

		$i++;

		if( $limit < 0 && $i > $now ) continue;

		$foo['lotNum'] 			= intval( $data->lotNum );
		$foo['packageType'] 	= strip_tags( $data->packageType );
		$foo['imageUrl'] 		= strip_tags( $data->imageUrl );
		$foo['productId'] 		= intval( $data->productId );
		$foo['price'] 			= strip_tags( $data->originalPrice );
		$foo['validTime'] 		= aliprice_dbdate( $data->validTime );
		$foo['subject'] 		= strip_tags( $data->productTitle );
		$foo['productUrl'] 		= strip_tags( $data->productUrl );
		$foo['promotionVolume'] = intval( $data->volume );
		$foo['evaluateScore'] 	= strip_tags( $data->evaluateScore );
		$foo['salePrice'] 		= strip_tags( $data->salePrice );

		$id = $obj->insertOneItem( intval( $args['categories'] ), $foo);

        $details = $obj->getDetailById( $foo['productId'] );

        if( !$details || isset($details['error']) ){
            $fail++;
        }
        else{
            $pub = new AliExpressPublish( $foo['productId'], $ourcat, $status  );
            $published = $pub->Published( );

            if( !$published || ( is_array($published) && isset($published['error']) ) )
                $fail++;
            else
                $success++;
	    }
	}

	$args['page_no'] = $args['page_no'] + 1;

	update_site_option( 'aliprice-scheduled', serialize( $args ) );

	aliprice_set_max_price();
}

/**
*	Clean wrong data
*/
add_action( 'aliprice_cron_clean', 'aliprice_do_cron_clean' );
function aliprice_do_cron_clean() {

	global $wpdb;

	$wpdb->delete( $wpdb->prefix . 'aliprice_products', array( 'post_id' => 0 ) );
}

/**
*	Shedules intervals
*/
function aliprice_get_cron_intervals( ) {

	$intervals = wp_get_schedules();

	$foo = array();

	foreach( $intervals as $key => $val ) {

		$foo[$key] = $val['display'];
	}

	return $foo;
}

/**
*	Review
*/

add_action( 'admin_init', 'aliprice_setup_schedule_review' );
function aliprice_setup_schedule_review( ) {

	if ( !wp_next_scheduled( 'aliprice_cron_review' ) ) {

		$defaults = array(
			'inteval' 			=> 'daily',
			'enabled' 			=> 0,
			'position' 			=> 1,
			'count_settings'	=> 40,
			'star'              => 1
		);

		$args = get_site_option('aliprice-scheduled-review');
		$args = ( !$args ) ? array() : unserialize($args);

		$args = wp_parse_args( $args, $defaults );

		extract( $args, EXTR_OVERWRITE );

		if( $enabled == 1 )
			wp_schedule_event( time(), $inteval, 'aliprice_cron_review' );
		else
			wp_clear_scheduled_hook( 'aliprice_cron_review' );
	}
}
add_action( 'aliprice_cron_review', 'aliprice_cron_review' );
function aliprice_cron_review( ) {
	
		$defaults = array(
			'inteval' 			=> 'daily',
			'enabled' 			=> 0,
			'position' 			=> 1,
			'count_settings'	=> 40,
			'star'              => 1
		);

	$args = get_site_option('aliprice-scheduled-review');

	$args = ( !$args ) ? array() : unserialize($args);

	$args = wp_parse_args( $args, $defaults );

	if( $args['enabled'] == 0 ) return;
	$position = $args['position'];
	$count_settings = $args['count_settings'];
	$count_products = aliprice_total_count_products();
	if( $position > $count_products  )
		$position = 1;

	aliprice_schedule_review($position, 5, $count_settings, $args['star']);
	$args['position'] = $position + 5;	
	update_site_option( 'aliprice-scheduled-review', serialize( $args ) );
}