<?php

class AL3Options
{
	protected $field_options = 'AL3_options';
	protected $data          = array();

	public function __construct()
	{
		$theme               = wp_get_theme();
		$this->field_options = 'AL3';

		//@TODO save stripslashes
		$this->data = get_site_option( $this->field_options );
		$options    = $this->get_defaults();
		$this->data = wp_parse_args( $this->data, $options );
	}

	//@TODO save stripslashes
	public function __get( $name )
	{

		if ( array_key_exists( $name, $this->data ) ) {
			return stripslashes( $this->data[ $name ] );
		} else {
			throw new \Exception( 'Getting unknown property:' . $name );
		}

		return null;
	}

//@TODO save stripslashes
	public function data()
	{
		$data = $this->data;
		foreach ( $data as $k => $v )
			$data[ $k ] = stripslashes( $v );

		return $data;
	}

	public function get_defaults()
	{
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
		$defaults = array(
            'ssdma_analytics_tid'=>'',
            'ssdma_colors_links'=>'#ec555c',
            'ssdma_colors_links_hover'=>'#DA4249',
            'ssdma_colors_memu'=>'#FFA22E',
            'ssdma_colors_memu_hover'=>'#FF8F00',
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
            'ssdma_htext_line'=>'Order anytime and always receive <b>FAST, FREE Shipping</b> on all orders!',
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
            'ssdma_colors_htb_h'=>'',
            'ssdma_colors_htb'=>'',
            'ssdma_colors_h_line'=>'',
			
		);

		return apply_filters( 'cz_fields', $defaults );

	}

	private function ImgSrc( $img )
	{
		return get_stylesheet_directory_uri() . '/img/' . $img;
	}
}

if ( is_admin() ) {
	require( dirname( __FILE__ ) . '/customization/menu.php' );
	require( dirname( __FILE__ ) . '/customization/class.CZ.AdminTpl.php' );
	require( dirname( __FILE__ ) . '/customization/class.CZ.Settings.php' );
	require( dirname( __FILE__ ) . '/customization/core.php' );
}


add_action( 'init', 'init_cz' );
function init_cz()
{
	global $cz_data;
	$cz      = new AL3Options();
	$cz_data = $cz->data();
}


if ( !function_exists( 'cz' ) ) {
	function cz( $name )
	{
		global $cz_data;

		return isset( $cz_data[ $name ] ) ? $cz_data[ $name ] : '';
	}
}

/*
 * add new fields
 * */
/*
add_filter('cz_fields', 'cz_fields_test');
function cz_fields_test($fields){
	$fields['cz_test'] = 'test';
	return $fields;
}
add_filter('cz_list_menu', 'test_cz_menu');

function test_cz_menu($v){
	$v['czsubcribe']    = array(
		'tmp'         => 'cz_test_menu',
		'title'       => __( 'Test', 'ali5' ),
		'description' => __( 'Test settings', 'ali5' ),
		'icon'        => 'home',
		'submenu'     => array()
	);
	return $v;
}

function cz_test_menu(){
	$cz = new czSettings();
	?>
		$cz->block( array(
			$cz->row( array(
				$this->textField( 'tp_img_product_cat1_url', array(
					'label'  => __( 'Category URL', 'ali5' ),
					'screen' => S_URL_LIB . 'img/logo.jpg'

				) ),
				$cz->textField( 'tp_img_product_cat1_title', array(
					'label'  => __( 'Sticker text', 'ali5' ),
					'screen' => ''
				) )
			) ),
				$cz->row( array(
					$cz->textField( 'tp_img_product_cat1_url', array(
						'label'  => __( 'Category URL', 'ali5' ),
						'screen' => S_URL_LIB . 'img/logo.jpg'

					) ),
					$cz->textField( 'tp_img_product_cat1_title', array(
						'label'  => __( 'Sticker text', 'ali5' ),
						'screen' => ''
					) )
				) )
			)
		);
	<?php
}
*/
