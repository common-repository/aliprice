<?php
/**
*	Localization
*/
add_action('init', 'aliprice_lang_init');
function aliprice_lang_init() {

	load_plugin_textdomain( 'ae', false, dirname( plugin_basename( __FILE__ ) ) . '/../lang/' );
}

if( !function_exists('pr') ) {

	function pr( $any ) {

		print_r( "<pre>" );
		print_r( $any );
		print_r( "</pre>" );
	}
}

/**
*	XML Objects to Array
*/
function aliprice_xml2array ( $xmlObject, $out = array() ) {

	foreach ( (array) $xmlObject as $index => $node )
		$out[$index] = ( is_object ( $node ) ) ? aliprice_xml2array ( $node ) : $node;

	return $out;
}

/**
*	XML Objects to Array
*/
function aliprice_obj2array ( $obj, $out = array() ) {

	return aliprice_xml2array( $obj, $out );
}

/**
*	Array to Objects
*/
function aliprice_array2object( $array = array() ) {

	if ( empty( $array ) || !is_array( $array ) )
		return false;

	$data = new stdClass;

	foreach ( $array as $akey => $aval )
		$data->{$akey} = $aval;

	return $data;
}

/**
*	Parse any str to float
*/
function aliprice_floatvalue( $value ) {

	$value = preg_replace("/[^0-9,.]/", "", $value);
	$value = str_replace(',', '.', $value);
	return number_format( floatval($value), 2, '.', '' );
}

/**
*	Array to url
*/
function aliprice_array2url( $foo = false, $s = '&' ) {

	if( is_array( $foo ) ){

		$url = array();

		foreach ( $foo as $key => $str ) {
			$url[] .= $key . "=" . $str;
		}

		return implode( $s, $url );
	}
	else
		return "";
}

/**
*	Convert date to DB datetime
*/
function aliprice_dbdate( $value ) {
	return date( "Y-m-d H:i:s", strtotime( $value ) );
}

function aliprice_unserialize( $str ) {

    if( !$str )
        return false;

    try{
        $list = unserialize($str);
    }
    catch( Exception $e ) {
        return false;
    }

    return $list;
}

function aliprice_diff_date( $date1, $date2 ) {

    $diff = abs($date2 - $date1);
    $days = floor($diff/(60*60*24));

    return $days;
}

function aliprice_translate_any_str( $str, $to, $from = 'en' ) {
 
	include_once dirname(__FILE__) . '/../libs/translate/GoogleTranslate.php';

	$tr = new GoogleTranslate();

	$tr->setFromLang($from)->setToLang($to);

	$translated = $tr->translate($str);

	return ( $tr->isError() ) ? $str : $translated;
}

/**
*	Remove style attribute from HTML tags
*/
function aliprice_clean_html_style( $str, $array = false ) {

    $str = trim($str);

    if( empty($str) ) return '';

	$domd = new DOMDocument();
	libxml_use_internal_errors(true);
	$domd->loadHTML($str);
	libxml_use_internal_errors(false);

	$domx = new DOMXPath($domd);
	$items = $domx->query('//div[@style="max-width:650px;overflow:hidden;font-size:0;clear:both"]');

	foreach($items as $item) {
		$item->parentNode->removeChild($item);
	}

	$str = $domd->saveHTML();
	$str = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) class=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) width=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) height=".*?"/i', '$1', $str);
	$str = preg_replace('/(<[^>]+) alt=".*?"/i', '$1', $str);
	$str = preg_replace('/^<!DOCTYPE.+?>/', '$1', str_replace( array('<html>', '</html>', '<body>', '</body>'), '', $str));
	$str = preg_replace("/<\/?div[^>]*\>/i", "", $str);

	$str = preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $str);
	$str = preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', $str);
	$str = preg_replace("/<\/?h1[^>]*\>/i", "", $str);
	$str = preg_replace("/<\/?strong[^>]*\>/i", "", $str);
	$str = preg_replace("/<\/?span[^>]*\>/i", "", $str);

	$str = str_replace(' &nbsp; ', '', $str);
	$str = str_replace('&nbsp;', ' ', $str);

	$pattern = "/<[^\/>]*>([\s]?)*<\/[^>]*>/";
	$str = preg_replace($pattern, '', $str);

	$str = str_replace( array('<img', '<table'), array('<img class="img-responsive"', '<table class="table table-bordered'), $str);

	$str = force_balance_tags( $str );

	if( $array ) {

		$domd->preserveWhiteSpace = false;
		$images = $domd->getElementsByTagName('img');

		$foo = array();

		foreach ($images as $image) {

			$img = $image->getAttribute('src');
			$pos = strpos( $img, '?' );
			$img = $pos ? substr($img, 0, $pos) : $img;

			if( strrpos( $img, '.jpg' ) ){

				//$d = getimagesize($img);

				//if( $d[0] > 300 && $d[1] > 300 )
					$foo[] = $img;
			}
		}

		return array( 'content' => $str, 'images' => $foo );
	}

	return $str;
}

/**
*	Set TimeOut
*	$value - is seconds
*/
function aliprice_setTimeout( $value ) {

	$start_time = time();

	while(true) {
		if ( (time() - $start_time) > $value ) {
			return false;
		}
	}
}

/**
 * \n to <br> parser
 *
 * @param $content
 *
 * @return mixed|void
 */
function aliprice_nl2br_content( $content ) {
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	return $content;
}

/**
 * Set timer to supersale
 */
function aliprice_session_sale() {

    $now    = strtotime('now');

    $limit  = 16578;
    $define = 0;

    $timer = isset($_COOKIE['aliprice_supersale']) ? $now - intval($_COOKIE['aliprice_supersale']) : 0;

    if( $timer > 86400 || $timer == 0 ) {

        setcookie("aliprice_supersale", $now, time()+86400, "/");
        $define = $limit;
    }
    elseif( $timer < $limit ) {
        $define = $limit - $timer;
    }

    if ( !defined('ALIPRICE_SALE') ) define( 'ALIPRICE_SALE', $define );
}
add_action('init', 'aliprice_session_sale');

/**
 * Get timer to supersale
 * @return bool|string
 */
function aliprice_get_timer( $time = false ) {

    if( $time && $time > 0 ) {

        $now = strtotime('now');

        $diff = aliprice_diff_date($now, $time);

        if( $now < $time && $diff >= 1 )
            return array(
                'type' => 'day',
                'value' => $diff
            );
    }

    if ( defined('ALIPRICE_SALE') && ALIPRICE_SALE > 0 ) {
        return array(
            'type' => 'time',
            'value' => gmdate('H:i:s', ALIPRICE_SALE)
        );
    }

    return false;
}

add_filter('admin_footer_text', 'aliprice_footer_admin_queries');
function aliprice_footer_admin_queries(){
	echo get_num_queries().' queries in '.timer_stop(0).' seconds. ' . PHP_EOL;
}

/**
*	Get request method
*/
function aliprice_request_method( ) {

	$var = get_site_option('aliprice-method');

	return !empty( $var ) ? $var : 'file';
}

/**
*	add scripts and styles to forntend
*/
add_action('wp_enqueue_scripts', 'aliprice_load_outside');
function aliprice_load_outside( ) {

	wp_register_style( 'aliprice-plugin-style', plugins_url('/aliprice/css/style-outside.css'), "", '1.1' );

	wp_enqueue_style( 'aliprice-plugin-style' );
}

/**
*	add scripts and styles to admin
*/
//加入js文件，css文件
add_action('admin_print_scripts', 'aliprice_plugin_load_admin');
function aliprice_plugin_load_admin(){

	wp_register_script( 'ajaxQueue', plugins_url( '/aliprice/js/jquery.ajaxQueue.min.js' ), array( 'jquery' ), '0.1.2' );
	wp_register_script( 'textarea', plugins_url( '/aliprice/js/jquery.textarea.js' ), array( 'jquery' ), '0.1.2' );
	wp_register_script( 'bootstrap', plugins_url( '/aliprice/js/bootstrap.min.js' ), array( 'jquery' ), '3.0' );
	wp_register_script( 'pag', plugins_url( '/aliprice/js/pag.js' ), array( 'jquery' ), '1.6' );
	wp_register_script( 'range', plugins_url( '/aliprice/js/slider.range.js' ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse' ), '1.6' );
	wp_register_script( 'aliprice-script', plugins_url( '/aliprice/js/script.js' ), array( 'bootstrap', 'range', 'ajaxQueue', 'pag' ), '1.3' );
	wp_register_script( 'aliprice_review', plugins_url( '/aliprice/js/to-review.js' ), array( 'bootstrap', 'ajaxQueue', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'pag', 'textarea' ), '0.1.3' );

	wp_register_script( 'aliprice-percentageloader', plugins_url( '/aliprice/js/percentageloader.js' ), array( 'jquery'), '0.2' );
	wp_register_script( 'aliprice-review-import', plugins_url( '/aliprice/js/importReview.js' ), array( 'ajaxQueue', 'aliprice-percentageloader' ), '0.1.3' );
	wp_register_script( 'aliprice-loader-action', plugins_url( '/aliprice/js/jquery.LoaderAction.js' ), array( 'ajaxQueue', 'aliprice-percentageloader' ), '1.1' );
	wp_register_script( 'plupload-js', plugins_url( '/aliprice/libs/plupload/plupload.full.min.js' ), array('jquery'), '4.6.4' );

	wp_register_style( 'bootstrap', plugins_url('/aliprice/css/bootstrap.min.css'), "", '3.0' );
	wp_register_style( 'bootstrap-theme', plugins_url('/aliprice/css/bootstrap-theme.min.css'), array('bootstrap'), '3.0' );
	wp_register_style( 'font-awesome', plugins_url('/aliprice/css/font-awesome.min.css'), array(), '4.0' );
	wp_register_style( 'aliprice-style-admin', plugins_url('/aliprice/css/style-all-admin.css'), '', '1.3' );
	wp_register_style( 'aliprice-style-inside', plugins_url('/aliprice/css/style-inside.css'), '', '1.3' );

	wp_register_style( 'jquery-ui', plugins_url('/aliprice/css/jquery-ui.min.css'), '', '1.11.2' );
	wp_register_style( 'jquery-ui-theme', plugins_url('/aliprice/css/jquery-ui.theme.min.css'), array('jquery-ui'), '1.11.2' );
	wp_register_style( 'aliprice-style', plugins_url('/aliprice/css/style.css'), array('font-awesome', 'bootstrap-theme', 'jquery-ui-theme'), '1.5' );
	wp_register_style( 'aliprice-style-rtl', plugins_url('/aliprice/css/rtl.css'), array('font-awesome', 'bootstrap-theme', 'jquery-ui-theme'), '1.5' );

	wp_register_script( 'translateth', plugins_url( '/aliprice/js/translate-this.js' ), '', '1.0' );
	wp_register_script( 'aliprice_translate', plugins_url( '/aliprice/js/to-translate.js' ), array('ajaxQueue', 'translateth'), '0.1.2' );
	wp_register_script( 'custom-script', plugins_url( '/aliprice/js/custom.js' ), '', '1.0' );
	
	wp_enqueue_style( 'aliprice-style-admin' );
    if (is_rtl()){
        wp_enqueue_style( 'aliprice-style-rtl' );
    }

	$screen = get_current_screen();

	if( $screen->id == 'toplevel_page_aliprice' && isset($_GET['aepage']) && $_GET['aepage'] == 'review' ) {

        wp_enqueue_style( 'aliprice-style' );
        wp_enqueue_script( 'aliprice-review-import' );
        if (is_rtl()){
			wp_enqueue_style( 'aliprice-style-rtl' );
		}
    }
	elseif( isset($_GET['page']) && $_GET['page'] == 'customization' ) {

		wp_enqueue_script('custom-script');

	}
	elseif(isset($_GET['aepage']) && $_GET['aepage'] == 'updates' ) {

		wp_enqueue_style( 'aliprice-style' );
        wp_enqueue_script( 'aliprice-loader-action' );
        if (is_rtl()){
			wp_enqueue_style( 'aliprice-style-rtl' );
		}
	}
	elseif( $screen->id == 'toplevel_page_aliprice' ) {

		wp_enqueue_script( 'aliprice-script' );
		wp_enqueue_style( 'aliprice-style' );
        if (is_rtl()){
			wp_enqueue_style( 'aliprice-style-rtl' );
		}
	}
	elseif( $screen->id == 'toplevel_page_alimigrate' ) {

		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_style( 'aliprice-style' );
        if (is_rtl()){
			wp_enqueue_style( 'aliprice-style-rtl' );
		}
	}
	elseif( isset($screen->post_type) && $screen->post_type == 'post' ) {
		wp_enqueue_script( 'aliprice_review' );
		wp_enqueue_style( 'aliprice-style' );
		wp_enqueue_style( 'aliprice-style-inside' );
		if (is_rtl()){
			wp_enqueue_style( 'aliprice-style-rtl' );
		}
	}
	elseif( isset($screen->post_type) && $screen->post_type == 'products' ) {
		wp_enqueue_script( 'aliprice_translate' );
	}
	else{
		wp_enqueue_style( 'aliprice-style-inside' );
	}


}
add_action('admin_enqueue_scripts', 'chrome_fix');
function chrome_fix() {
	if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) !== false )
		wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' );
}
add_action('admin_head', 'aliprice_review_module');
function aliprice_review_module( ){

	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'post' ) return;

	add_action('media_buttons', 'aliprice_add_media_button', 15);
}

add_action('admin_head', 'aliprice_translate_module');
function aliprice_translate_module( ){

	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'products' ) return;

	add_action('media_buttons', 'aliprice_add_translate_button', 15);
}

/**
*	Add scripts and style for Review
*/
function aliprice_media_js_scripts() {

	wp_register_script( 'aliprice_review', plugins_url( '/aliprice/js/to-review.js' ), array( 'bootstrap', 'ajaxQueue', 'jquery-ui-core', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'pag', 'textarea' ), '0.1.4' );

	wp_enqueue_script( 'aliprice_review' );
	wp_enqueue_style( 'aliprice-style' );
	if (is_rtl()){
	    wp_enqueue_style( 'aliprice-style-rtl' );
	}
}

/**
*	Add new button for Review
*/
function aliprice_add_media_button( ) {

	echo '<a href="#" id="aliproduct" class="button"><img src="' . plugins_url( 'aliprice/img/logo.png') . '">' . __("AliPrice", 'aliprice') . '</a>';
}

/**
*	Add new button for Translate
*/
function aliprice_add_translate_button( ) {

	?>
		<div id="translate-this" style="display:inline-block">
			<a class="translate-this-button" href="http://www.translatecompany.com/translate-this/"  style="opacity:.25"><img src="<?php echo plugins_url( 'aliprice/img/translate.png') ?>"><?php _e("Translate", 'aliprice') ?></a>
		</div>
		<a class="button" id="alirestore" href="#"><img src="<?php echo plugins_url( 'aliprice/img/restore.png') ?>"><?php _e("Restore", "aliprice") ?></a>
		<div id="media-progress"><img src="<?php echo plugins_url( 'aliprice/img/ajax-loader.gif') ?>"></div>
		<div id="ali-translate-this-content" style="display:none">
			<div class="post_title"></div>
			<div class="post_content"></div>
		</div>
	<?php
}

/**
*	Add custom thumbnail size. Only for admin page.
*/
add_image_size( 'admin-thumb', 90, 90, true );

/**
*	List categories from AliExpress
*/
function aliprice_list_categories( ) {

	return array(
        array("ali_id" => '', "name" => __("All Categories", 'aliprice')),
        array("ali_id" => 3, "name" => __("Apparel & Accessories", 'aliprice'),
            "subcategories" => array(
                array("ali_id" => '200000343', "name" => __("Men's Clothing", 'aliprice')),
                array("ali_id" => '200000532', "name" => __("Novelty & Special Use", 'aliprice')),
                array("ali_id" => '200003274', "name" => __("Sportswears", 'aliprice')),
                array("ali_id" => '200000345', "name" => __("Women's Clothing", 'aliprice')),
            )
        ),
        array("ali_id" => 34, "name" => __("Automobiles & Motorcycles", 'aliprice'),
            "subcategories" => array(
                array("ali_id" => '200000212', "name" => __("Auto Replacement Parts", 'aliprice')),
                array("ali_id" => '200000285', "name" => __("Car Electronics", 'aliprice')),
                array("ali_id" => '200003427', "name" => __("Exterior Accessories", 'aliprice')),
                array("ali_id" => '200000242', "name" => __("Motorcycle Accessories & Parts", 'aliprice')),
                array("ali_id" => '3015', "name" => __("Roadway Safety", 'aliprice')),
            )
        ),
        array("ali_id" => 66, "name" => __("Beauty & Health", 'aliprice'),
            "subcategories" => array(
                array("ali_id" => '200001288', "name" => __("Bath & Shower", 'aliprice')),
                array("ali_id" => '200001221', "name" => __("Fragrances & Deodorants", 'aliprice')),
                array("ali_id" => '200001355', "name" => __("Health Care", 'aliprice')),
                array("ali_id" => '660103', "name" => __("Makeup", 'aliprice')),
                array("ali_id" => '3305', "name" => __("Oral Hygiene", 'aliprice')),
                array("ali_id" => '1513', "name" => __("Sanitary Paper", 'aliprice')),
                array("ali_id" => '660302', "name" => __("Shaving & Hair Removal", 'aliprice')),
                array("ali_id" => '3306', "name" => __("Skin Care", 'aliprice')),
                array("ali_id" => '200001976', "name" => __("Tattoo & Body Art", 'aliprice')),
            )
        ),
        array("ali_id" => 7, "name" => __("Computer & Office", 'aliprice'),
            "subcategories" => array(
                array("ali_id" => '200001074', "name" => __("External Storage", 'aliprice')),
                array("ali_id" => '200001083', "name" => __("Laptop Accessories", 'aliprice')),
                array("ali_id" => '200003782', "name" => __("Office Electronics", 'aliprice')),
                array("ali_id" => '200001085', "name" => __("Tablets & PDAs Accessories", 'aliprice')),
            )
        ),
		array("ali_id" => 44, "name" => __("Consumer Electronics", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '200003561', "name" => __("Electronic Cigarettes", 'aliprice')),
				array("ali_id" => '200003869', "name" => __("Portable HiFi", 'aliprice')),
				array("ali_id" => '200003803', "name" => __("Smart Electronics", 'aliprice')),
			)
		),
		array("ali_id" => 5, "name" => __("Electrical Equipment & Supplies", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '14190406', "name" => __("Connectors & Terminals", 'aliprice')),
				array("ali_id" => '141902', "name" => __("Generators", 'aliprice')),
				array("ali_id" => '141911', "name" => __("Power Supplies", 'aliprice')),
				array("ali_id" => '141904', "name" => __("Wires, Cables & Cable Assemblies", 'aliprice')),
				array("ali_id" => '14190403', "name" => __("Wiring Accessories", 'aliprice')),
			)
		),


        // Subcategories from empty category "Electronic Components & Supplies"
        array("ali_id" => '4001', "name" => __("Active Components", 'aliprice')),
        array("ali_id" => '4003', "name" => __("Electronic Accessories & Supplies", 'aliprice')),
        array("ali_id" => '4004', "name" => __("Optoelectronic Displays", 'aliprice')),
        array("ali_id" => '4005', "name" => __("Passive Components", 'aliprice')),
        // END Subcategories from empty category "Electronic Components & Supplies"

		array("ali_id" => 200005271, "name" => __("Electronics", 'aliprice')),
        array("ali_id" => 200214161, "name" => __("Fine & Fashion Jewelry", 'aliprice')),
        array("ali_id" => 2, "name" => __("Food", 'aliprice'),
			"subcategories" => array(
			)
		),
        array("ali_id" => 1503, "name" => __("Furniture", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '150301', "name" => __("Commercial Furniture", 'aliprice')),
				array("ali_id" => '3708', "name" => __("Furniture Parts", 'aliprice')),
				array("ali_id" => '150303', "name" => __("Home Furniture", 'aliprice')),
				array("ali_id" => '150302', "name" => __("Outdoor Furniture", 'aliprice')),
			)
		),
        array("ali_id" => 200003655, "name" => __("Hair & Accessories", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '200003656', "name" => __("Certified Human Hair", 'aliprice')),
			)
		),
        array("ali_id" => 42, "name" => __("Hardware", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '200001757', "name" => __("Adhesives & Sealers", 'aliprice')),
				array("ali_id" => '200001770', "name" => __("Door Hardware", 'aliprice')),
				array("ali_id" => '1459', "name" => __("Fasteners", 'aliprice')),
				array("ali_id" => '150306', "name" => __("Furniture Hardware", 'aliprice')),
				array("ali_id" => '153803', "name" => __("Windows Hardware", 'aliprice')),
			)
		),


        // Subcategories from empty category "Home & Garden"
        array("ali_id" => '125', "name" => __("Garden Supplies", 'aliprice')),
        array("ali_id" => '3710', "name" => __("Home Decor", 'aliprice')),
        array("ali_id" => '1541', "name" => __("Home Storage & Organization", 'aliprice')),
        array("ali_id" => '405', "name" => __("Home Textile", 'aliprice')),
        array("ali_id" => '200003767', "name" => __("House Ornamentation", 'aliprice')),
        // END Subcategories from empty category "Home & Garden"

        array("ali_id" => 6, "name" => __("Home Appliances", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '100000037', "name" => __("Air Conditioning Appliances", 'aliprice')),
				array("ali_id" => '100000038', "name" => __("Cleaning Appliances", 'aliprice')),
				array("ali_id" => '100000039', "name" => __("Home Appliance Parts", 'aliprice')),
				array("ali_id" => '100000040', "name" => __("Home Heaters", 'aliprice')),
				array("ali_id" => '100000041', "name" => __("Kitchen Appliances", 'aliprice')),
				array("ali_id" => '100000042', "name" => __("Laundry Appliances", 'aliprice')),
				array("ali_id" => '100000043', "name" => __("Water Heaters", 'aliprice')),
			)
		),
        // Category ali_id №13 not documented in ali api
        array("ali_id" => 13, "name" => __("Home Improvement", 'aliprice')),
        array("ali_id" => 200001996, "name" => __("Industry & Business", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '100005067', "name" => __("Printing Materials", 'aliprice')),
			)
		),

		array("ali_id" => '1509', "name" => __("Fashion Jewelry", 'aliprice')),
		array("ali_id" => 39, "name" => __("Lights & Lighting", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '1504', "name" => __("Indoor Lighting", 'aliprice')),
                array("ali_id" => '390501', "name" => __("LED Lighting", 'aliprice')),
                array("ali_id" => '530', "name" => __("Lighting Accessories", 'aliprice')),
                array("ali_id" => '150402', "name" => __("Lighting Bulbs & Tubes", 'aliprice')),
                array("ali_id" => '150401', "name" => __("Outdoor Lighting", 'aliprice')),
                array("ali_id" => '390503', "name" => __("Portable Lighting", 'aliprice')),
			)
		),
		array("ali_id" => 1524, "name" => __("Luggage & Bags", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '3806', "name" => __("Leisure Bags", 'aliprice')),
                array("ali_id" => '152404', "name" => __("Luggage & Travel Bags", 'aliprice')),
                array("ali_id" => '3803', "name" => __("Wallets & Holders", 'aliprice')),
			)
		),
		// Category ali_id №200060006 not documented in ali api
		array("ali_id" => 200060006, "name" => __("Market", 'aliprice')),
		array("ali_id" => 200214151, "name" => __("Men's Fashion", 'aliprice')),
		array("ali_id" => 1501, "name" => __("Mother & Kids", 'aliprice'),
			"subcategories" => array(
				array("ali_id" => '200000937', "name" => __("Baby Shoes", 'aliprice')),
				array("ali_id" => '200002038', "name" => __("Feeding", 'aliprice')),
				array("ali_id" => '200000500', "name" => __("Maternity", 'aliprice')),
				array("ali_id" => '200002006', "name" => __("Safety", 'aliprice')),
			)
		),
		array("ali_id" => 21, "name" => __("Office & School Supplies", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '211106', "name" => __("Desk Accessories & Organizer", 'aliprice')),
                array("ali_id" => '150304', "name" => __("Office Furniture", 'aliprice')),
                array("ali_id" => '211111', "name" => __("Painting Supplies", 'aliprice')),
                array("ali_id" => '2112', "name" => __("Paper", 'aliprice')),
                array("ali_id" => '212002', "name" => __("Presentation Boards", 'aliprice')),
			)
		),

		// Subcategories from empty category "Phones & Telecommunications"
		array("ali_id" => '100001204', "name" => __("Communication Equipment", 'aliprice')),
		array("ali_id" => '100001205', "name" => __("Mobile Phone Accessories & Parts", 'aliprice')),
		// END Subcategories from empty category "Phones & Telecommunications"

		array("ali_id" => 30, "name" => __("Security & Protection", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '3030', "name" => __("Access Control", 'aliprice')),
                array("ali_id" => '200004310', "name" => __("Door Intercom", 'aliprice')),
                array("ali_id" => '3009', "name" => __("Fire Protection", 'aliprice')),
                array("ali_id" => '200004311', "name" => __("Security Alarm", 'aliprice')),
                array("ali_id" => '3011', "name" => __("Video Surveillance", 'aliprice')),
                array("ali_id" => '3007', "name" => __("Workplace Safety Supplies", 'aliprice')),
			)
		),
		array("ali_id" => 322, "name" => __("Shoes", 'aliprice'),
			"subcategories" => array(
			)
		),
		array("ali_id" => 18, "name" => __("Sports & Entertainment", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '200003646', "name" => __("Baseball", 'aliprice')),
                array("ali_id" => '200003539', "name" => __("Cheerleading & Souvenirs", 'aliprice')),
                array("ali_id" => '200003500', "name" => __("Cycling", 'aliprice')),
                array("ali_id" => '200003538', "name" => __("Entertainment", 'aliprice')),
                array("ali_id" => '200000554', "name" => __("Hockey", 'aliprice')),
                array("ali_id" => '200004194', "name" => __("Other Sports & Entertainment Product", 'aliprice')),
                array("ali_id" => '200003540', "name" => __("Racquet Sports", 'aliprice')),
                array("ali_id" => '200003541', "name" => __("Roller, Skateboard & Scooters", 'aliprice')),
                array("ali_id" => '200003545', "name" => __("Rugby", 'aliprice')),
                array("ali_id" => '200003543', "name" => __("Skiing & Snowboarding", 'aliprice')),
			)
		),
		array("ali_id" => 1420, "name" => __("Tools", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '142016', "name" => __("Construction Tools", 'aliprice')),
                array("ali_id" => '142003', "name" => __("Hand Tools", 'aliprice')),
                array("ali_id" => '1537', "name" => __("Measurement & Analysis Instruments", 'aliprice')),
                array("ali_id" => '1417', "name" => __("Power Tools", 'aliprice')),
			)
		),
		array("ali_id" => 26, "name" => __("Toys & Hobbies", 'aliprice'),
			"subcategories" => array(
              array("ali_id" => '200001385', "name" => __("Remote Control", 'aliprice')),
			)
		),
		array("ali_id" => 200003498, "name" => __("Travel and Coupon Services", 'aliprice'),
			"subcategories" => array(
                array("ali_id" => '200003674', "name" => __("Ctrip", 'aliprice')),
                array("ali_id" => '200003510', "name" => __("Rentals", 'aliprice')),
                array("ali_id" => '200003501', "name" => __("Travel Discount Coupons", 'aliprice')),
			)
		),
		array("ali_id" => 1511, "name" => __("Watches", 'aliprice'),
			"subcategories" => array(
			)
		),

	);
}

/**
 * Search parent category name by ali id
 * @param $id
 * @return bool
 */
function aliprice_search_category_by_id( $id ){

	$foo = aliprice_list_categories();

	foreach( $foo as $key => $val ) {
		if( $val['ali_id'] == $id )
			return $val['name'];
	}

	return false;
}

add_action("init", "aliprice_move_page");
function aliprice_move_page( ) {

	$foo = array("dash", "conf", "bulk", "advanced", "scheduled");

	if( isset($_GET['page']) && isset($_GET['aepage']) &&
		$_GET['page'] == 'aliprice' && in_array($_GET['aepage'], $foo) ) {

			wp_redirect(admin_url( 'admin.php?page=aliprice' ));
	}
}

/**
*	Show categories in drop down list
*/
function aliprice_dropdown_categories( $name = 'alicategories', $class = "", $selected = "" ) {

	$categories = aliprice_list_categories();

	$output = '<select name="' . $name . '" id="' . $name . '" class="' . $class . '">';

	foreach( $categories as $category ) {

		$select = ( $category['ali_id'] == $selected ) ? 'selected="selected"' : '';

		$output .= '<option value="' . $category['ali_id'] . '" ' . $select . '>' . $category['name'] . '</option>';
	}

	$output .= '</select>';

	return $output;
}
/**
 *	List categories from AliExpress
 */
function get_subcategories_list_by_category_ali_id( $ali_id ) {

	$category_ali_id = (int) $ali_id;

	$categories = aliprice_list_categories( );

	foreach( $categories as $category_key => $category ) {
		if( $category['ali_id'] == $category_ali_id ) {
			if (array_key_exists('subcategories', $categories[$category_key]) && strlen($category['subcategories'][0] > 0)) {
				return $category['subcategories'];
			} else {
				return false;
			}
		}
	}

	return false;

}

/**
 *	Show SUB_categories in drop down list
 */
function aliprice_dropdown_subcategories($name = 'ali-sub-categories', $class = "", $selected = "") {

	$output = '<select name="'. $name .'" id="'. $name .'" class="' . $class . '">';

	$output .= '<option value="0" selected="selected"> ---- </option>';

	$output .= '</select>';

	return $output;
}

/**
*	return object array with details from product (AliExpress)
*/
function aliprice_product_detail( $post_id ) {

	$pub = new AliExpressPublish( );

	$result = $pub->getDetailsByPost( $post_id );

	return $result;
}

/**
*	Get option by params
*/
function aliprice_search_option( $name = '', $value = '' ) {

	if( $name == '' && $value == '' ) return false;

	global $wpdb;

	if( $name == '' )
		return $wpdb->get_var(
			$wpdb->prepare("SELECT `option_name` FROM `{$wpdb->options}` WHERE `option_value` = '%s'", $value)
		);

	elseif( $value == '' )
		return $wpdb->get_var(
			$wpdb->prepare("SELECT `option_value` FROM `{$wpdb->options}` WHERE `option_name` = '%s'", $name)
		);

	else {

		$name 	= esc_html( $name );
		$value 	= esc_html( $value );

		return $wpdb->get_var(
			"SELECT `option_name`
			FROM `{$wpdb->options}`
			WHERE `option_name` LIKE '{$name}%' AND
				`option_value` = '{$value}'"
		);
	}
}
/**
 *	Reser Views and Redirects by All Products
 */
function reset_counts( ) {

	global $wpdb;
	return $wpdb->query(
		$wpdb->prepare(
			"DELETE FROM $wpdb->postmeta
   WHERE meta_key = %s
   OR meta_key = %s",
			'views', 'redirects'
		)
	);

}

/**
*	Count Views by All Products
*/
function aliprice_total_count_views( ) {

	global $wpdb;

	$var = $wpdb->get_var(
		"SELECT SUM(`meta_value`) as `sum`
		FROM `{$wpdb->postmeta}`
		WHERE `meta_key` = 'views'"
	);

	return empty($var) ? 0 : $var;
}

/**
*	Count Redirects by All Products
*/
function aliprice_total_count_redirects( ) {

	global $wpdb;

	$var = $wpdb->get_var(
		"SELECT SUM(`meta_value`) as `sum`
		FROM `{$wpdb->postmeta}`
		WHERE `meta_key` = 'redirects'"
	);

	return empty($var) ? 0 : $var;
}

/**
*	Sort and show viewest products
*/
function aliprice_sort_total_admin( $per ) {

	$posts = get_posts(
		array(
			'post_type' 		=> 'products',
			'posts_per_page' 	=> $per,
			'meta_key'			=> 'views',
			'orderby'   		=> 'meta_value_num',
			'order'      		=> 'DESC'
		)
	);

	return $posts;
}

/**
*	Return the title for archive
*/
function aliprice_single_cat_title( ) {

	global $wp_query;

	if( is_post_type_archive( 'products' ) )
		_e('Products', 'aliprice');

	elseif( isset($wp_query->queried_object->name) )
		echo $wp_query->queried_object->name;
}

/**
*	Show category hierarchical
*/
function aliprice_the_catigories( $args = array(), $taxonomy = 'shopcategory', $class = "", $role = "tablist" ) {

	$defaults = array(
		'show_option_all'    => '',
		'orderby'            => 'name',
		'order'              => 'ASC',
		'style'              => 'list',
		'show_count'         => 0,
		'hide_empty'         => 1,
		'use_desc_for_title' => 1,
		'child_of'           => 0,
		'feed'               => '',
		'feed_type'          => '',
		'feed_image'         => '',
		'exclude'            => '',
		'exclude_tree'       => '',
		'include'            => '',
		'hierarchical'       => 1,
		'title_li'           => '',
		'show_option_none'   => __( 'No categories', 'aliprice' ),
		'number'             => null,
		'echo'               => 1,
		'depth'              => 0,
		'current_category'   => 0,
		'pad_counts'         => 0,
		'taxonomy'           => $taxonomy,
		'walker'             => null
	);

	$args = wp_parse_args( $args, $defaults );

	echo '<ul class="' . $class . '" role="' . $role . '">';

	wp_list_categories( $args );

	echo '</ul>';
}

/**
 * Get list of status to import Products
 *
 * @return array
 */
function ad_constant_status( ) {
	return array(
		'publish'   => __('Publish', 'aliprice'),
		'draft'     => __('Draft', 'aliprice')
	);
}

/**
*	When we delete product
*/
add_action( 'before_delete_post', 'aliprice_delete_product' );
function aliprice_delete_product( $post_id ) {

	global $post_type, $wpdb;

	if ( $post_type != 'products' ) return;

	$wpdb->delete( $wpdb->products, array( 'post_id' => $post_id ), array( '%d' ) );

	$wpdb->delete( $wpdb->review, array( 'post_id' => $post_id ), array( '%d' ) );

	$wpdb->delete( $wpdb->admitad, array( 'post_id' => $post_id ), array( '%d' ) );
}

/**
*	When we delete taxonomy
*/
add_action( 'delete_shopcategory', 'aliprice_delete_category', 3 );
function aliprice_delete_category( $term, $tt_id = '', $deleted_term = '' ) {

	$term_child  = aliprice_search_option( 'term_child-', $term );
	$term_parent = aliprice_search_option( 'term_parent-', $term );

	if( $term_parent )
		delete_site_option( $term_parent );

	if( $term_child )
		delete_site_option( $term_child );
}

/**
*	Handler to open product page
*/
add_action('wp', 'aliprice_count_views');
function aliprice_count_views( ) {

	if( !is_singular( 'products' ) ) return;

	global $post;

	$views = get_post_meta($post->ID, 'views', true);
	$views = empty($views) ? 1 : $views + 1;

	update_post_meta($post->ID, 'views', $views);
}

/**
* Handler to redirect by link to aliexpress
*/
add_action('wp', 'aliprice_redirect_aliexpress');
function aliprice_redirect_aliexpress() {

	if( !isset($_POST['ali-item-direct']) ) return;

	if( !filter_var($_POST['ali-item-direct'], FILTER_VALIDATE_URL) ) return;

	wp_redirect($_POST['ali-item-direct']);
	exit;
}

/**
*	Handler to click Buy now
*/
add_action('aliprice_click_buy', 'aliprice_click_buy_now');
function aliprice_click_buy_now( ) {

	if( !isset($_POST['aliprice_submit']) ) return;

	if( !isset($_POST['product_id']) || $_POST['product_id'] == '' ) return;

	$post_id = intval( $_POST['product_id'] );

    $program = get_site_option( 'aliprice-program' );

	$url = '';

    $info = new AEProducts();
    $info->set( $post_id );

    $url = $info->getLink();

	if( !filter_var($url, FILTER_VALIDATE_URL) ) return;

	$redirects = get_post_meta($post_id, 'redirects', true);
	$redirects = empty($redirects) ? 1 : $redirects + 1;

	update_post_meta($post_id, 'redirects', $redirects);

	wp_redirect( $url );
	exit;
}
//更新地址
function aliprice_updparam(){
	return array( 'api_url' => 'http://www.aliprice.com/?plugins_upd', 'plugin_slug' => 'aliprice' );
}

/**
*	Take over the update check
*/
add_filter('pre_set_site_transient_update_plugins', 'aliprice_check_plugin_update');
function aliprice_check_plugin_update( $checked_data ) {

	global $wp_version;

	$foo 			= aliprice_updparam();
	$api_url 		= $foo['api_url'];
	$plugin_slug 	= $foo['plugin_slug'];

	//Comment out these two lines during testing.
	if ( empty($checked_data->checked) )
		return $checked_data;

	$args = array(
		'slug' 		=> $plugin_slug,
		'version' 	=> $checked_data->checked[$plugin_slug .'/'. $plugin_slug .'.php'],
		'site' 		=> get_bloginfo( 'url' )
	);

	$request_string = array(

		'body' => array(
			'action' 	=> 'basic_check',
			'request' 	=> serialize( $args ),
			'api-key' 	=> md5( get_bloginfo('url') )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	// Start checking for an update
	$raw_response = wp_remote_post( $api_url, $request_string );

	if ( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) ){
		//pr($raw_response);
		$response = unserialize($raw_response['body']);
	}

	if ( isset($response) && is_object($response) && !empty($response) )
		$checked_data->response[$plugin_slug .'/'. $plugin_slug .'.php'] = $response;

	return $checked_data;
}

/**
*	Take over the Plugin info screen
*/
add_filter('plugins_api', 'aliprice_plugin_api_call', 10, 3);
function aliprice_plugin_api_call( $def, $action, $args ) {

	global $wp_version;

	$foo 			= aliprice_updparam();
	$api_url 		= $foo['api_url'];
	$plugin_slug 	= $foo['plugin_slug'];

	if ( !isset($args->slug) || ($args->slug != $plugin_slug) ) return false;

	// Get the current version
	$plugin_info 		= get_site_transient('update_plugins');
	$current_version 	= $plugin_info->checked[$plugin_slug .'/'. $plugin_slug .'.php'];
	$args->version 		= $current_version;
	$args->site 		= get_bloginfo( 'url' );

	$request_string = array(
		'body' => array(
			'action' 	=> $action,
			'request' 	=> serialize( $args ),
			'api-key' 	=> md5( get_bloginfo('url') )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
	);

	$request = wp_remote_post( $api_url, $request_string );

	if ( is_wp_error($request) ) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 'aliprice'), $request->get_error_message());

	}
	else {

		$res = unserialize($request['body']);

		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred', 'aliprice'), $request['body']);
	}

	return $res;
}


/**
*	Converter currency gy google
*/
function aliprice_convertCurrency( $amount = 1, $from = 'USD', $to ) {

	$url  = "https://www.google.com/finance/converter?a=" . $amount . "&from=" . $from . "&to=" . $to;

	$obj = new AliExpressJSONAPI2();
	$data = $obj->request_data($url);

	if( $data === false )
		return false;

	preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);

	$converted = preg_replace("/[^0-9.]/", "", $converted[1]);

	$converted = round($converted, 2);

	return $converted;
}

/**
*	Currency Codes
*/
function aliprice_currency_codes( ) {

	$too = array(
		'AUD' => __('Australian Dollar (A$)', 'aliprice'),
		'BRL' => __('Brazilian Real (R$)', 'aliprice'),
		'BGN' => __('Bulgarian lev (BGN)', 'aliprice'),
		'CAD' => __('Canadian Dollar (CA$)', 'aliprice'),
		'CHF' => __('Swiss Franc (CHF)', 'aliprice'),
		'CNY' => __('Chinese Yuan (CN¥)', 'aliprice'),
		'CZK' => __('Czech Republic Koruna (CZK)', 'aliprice'),
		'EUR' => __('Euro (€)', 'aliprice'),
		'IDR' => __('Indonesian rupiah (Rp)', 'aliprice'),
		'ILS' => __('Israeli New Sheqel (₪)', 'aliprice'),
		'INR' => __('Indian Rupee (₹)', 'aliprice'),
		'GBP' => __('British Pound Sterling (£)', 'aliprice'),
		'KZT' => __('Kazakhstani tenge (&#8376;)', 'aliprice'),
		'JPY' => __('Japanese yen (¥)', 'aliprice'),
		'NGN' => __('Nigerian naira (₦)', 'aliprice'),
		'NZD' => __('New Zealand dollar (NZ$)', 'aliprice'),
		'NOK' => __('Norwegian Krone (NOK)', 'aliprice'),
		'MYR' => __('Malaysian Ringgit (MYR)', 'aliprice'),
		'PKR' => __('Pakistan Rupee (PKR)', 'aliprice'),
		'MXN' => __('Peso mexicano (MXN)', 'aliprice'),
		'PHP' => __('Philippine peso (₱)', 'aliprice'),
		'PLN' => __('Polish Zloty (PLN)', 'aliprice'),
		'RUB' => __('Russian Ruble (RUB)', 'aliprice'),
		'SAR' => __('Saudi Riyal (SAR)', 'aliprice'),
		'SEK' => __('Swedish Krona (SEK)', 'aliprice'),
		'THB' => __('Thailand Baht (THB)', 'aliprice'),
		'TWD' => __('New Taiwan Dollar(NT$)', 'aliprice'),
		'KRW' => __('South Korean Won (₩)', 'aliprice'),
		'AED' => __('United Arab Emirates Dirham (AED)', 'aliprice'),
		'USD' => __('US Dollar ($)', 'aliprice'),
		'UAH' => __('Ukrainian hryvnia (₴)', 'aliprice'),
		'ZAR' => __('South African Rand (ZAR)', 'aliprice'),
	);

	asort($too);

	return $too;
}

/**
*	Get current currency value
*/
function aliprice_get_currency( ) {

	$args = get_site_option('aliprice-currency');
	$args = ( !$args ) ? false : unserialize($args);

	if(
		!isset($args['currency']) || !isset($args['value']) || !isset($args['enabled']) ||
		empty($args['currency']) || empty($args['value']) || $args['enabled'] == 0
	) return false;

	$currency 	= $args['currency'];
	$round		= empty($args['round']) ? 0 : $args['round'];
	$foo = aliprice_currency_codes();

	if( !isset($foo[$currency]) )
		return false;

	if ( !defined('ALIPRICE_CV') ) define( 'ALIPRICE_CV', $args['value'] );
	if ( !defined('ALIPRICE_RD') ) define( 'ALIPRICE_RD', $round );

	return $currency;
}

/**
* Get currency symbol
*/
function aliprice_get_currency_symbol( $cur ) {

	$foo = array(
		'AED' => array( 'symbol' => 'AED', 'pos' => 'before' ),
		'AUD' => array( 'symbol' => 'A$', 'pos' => 'before' ),
		'BGN' => array( 'symbol' => 'BGN', 'pos' =>'after'),
		'BRL' => array( 'symbol' => 'R$', 'pos' => 'before' ),
		'CAD' => array( 'symbol' => 'CA$', 'pos' => 'before' ),
		'CHF' => array( 'symbol' => 'CHF', 'pos' => 'after' ),
		'CNY' => array( 'symbol' => '¥', 'pos' => 'after' ),
		'CZK' => array( 'symbol' => 'Kč', 'pos' => 'after' ),
		'EUR' => array( 'symbol' => '€', 'pos' => 'after' ),
		'MXN' => array( 'symbol' => 'MXN', 'pos' => 'after' ),
		'IDR' => array( 'symbol' => 'Rp', 'pos' => 'after' ),
		'ILS' => array( 'symbol' => '₪', 'pos' => 'after' ),
		'INR' => array( 'symbol' => '₹', 'pos' => 'after' ),
		'JPY' => array( 'symbol' => '¥', 'pos' => 'before' ),
		'GBP' => array( 'symbol' => '£', 'pos' => 'before' ),
		'KZT' => array( 'symbol' => '&#8376;', 'pos' => 'before' ),
		'NGN' => array( 'symbol' => '₦', 'pos' => 'after' ),
		'NZD' => array( 'symbol' => 'NZ$', 'pos' => 'after' ),
		'NOK' => array( 'symbol' => 'kr', 'pos' => 'after' ),
		'MYR' => array( 'symbol' => 'RM', 'pos' => 'before' ),
		'PKR' => array( 'symbol' => '₨', 'pos' => 'before' ),
		'PHP' => array( 'symbol' => '₱', 'pos' => 'before' ),
		'PLN' => array( 'symbol' => 'zl', 'pos' => 'after' ),
		'RUB' => array( 'symbol' => 'руб.', 'pos' => 'after' ),
		'SAR' => array( 'symbol' => 'SR', 'pos' => 'after' ),
		'SEK' => array( 'symbol' => 'SEK', 'pos' => 'after' ),
		'THB' => array( 'symbol' => '฿', 'pos' => 'after' ),
		'TWD' => array( 'symbol' => 'NT$', 'pos' => 'after' ),
		'KRW' => array( 'symbol' => '₩', 'pos' => 'before' ),
		'USD' => array( 'symbol' => '$', 'pos' => 'before' ),
		'UAH' => array( 'symbol' => '₴', 'pos' => 'before' ),
		'ZAR' => array( 'symbol' => 'R', 'pos' => 'before' ),
	);

	if( isset($foo[$cur]) ) return $foo[$cur];

	return $cur;
}

/**
*	Convert currency
*/
function aliprice_get_price( $price, $output = true ) {

	if( !ALIPRICE_CUR ) return $price;

	$foo = aliprice_get_currency_symbol( ALIPRICE_CUR );

	if( !is_array($foo) ) return $price;

	$price = preg_replace("/[^0-9,.]/", "", $price);
	$price	= aliprice_floatvalue($price);

	$to = (ALIPRICE_RD == 1) ? 0 : 2;

	$price	= round( $price*ALIPRICE_CV, $to );
	$price	= aliprice_floatvalue($price);

	if( $output )
		return ( $foo['pos'] == 'before' ) ?
			$foo['symbol'] . " " . $price :
			$price . ' ' . $foo['symbol'];

	return $price;
}

/**
*	Default price
*/
function aliprice_get_default_price( $price, $symbol = true ) {

	if( !ALIPRICE_CUR ) return $price;

	$foo = aliprice_get_currency_symbol( ALIPRICE_CUR );

	if( !is_array($foo) ) return $price;

	$price 	= preg_replace("/[^0-9,.]/", "", $price);
	$price 	= aliprice_floatvalue($price);

	$to 	= (ALIPRICE_RD == 1) ? 0 : 2;

	$price	= round( $price/ALIPRICE_CV, $to );

	if( $symbol )
		return ( $foo['pos'] == 'before' ) ?
			$foo['symbol'] . " " . $price :
			$price . ' ' . $foo['symbol'];
	else
		return $price;
}

/**
*	Set max price
*/
function aliprice_set_max_price( ) {
	global $wpdb;

	$var = $wpdb->get_var("SELECT MAX( CAST( SUBSTRING_INDEX(`price`, '$', -1) AS DECIMAL(10, 2) ) ) FROM `{$wpdb->prefix}aliprice_products`");

	if( !empty($var) )
		update_site_option( 'aliprice-max-price', $var );
}

/**
 * List languages
 * @return bool
 */
function aliprice_list_lang() {

	return array(
		'en' => __('English', 'aliprice'),
		'ar' => __('Arabic', 'aliprice'),
		'de' => __('German', 'aliprice'),
		'es' => __('Spanish', 'aliprice'),
		'fr' => __('French', 'aliprice'),
		'it' => __('Italian', 'aliprice'),
		'id' => __('Bahasa Indonesia', 'aliprice'),
		'ja' => __('Japanese', 'aliprice'),
		'ko' => __('Korean', 'aliprice'),
		'nl' => __('Dutch', 'aliprice'),
		'pt' => __('Portuguese (Brasil)', 'aliprice'),
		'pl' => __('Polish', 'aliprice'),
		'ru' => __('Russian', 'aliprice'),
		'th' => __('Thai', 'aliprice'),
		'tr' => __('Turkish', 'aliprice'),
		'vi' => __('Vietnamese', 'aliprice'),
		'he' => __('Hebrew', 'aliprice')		
	);
}

/**
 * Get current language
 * @return bool|mixed|string
 */
function aliprice_get_lang( ) {

	$foo = aliprice_list_lang();

	$lang = get_site_option('aliprice-language');
	$lang = ( $lang  && isset($foo[$lang]) ) ? $lang : 'en';

	if( $lang == 'en' ) return 'en';

	return $lang;
}

/**
 * Get picture by post or page
 * @param $post_id
 * @param string $size
 * @return mixed
 */
function aliprice_get_thumb( $post_id, $size = 'thumbnail' ) {

	if( !has_post_thumbnail($post_id) ) {

		$args = array(
			'post_type' => 'attachment',
			'numberposts' => 1,
			'post_status' => null,
			'post_parent' => $post_id
		);

		$attachments = get_posts( $args );

		if ( $attachments ) {

			$img = wp_get_attachment_image_src( $attachments[0]->ID, $size, false );

			return $img[0];
		}
	}
	else {
		$thumb_id = get_post_thumbnail_id( $post_id );
		$url = wp_get_attachment_image_src( $thumb_id, $size );

		return $url[0];
	}
}

/**
 * @param $text
 * @return mixed|string|void
 */
function aliprice_get_post_excerpt( $text ) {

	$text = strip_shortcodes( $text );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace( ']]>', ']]>', $text );

	$excerpt_length = apply_filters( 'excerpt_length', 55 );
	$text           = wp_trim_words( $text, $excerpt_length, ' ...' );
	return $text;
}

/**
 * Get image from product
 * @param $original
 * @param string $size
 * @return bool|string
 * @todo допилить проверку на наличие у записи миниатюры, если нет, юрать ту что у али
 */
function aliprice_get_thumb_ali( $original, $size = '') {

	if( $original == '' )
		return false;

	return aliprice_get_size_img( $original, $size );
}

/**
 * List Image Size
 * @param $url
 * @param string $size
 * @return string
 */
function aliprice_get_size_img( $url, $size = 'medium' ) {

	$foo = array(
		'thumb' 	=> '_50x50.jpg',
		'medium' 	=> '_220x220.jpg',
		'large' 	=> '_350x350.jpg'
	);

	if( !isset( $foo[$size] ) ) return $url;

	return $url . $foo[$size];
}



/**
 * Count Products by All Products
 * @return int
 */
function aliprice_total_count_products( ) {

	global $wpdb;

	$var = $wpdb->get_var( "SELECT count(`id`) as `con` FROM `{$wpdb->products}` WHERE `post_id` <> 0" );

	return empty($var) ? 0 : $var;
}

/**
 * Count Reviews by All Products
 * @return int
 */
function aliprice_total_count_reviews( ) {

	global $wpdb;

	$var = $wpdb->get_var( "SELECT sum(`countReview`) as `con` FROM `{$wpdb->products}`" );

	return empty($var) ? 0 : $var;
}
/**
 * Get list Reviews by ID
 *
 * @param $post_id
 * @return bool|mixed
 */
function aliprice_Review( $post_id ) {

    require_once( dirname(__FILE__) . '/class.AliExpress.Review.php' );


    $obj = new Review();

    return $obj->listReviews( $post_id );
}
/**
 * Get reviews star
 *
 * @param $post_id
 * @return bool|mixed
 */
function aliprice_getStat( $arrayOfObjs ) {

    $stat = array(
        'positive' => 0,
        'neutral' => 0,
        'negative' => 0,
        'stars' => array(
            '1' => array('count' => 0, 'percent' => 0 ),
            '2' => array('count' => 0, 'percent' => 0 ),
            '3' => array('count' => 0, 'percent' => 0 ),
            '4' => array('count' => 0, 'percent' => 0 ),
            '5' => array('count' => 0, 'percent' => 0 ),
            )
    );

    if( !$arrayOfObjs || empty($arrayOfObjs) )
        return $stat;

    $count = 0;
    foreach( $arrayOfObjs as $review ){
        if((int)$review->star > 0){
            $stat['stars'][(int)$review->star]['count']++;
            $count++;
        }

    }

    foreach($stat['stars'] as $key => $value)
        $stat['stars'][$key]['percent'] =  round( $value['count'] / $count * 100, 1);

    $stat['positive'] = round( ($stat['stars'][4]['percent'] + $stat['stars'][5]['percent']), 1);
    $stat['neutral'] = round( ($stat['stars'][3]['percent']), 1);
    $stat['negative'] = round( ($stat['stars'][1]['percent'] + $stat['stars'][2]['percent']), 1);

    return $stat;
}
	
function aliprice_averageStar( $arrayOfObjs ) {

    if( !$arrayOfObjs || empty($arrayOfObjs) )
        return array(0,0);

    $star = array();
    $count= 0;

    foreach( $arrayOfObjs as $review ){
        if($review->star > 0){
            $star[]= $review->star;
            $count++;
            }
    }

    $average = round( array_sum($star)/$count , 1);

    return array($average, $count);
}

function aliprice_renderStarRating( $rating ) {

    $full_stars = floor( $rating );
    $half_stars = ceil( $rating - $full_stars );
    $empty_stars = 5 - $full_stars - $half_stars;

    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star"></span>', $full_stars );
    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star"></span>', $half_stars );
    echo str_repeat( '<span class="b-social-icon dib b-social-icon-star-empty"></span>', $empty_stars);
}
/*
Sheduled Review 
*/
function aliprice_schedule_review( $pos, $count, $count_settings, $star) {

    global $wpdb;

    $results = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM `{$wpdb->products}` WHERE `post_id` <> 0 LIMIT %d, %d", $pos, $count)
    );

	if( !$results ) {
        return false;
    }

	require_once( dirname( __FILE__ ) . '/class.AliExpress.Review.php' );
	include_once __DIR__ . '/../libs/translate/GoogleTranslate.php';
	require_once( dirname( __FILE__ ) . '/request.php' );

	foreach( $results as $row ) {

		aliprice_set_review_by_product( $row, $count_settings, $star );
	}
}

function aliprice_set_review_by_product( $row, $count_settings, $star ) {

	global $wpdb;

	$translate = new GoogleTranslate();
	$translate->setFromLang('')->setToLang(ALIPRICE_LANG);

	$obj = new Review($row->productId);
	$obj->setNewParams();
	$obj->setPage(1);
	$data = $obj->getReviews();

	if( !$data ) {

		return false;
	}

	foreach( $data as $key => $val ) {

		if( !aliprice_check_exists_review( $row->post_id, $val ) && $val['star'] >= $star ) {

			$feedback = !empty($val['feedback']) ? $translate->translate($val['feedback']) : '';

			$wpdb->insert(
				$wpdb->review,
				array(
					'post_id'   => $row->post_id,
					'name'      => $val['name'],
					'feedback'  => $feedback,
					'date'      => $val['date'],
					'flag'      => $val['flag'],
					'star'      => $val['star']
				),
				array(
					'%d', '%s', '%s', '%s', '%s', '%f'
				)
			);
		}
		$result = $wpdb->get_results($wpdb->prepare("SELECT count(`id`) as `con` FROM `{$wpdb->review}` WHERE `post_id`=%d", $row->post_id));
		$result = current($result);
		$current_count = $result->con;
		if( $current_count > $count_settings){
			$count_settings_corrective = $current_count - $count_settings;
			$wpdb->get_results($wpdb->prepare("DELETE FROM `{$wpdb->review}` WHERE `post_id`=%d ORDER BY `id` ASC LIMIT %d", $row->post_id, $count_settings_corrective));
		}
	}
}
/**
 * Validate is URL
 * @param $url
 * @return int
 */
function aliprice_is_url($url) {
    return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

