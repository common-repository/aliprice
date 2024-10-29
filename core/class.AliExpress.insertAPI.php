<?php

class AliExpressInsert extends AliExpressJSONAPI2{
        
	private $db			= "";
	private $products 	= "";
	
	/**
	* Access Key Id. When you create the App, the AliExpress open platform will generate an appKey and a secretKey.
	* @access private
	* @var string
	*/
	private $AppKey	= "";
   
	/**
	* Api Parameter. Different APIs have different parameters. You need to fill in the parameters when requesting a connector.
	* You Tracking ID
	* @access private
	* @var string
	*/
	private $trackingId = "";

	private $partner_username = "";
	private $partner_password = "";

	private $frees      = false;
	private $unitType   = '';

	function AliExpressInsert( ) {
		
		global $wpdb;
		
		$this->db = $wpdb;
		$this->products = $this->db->prefix . 'aliprice_products';
		
		$this->AppKey 		= get_site_option('aliprice-app-key');
		$this->trackingId 	= get_site_option('aliprice-tracking');
		$this->partner_username = get_site_option('aliprice-partner_username');
		$this->partner_password = get_site_option('aliprice-partner_password');
		$this->appSignature = get_site_option('aliprice-appsignature');
		
		parent::AliExpressJSONAPI2($this->AppKey, $this->trackingId, $this->partner_username, $this->partner_password, $this->appSignature );
	}

	public function set_frees( $free = false ){
		$this->frees = $free;
	}

	public function set_unit_type( $unitType = '' ) {
		$this->unitType = $unitType;
	}

	//get total products by category
	//查找分类总商品
	public function getTotalByCategory( $category_id, $args ) {
		
		if( !$this->check_keys() ) 
			return array( 'error' => __("API Keys not found", 'aliprice') );
		if( !$this->check_username() )
			return array( 'error' => __("AliPrice Username not found", 'aliprice') );

		try {
			$result = $this->getAllProductsByCat( $category_id, 1, $args );
		}
		catch( Exception $e ) {
			$result = $e->getMessage();
			return array( 'error' => $result );
		}
		
		if(  is_array($result) && isset($result['notfound']) )
			return array( 'error' => $result['notfound'] );
		
		return array( 'result' => $result->totalResults );
	}
	
	//scan category by ID and Import goods
	public function scanCategory( $category_id, $page_no = 1, $args ) {
		
		if( !$this->check_keys() ) 
			return array( 'error' => __("API Keys not found", 'aliprice') );
		if( !$this->check_username() )
			return array( 'error' => __("AliPrice Username not found", 'aliprice') );
		
		try {
			$result = $this->getAllProductsByCat( $category_id, $page_no, $args );
		}
		catch( Exception $e ) {
			$result = $e->getMessage();
			return array( 'error' => $result );
		}

		$foo = array();

		foreach( $result->products as $args )
			$foo[] = $this->insertProduct( $category_id, $args );
		return $foo;
	}
	
	//only scan by category ID
	public function searchByCategory( $category_id, $page_no = 1, $args, $per_page = 20 ) {
		
		if( !$this->check_keys() ) 
			return array( 'error' => __("API Keys not found", 'aliprice') );
		if( !$this->check_username() )
			return array( 'error' => __("AliPrice Username not found", 'aliprice') );
		try {
			if( isset($args['sort']) && empty($args['sort']) )
				unset($args['sort']);

			$result = $this->getAllProductsByCat( $category_id, $page_no, $args, $per_page );
		}
		catch( Exception $e ) {
			$result = $e->getMessage();
			return array( 'error' => $result );
		}
		
		if( is_array($result) && isset($result['notfound']) )
			return array( 'error' => $result['notfound'] );
			
		
		return array( 'result' => $result );
	}

	//search products by IDs
	public function searchByProductIDs( $ids ) {

		if( !$this->check_keys() ) 
			return array( 'error' => __("API Keys not found", 'aliprice') );
		if( !$this->check_username() )
			return array( 'error' => __("AliPrice Username not found", 'aliprice') );

		try {
			$result = $this->getAllProductsByIds( $ids );
		}
		catch( Exception $e ) {
			$result = $e->getMessage();
			return array( 'error' => $result );
		}

		if( is_array($result) && isset($result['notfound']) )
			return array( 'error' => $result['notfound'] );


		return array( 'result' => $result );
	}
	
	//update products details
	public function updateProductsDetails( $from, $to = 20 ) {
	
		$result = $this->db->get_results( $this->db->prepare("SELECT `productId` FROM `{$this->products}` LIMIT %d, %d", $from, $to) );
		
		if( !$result ) return false;
		
		$foo = array();
		
		foreach( $result as $res ) {

			$foo[] = $this->getDetailById($res->productId);
		}
		
		return $foo;
	}

	//update products details
	public function updateProductsDetailsMini( $from, $to = 50 ) {

		$result = $this->db->get_results(
			$this->db->prepare("SELECT `productId`, `post_id` FROM `{$this->products}` WHERE `post_id` <> 0 LIMIT %d, %d",
				$from, $to
			)
		);

		if( !$result ) return false;

		$foo = array();

		foreach( $result as $res ) {

			$foo[] = $this->getMiniDetail($res->productId, $res->post_id);
		}

		return $foo;
	}
	
	// insert product, update detail, create category, published product
	public function insertOneItem( $category_id, $args = array() ) {
	
		$args = aliprice_obj2array($args);
		
		$args['categoryAE'] = $category_id;
		$args['owncat'] = ( isset($args['owncat']) && !empty($args['owncat']) ) ? 1 : 0;
		
		$id = $this->db->get_var( $this->db->prepare("SELECT `id` FROM `{$this->products}` WHERE `productId` = '%s'", $args['productId']) );
		
		if( empty($id) ) {
			
			$this->db->insert( $this->products, $args );
			
			$id = $this->db->insert_id;;
		}
		else {
			unset($args['keywords'], $args['summary']);

			$this->db->update( $this->products, $args, array( 'id' => $id ) );
		}
		
		return $id;
	}

	// insert product, update detail, create category, published product
	public function insertOneItemIds( $args = array() ) {

		$args = aliprice_obj2array($args);

		$args['owncat'] = ( isset($args['owncat']) && !empty($args['owncat']) ) ? 1 : 0;

		$id = $this->db->get_var( $this->db->prepare("SELECT `id` FROM `{$this->products}` WHERE `productId` = '%s'", $args['productId']) );

		if( empty($id) ) {

			$this->db->insert( $this->products, $args );

			$id = $this->db->insert_id;;
		}
		else {
			unset($args['keywords'], $args['summary']);
			$this->db->update($this->products, $args, array('id' => $id));
		}
		return $id;
	}

	public function getMiniDetail( $id, $post_id = '' ) {

		$args = array();

        try {
            $args2 = $this->getProductDetails( $id );
			if( is_array($args2) && isset($args2['notfound'])){
				return array( 'error' => $args2['notfound'], 'id' => $id, 'post_id' => $post_id, 'line' => '252' );
        	}
		}
        catch( Exception $e ) {
            return array( 'error' => $e->getMessage(), 'id' => $id );
        }

		$args['subImageUrl'] 	= serialize( array($args2->imageUrl) );
        $args['price']			= $args2->originalPrice;
        $args['salePrice']		= isset($args2->salePrice) ? $args2->salePrice : $args2->originalPrice;

		return $this->updateProduct( $id, $args );
	}
	
	//get detail by one items
	public function getDetailById( $id ) {

		$args = array();
	
		$args = aliprice_obj2array( $args );

		/* get new details */
		try {
			$args2 = $this->getProductDetails( $id );
		}
		catch( Exception $e ) {
			return array( 'error' => $e->getMessage(), 'id' => $id );
		}

		if(  is_array($args2) && isset($args2['notfound']) )
			return array( 'error' => $args2['notfound'], 'id' => $id);
		
		$args2 = aliprice_obj2array( $args2 );

		if( in_array( $this->unitType, array('piece', 'lot' ) ) && $this->unitType != $args2['packageType'] )
			return array( 'error' => "Not right unit type", 'id' => $id, 'type' =>$this->unitType, 'pt' => $args2['packageType']  );

		/* get promotion links to seller and product */
		try {
			$too = array( $args2['productUrl'] );
			if( isset($args2['storeUrl']) )
				$too[] = $args2['storeUrl'];

			$urls = $this->getPromotionLinks( $too );
		}
		catch( Exception $e ) {
			return array( 'error' => $e->getMessage(), 'id' => $id );
		}

		if(  is_array($urls) && isset($urls['notfound']) )
			return array( 'error' => $urls['notfound'], 'id' => $id );
		
		$urls = $urls->promotionUrls;
		
		if( !isset($urls[0]) )
			return array( 'error' => $urls['notfound'], 'id' => $id );

		$detailUrl 		= $urls[0]->promotionUrl;
		$storeUrlAff 	= isset($urls[1]) ? $urls[1]->promotionUrl : '';
		
		$args['storeName']		= isset($args2['storeName']) ? $args2['storeName'] : '';
		$args['storeUrl']		= isset($args2['storeUrl']) ? $args2['storeUrl'] : '';
		$args['detailUrl']		= $args2['productUrl'];
		$args['productUrl']		= $detailUrl;
		$args['storeUrlAff']	= $storeUrlAff;
		$args['subImageUrl'] 	= serialize( array($args2['imageUrl']) );

		return $this->updateProduct( $id, $args );
	}

	public function updateLinks( $from, $to ) {

		$result = $this->db->get_results( $this->db->prepare("SELECT `productId`, `detailUrl`, `storeUrl` FROM `{$this->products}` LIMIT %d, %d", $from, $to) );

		if( !$result ) return false;

		$args = $promo = array();

		foreach( $result as $res ) {

			$args[$res->productId] = array(
				'url' => $res->detailUrl,
				'shop' => $res->storeUrl
			);

			$promo[] = $res->detailUrl;
			if( !empty($res->storeUrl) )
				$promo[] = $res->storeUrl;
		}

		try {
			$urls = $this->getPromotionLinks($promo);
			$urls = $urls->promotionUrls;

			if( count($urls) == 0 ){
				return $args;
			}

			$promo = array();

			foreach( $urls as $url ) {
				$promo[ $url->url ] = $url->promotionUrl;
			}

			$too = $foo = array();
			foreach($args as $id => $val){

				if( isset($promo[ $val['url'] ]) ) {
					$detailUrl = $promo[ $val['url'] ];
					$storeUrlAff = isset($promo[ $val['shop'] ]) ? $promo[ $val['shop'] ] : '';
					$this->updateProduct($id, array(
						'productUrl' => $detailUrl,
						'storeUrlAff' => $storeUrlAff
					));
				}
				else{
					$too[$id] = 'not found';
				}
			}

			return $too;
		}
		catch(Exception $e) {
			return $e->getMessage();
		}
	}

	// insert products
	private function insertProduct( $category_id, $args = array() ) {
	
		$args = aliprice_obj2array($args);
		
		$args['categoryAE'] = $category_id;
		
		$id = $this->db->get_var( $this->db->prepare("SELECT `id` FROM `{$this->products}` WHERE `productId` = '%s'", $args['productId']) );
		
		if( empty($id) ) {
			
			$this->db->insert( $this->products, $args );
			
			return $args['productId'] . " - inserted";
		}
		else {
		
			$this->db->update( $this->products, $args, array( 'id' => $id ) );
				
			return $args['productId'] . " - updated";
		}
	}
	
	//update product details
	public function updateProduct( $productId, $args = array() ){
		
		$obj = $this->db->get_row( $this->db->prepare("SELECT `id`, `post_id` FROM `{$this->products}` WHERE `productId` = '%s'", $productId) );

		if( $obj != null ) {
			
			$edited = get_post_meta($obj->post_id, 'aliprice_can_edit', true);
			
			if( !empty($edited) && $edited != 'can' ) {
				
				unset($args['description'], $args['attribute']);
			}

			$this->db->update( $this->products, $args, array( 'id' => $obj->id ) );

			return $productId;
		}
		
		return false;
	}
	
	//test connection to aliexpress
	function test_connection( ) {
		
		$method = sanitize_text_field($_POST['method']);
		$track 	= sanitize_text_field($_POST['track']);
		$app 	= sanitize_text_field($_POST['app']);
		$username = sanitize_text_field($_POST['username']);
		$password = sanitize_text_field($_POST['password']);

		parent::AliExpressJSONAPI2($app, $track, $username, $password);
		$this->method = $method;
		$str_method = ($method == 'curl') ? "cURL" : "Standard";
		
		echo '<h3>' . __('Checking connection', 'aliprice') . ' (method: ' . $str_method . ')</h3>';
		echo '<h4>' . __('Method:', 'aliprice') . ' <span>Username test</span></h4>';

		try {
			$list = $this->getAllProductsByCat(
				34,
				1,
				array(
				)
			);
			
			echo '<div class="alert alert-success">' . __('Username is ok', 'aliprice') . '</div>';
		}
		catch( Exception $e ) { 
			echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
		}

	}
}