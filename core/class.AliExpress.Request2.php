<?php

class AliExpressJSONAPI2 {
	
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

	/**
	* Method of connection with AliExpress
	*/
	public $method = ALIPRICE_METHOD;


	function AliExpressJSONAPI2( $AppKey = "", $trackingId = "", $partner_username = "", $partner_password = "", $appsignature = "") { 
		$this->AppKey = $AppKey;
		$this->trackingId = $trackingId;
		$this->partner_username = $partner_username;
		$this->partner_password = $partner_password;
		$this->appsignature = $appsignature;

	}


    //check API keys
    function check_keys( ) {

        if( empty($this->AppKey) || empty($this->trackingId) ) return false;

        return true;
    }

    //check username
    function check_username( ) {

    	if( empty($this->partner_username) ) return false;

    	return true;
    }


	/**
	* Return details of a categories
	* @param int $category_id general of category
	* @return mixed object
	*/
	public function getAllProductsByCat( $category_id, $page = 1, $args = array(), $page_size = 20 ) {
		
		$defaults = array(
			'categoryId' 			=> '',
            'keywords' 				=> '',
            'originalPriceFrom' 	=> '',
            'originalPriceTo' 		=> '',
            'volumeFrom' 			=> '',
            'volumeTo' 				=> '',
            'pageNo' 				=> 1,
            'pageSize' 				=> '20',
            'sort'					=> 'validTimeDown',
            'startCreditScore'		=> '',
            'endCreditScore'		=> '',
            'fields'				=> 'totalResults,productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,volume,packageType,lotNum,validTime'
            
        );
		
		$parameters = wp_parse_args( $args, $defaults );
		
		$page = ( $page > 0 ) ? intval($page) : 1;
		
		$parameters["categoryId"] 	= intval($category_id);
		$parameters["pageNo"] 		= $page;
		$parameters["pageSize"] 	= ($page_size > 0) ? intval($page_size) : 20;
		
		if( empty($parameters['keywords']) ) unset($parameters['keywords']);
		
		if(
			empty($parameters['startCreditScore']) || 
			empty($parameters['endCreditScore']) 
		) unset($parameters['startCreditScore'], $parameters['endCreditScore']);
		
		if(
			empty($parameters['volumeFrom']) ||
			empty($parameters['volumeTo'])
		) unset($parameters['volumeFrom'], $parameters['volumeTo']);

		if( 
			empty($parameters['originalPriceFrom']) || 
			empty($parameters['originalPriceTo']) 
		) unset($parameters['originalPriceFrom'], $parameters['originalPriceTo']);
		$parameters['type'] = 'Products';

		return $this->queryAliExpress( $parameters, 'api.listPromotionProduct' );

	}

	/**
	* Return details of products
	* @param array $ids list of products ID
	* @return mixed object
	*/
	public function getAllProductsByIds( array $ids ) {

		if( count($ids) == 0 )
			return array( "notfound" => __("Not found", "aliprice") );

		$foo = array();

		foreach($ids as $id){
			$args = floatval($id);
			$foo[] = $this->getProductDetails( $args );
		}

		return $foo;
	}
	

	/**
	* Return Product Detail
	* @param int $productId parent category
	* @return mixed object
	*/
	public function getProductDetails( $productId ) {
		
		$parameters = array( 
			"productId" => $productId,
			"fields"	=> "productId,productTitle,productUrl,imageUrl,originalPrice,salePrice,discount,evaluateScore,volume,packageType,lotNum,validTime,storeName,storeUrl",
			'type'	=>	'ProductDetail'
		);
		
		return $this->queryAliExpress( $parameters, 'api.getPromotionProductDetail' );

	}
	
	/**
	* Return Product All Attributes From old version
	* @param int $productId parent category
	* @return mixed object
	*/
	public function getProductDetailsOld( $productId ) {
		
		$parameters = array( "productId" => $productId ,'type' => 'ProductDetail');
		
		return $this->queryAliExpress( $parameters, 'api.getPromotionProductDetail', 1 );

	}
	
	/**
	* Return Promotion Links
	* @param string $urls - List of URLs need to be converted to promotion URLs (limit 50)
	* @return mixed object
	*/
	public function getPromotionLinks( array $urls ) {
		
		$parameters = array( 
			"urls" => implode(',', $urls),
			'type' => 'PromotionLinks'
		);

		return $this->queryAliExpress( $parameters, 'api.getPromotionLinks' );

	}
	
	/**
	* Query Amazon with the issued parameters
	* @param array $parameters parameters to query around
	* @return objects query response
	*/
	private function queryAliExpress( $parameters, $ApiName, $ver = 2 ) {
		
		return $this->alip_request( $parameters, $ApiName, $ver, $this->AppKey, $this->trackingId, $this->partner_username, $this->partner_password );
	}
	
	/**
	* Get AliExpress request
	*/
	//接收AliExpress的数据
	private function ae_request( $params, $ApiName, $ver, $AppKey, $trackingId) {

		$method = "GET";
		$ApiKey = 't88TrkEkyhjIJaQffloQDlA1IGTFdzPmn09L5Yu4zB28x8g4t4OwfxeJwHpqrvnO';
		$host   = "api.eshopbing.me";
		$uri 	= "/index.php/api/wordpress/ali_request?ae_method=" . $this->method . '&ApiName=' . $ApiName . '&ver=' . $ver . '&AppKey=' . $AppKey . '&trackingId=' . $trackingId . '&ApiKey=' . $ApiKey ; 
	
		ksort($params);

		$keys = array( );
	
		foreach ( $params as $param => $value ) {
			$keys[] = $param . "=" . $value;
		}

		$keys = implode( "&", $keys );

		$request = "http://" . $host . $uri . '&' . $keys;

		$json_response = $this->request_data( $request );
		
		if($json_response === false){
			return false;
		}else{
			//json_decode返回array()
			$parsed_json = json_decode($json_response,true);
			return $parsed_json;
		}
	}

	/**
	*	check AliPrice member
	*/

	private function alip_request( $params, $ApiName, $ver, $AppKey, $trackingId, $username, $password ) {

		$method = "GET";
		$host	= "api.eshopbing.me";
		$url 	= "/index.php/api/wordpress/check/username/" . $username . '/password/' . $password;

		$request = "http://" . $host . $url;

		$json_response = $this->request_data( $request );

		if($json_response === false){
			return false;
		}else{
			return $this->ae_request( $params, $ApiName, $ver, $AppKey, $trackingId);
		}
	}

	/**
	*	get content by method
	*/
	function request_data( $request ) {
		/* CURL */
		if( $this->method == 'curl' ) { 
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $request );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 20 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
			
			$json_response = curl_exec($ch);
		}
		else{
            $json_response = @file_get_contents($request);
        }
		return $json_response;
	}
	
}