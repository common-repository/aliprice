<?php
	/**
	*	Plugin Name: AliPrice
	*	Plugin URI: https://www.aliprice.com/
	*	Description: AliPrice is a WordPress plugin created for AliExpress Affiliate Program
	*	Version: 1.0
	*	Author: Uni
	*	Author URI: http://www.aliprice.com/
	* 	License: GPLv2
	*	License URI: https://www.gnu.org/licenses/gpl-2.0.html
	*/

	/**
	*	Version of the plugin
	*/
	if ( !defined('ALIPRICE_VERSION') ) define( 'ALIPRICE_VERSION', '1.00' );
	if ( !defined('ALIPRICE_PATH') ) define( 'ALIPRICE_PATH', plugin_dir_path( __FILE__ ) );
	
	register_theme_directory( ALIPRICE_PATH . 'templates' );

	require( dirname( __FILE__ ) . '/libs/Requests/Requests.php' );
	Requests_::register_autoloader();
	
	require( dirname( __FILE__ ) . '/core/setup.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Request2.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.AdminTpl.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Settings.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.insertAPI.php' );
	require( dirname( __FILE__ ) . '/core/class.AliExpress.Publication.php' );
	require( dirname( __FILE__ ) . '/core/class.Products.php' );
	require( dirname( __FILE__ ) . '/core/shortcodes.php' );
	require( dirname( __FILE__ ) . '/core/core.php' );
	require( dirname( __FILE__ ) . '/core/cron.php' );
	require( dirname( __FILE__ ) . '/core/init.php' );
	
	if( is_admin() ) :
		require( dirname( __FILE__ ) . '/core/request.php' );
	else :
		require( dirname( __FILE__ ) . '/core/openGraphProtocol.php' );
	endif;
	
	require( dirname( __FILE__ ) . '/core/menu.php' );
	
	register_activation_hook( __FILE__, 'aliprice_install' );
	register_uninstall_hook( __FILE__, 'aliprice_uninstall' );
	register_activation_hook( __FILE__, 'aliprice_activate' );

	if ( !defined('ALIPRICE_METHOD') ) define( 'ALIPRICE_METHOD', aliprice_request_method() );
    if ( !defined('ALIPRICE_CUR') ) define( 'ALIPRICE_CUR', aliprice_get_currency() );
    if ( !defined('ALIPRICE_LANG') ) define( 'ALIPRICE_LANG', aliprice_get_lang() );