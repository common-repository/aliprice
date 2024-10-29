<?php

class AEProducts {

	private $id 		= "";
	private $db			= "";
	private $products 	= "";
	private $info	 	= "";

	function AEProducts() {

		global $wpdb;

		$this->db = $wpdb;
		$this->products = $this->db->prefix . 'aliprice_products';
	}
	/**
	 * Get percent of discount
	 * @return bool|string
	 */
	 public function setInfo( $info, $post_id = '' ) {

		$this->info = $info;

		if( $post_id != '' )
			$this->id = $post_id;
		

	}
	public function getDiscount( ) {

		if( $this->info == '' ) return false;

		return $this->info->discount;
	}
	//set id and get info
	public function set( $post_id ) {

		$this->id = $post_id;

		$this->info = $this->getInfoByPost();

		return $this->info;
	}

	//get productId
	public function getProductId() {

		if( $this->info == '' ) return false;

		return $this->info->productId;
	}

	//get price
	public function getPrice() {

		if( $this->info == '' ) return false;

		return $this->info->price;
	}

	//get salePrice
	public function getSalePrice() {

		if( $this->info == '' ) return false;

		return $this->info->salePrice;
	}

	//get packageType
	public function getPackageType() {

		if( $this->info == '' ) return false;

		return ($this->info->packageType == 'piece') ? __('piece', 'aliprice') : __('lot', 'aliprice');
	}

	//get lotNum
	public function getLotNum() {

		if( $this->info == '' ) return false;

		return $this->info->lotNum;
	}

	//get availability
	public function getAvailability() {

		if( $this->info == '' ) return false;

		return $this->info->availability;
	}

	//get title
	public function getTitle() {

		if( $this->info == '' ) return false;

		return $this->info->subject;
	}

	//get description
	public function getDescription() {

		if( $this->info == '' ) return false;

		return $this->info->description;
	}

	//get attribute
	public function getAttribute() {

		if( $this->info == '' ) return false;
		$attributes = aliprice_unserialize($this->info->attribute);
		return ($attributes) ? aliprice_obj2array($attributes) : array();
		}
	

	//get imageUrl
	public function getThumb( $size = '' ) {

		if( $this->info == '' ) return false;

		$url = $this->info->imageUrl;

		return $this->getSizeImg( $url, $size );
	}
/**
	 * Get thumbnail url by post_id
	 *
	 * @param string $size
	 *
	 * @return bool|string
	 */
	public function thumb( $size = 'thumbnail', $id = '' ) {

		if( $id != '' ) {

			if ( has_post_thumbnail( $id ) ) {
				$thumb_id = get_post_thumbnail_id( $id );
				$url      = wp_get_attachment_image_src( $thumb_id, $size );

				return $url[0];
			}
			else {

				$info = $this->getInfoByPost($id);
				$url = $info->imageUrl;

				return $this->getThumb( $url, 'large' );
			}
		}
		else {

			if ( has_post_thumbnail( $this->id ) ) {
				$thumb_id = get_post_thumbnail_id( $this->id );
				$url      = wp_get_attachment_image_src( $thumb_id, $size );

				return $url[0];
			}
			else {

				$url = $this->info->imageUrl;

                if( aliprice_is_url($url) )
    				return $this->getThumb( $url, 'large' );

                return false;
			}
		}
	}
	//get subImageUrl
	//return objects
	public function getImages() {

		if( $this->info == '' ) return false;

		return $this->info->subImageUrl;
	}
	
	public function getGallery() {

        if( !isset($this->info->gallery) )
            return false;

		return $this->aliprice_unserialize( $this->info->gallery );
	}
	//show gallery, with js
	public function the_gallery() {

		$images = $this->getImages();

		if( !$images ) return false;

		$images = unserialize( $images );

		if( count($images) == 0 ) return false;

		$slides = $ol = array();

		if( count($images) == 1 ){

			$thumb 	= $this->getThumb( 'thumb' );
			$img 	= $this->getThumb( );

			$ol[] = '<li data-target="#thumb-view" data-slide-to="0" class="active"><span><img src="' . $thumb . '"></span></li>';

			$slides[] = '<div class="item clearfix active"><img src="' . $img . '"></div>';
		}
		else {
			foreach( $images as $key => $img ) {

				$thumb = $this->getSizeImg( $img, 'thumb' );

				$class = ( $key == 0 ) ? 'active' : '';

				$ol[] = '<li data-target="#thumb-view" data-slide-to="' . $key . '" class="' . $class . '"><span><img src="' . $thumb . '"></span></li>';

				$slides[] = '<div class="item clearfix ' . $class . '"><img src="' . $img . '"></div>';
			}
		}

		?>
		<div id="thumb-view" class="carousel slide" data-ride="carousel">

			<div class="carousel-inner">
				<?php echo implode("", $slides) ?>
			</div>
			<ol class="carousel-indicators">
				<?php echo implode("", $ol) ?>
			</ol>
		</div>
	<?php
	}

	//get productUrl
	public function getLink() {

		if( $this->info == '' ) return false;

		return $this->info->productUrl;
	}

	//get detailUrl
	public function getDetailUrl() {

		if( $this->info == '' ) return false;

		return $this->info->detailUrl;
	}

	//get keywords
	public function getKeywords() {

		if( $this->info == '' ) return false;

		return $this->info->keywords;
	}

	//get keywords
	public function getSummary() {

		if( $this->info == '' ) return false;

		return $this->info->summary;
	}

	//get freeShippingCountry
	public function getShipping() {

		if( $this->info == '' ) return false;

		return $this->info->freeShippingCountry;
	}

	//get commissionRate
	public function getComissionRate() {

		if( $this->info == '' ) return false;

		return $this->info->commissionRate;
	}
		/**
	 * Get rating from product
	 * @return bool|string
	 */
	 
	public function getRate( ) {

		if( $this->info == '' ) return false;

		return $this->info->evaluateScore;
	}
    function starRating( $method = '' ) {

        $number = floatval( $this->getRate( ) );
        $max    = 5;

        $int    = intval($number);
        $star   = array();

        for($i=0; $i < $int; $i++) {
            $star[] = 'full';
        }

        if( $int != $number )
            $star[] = 'half';

        $empty  = $max - count($star);
        for($i=0; $i < $empty; $i++) {
            $star[] = 'no';
        }

        $star = implode('"></span><span class="star star-', $star);

        if( $method != '' && method_exists($this, $method) )
            $method = '<span class="call-item"> (' . $this->$method() . ')</span>';

        return '<div class="stars"><span class="star star-' . $star . '"></span>' . $method . '</div>';
    }
    function ratingPercentage( ) {

        $number = floatval( $this->getRate( ) );
        $max    = 5;

        return ($number*100)/$max;
    }
	//get commission
	public function getComission() {

		if( $this->info == '' ) return false;

		return $this->info->commission;
	}

	//get evaluateScore
	public function getRating() {

		if( $this->info == '' ) return false;

		return $this->info->evaluateScore;
	}

	public function getStoreName() {

		if( $this->info == '' ) return false;

		return $this->info->storeName;
	}

	public function getStoreUrl() {

		if( $this->info == '' ) return false;

		return $this->info->storeUrlAff;
	}

	//get promotionVolume
	public function getPromotion() {

		if( $this->info == '' ) return false;

		return $this->info->promotionVolume;
	}

	//	Best Sellers post id
	// 	return array / false
	public function bestSellers( $count = 4 ) {

		$results = $this->db->get_results(
			$this->db->prepare( "SELECT `post_id` FROM `{$this->products}` WHERE `post_id` <> 0
                ORDER BY CAST(`promotionVolume` as SIGNED) DESC LIMIT 0, %d", $count )
		);

		if( !$results ) return false;

		$foo = array();

		foreach( $results as $p )
			$foo[] = $p->post_id;

		return $foo;
	}

    /**
     * Specials post id
     *
     * @param int $count
     * @return array|bool
     */
	public function specials( $count = 4 ) {

        $meta_key   = "aliprice_special";

	    $results    = $this->db->get_results(
            $this->db->prepare(
                "SELECT `{$this->db->postmeta}`.*
                    FROM (
                        SELECT `post_id` FROM `{$this->db->postmeta}`
                        WHERE `meta_key` = %s AND meta_value=1
                        ORDER BY RAND() LIMIT %d
	                ) as ids JOIN `{$this->db->postmeta}` ON `{$this->db->postmeta}`.post_id = ids.post_id",
	            $meta_key,
	            $count
            )
        );

        if( !$results ) {
		    $results = $this->db->get_results(
			    $this->db->prepare(
                    "SELECT `post_id` FROM `{$this->products}` `p`
                        WHERE `post_id` <> 0
                        ORDER BY CAST( `p`.`commissionRate` AS DECIMAL( 3, 2 ) ) LIMIT 0 , %d", $count
                )
		    );
	    }

        if( !$results ) return false;

		$foo = array();

		foreach( $results as $p )
			$foo[] = $p->post_id;

		return $foo;
	}

	//size of thumbnails
	public function getSizeImg( $url, $size = 'medium' ) {

		$foo = array(
			'thumb' => '_50x50.jpg',
			'medium' => '_220x220.jpg'
		);

		if( !isset( $foo[$size] ) ) return $url;

		return $url . $foo[$size];
	}

	private function searchOption( $value, $str = '' ) {

		if( ! is_array($value) )
			$value = array($value);

		$and = ( $str != '' ) ? "`option_name` LIKE '". $str . "%' AND" : "";

		$foo = " 1=1 AND (`option_value` = '" . implode("' OR `option_value` = '", $value) . "')";

		$sql = "SELECT * FROM `{$this->db->options}` WHERE " . $and . $foo;

		return $this->db->get_results( $sql );
	}

	//get detail by post_id
	private function getInfoByPost( ) {

		if( $this->id == '' ) return false;

		return $this->db->get_row(
			$this->db->prepare( "SELECT * FROM `{$this->products}` WHERE `post_id` = '%d'", $this->id )
		);
	}

    public function getSKU() {

        return aliprice_unserialize( $this->info->sku );
    }

    public function getQuantity() {

        if( isset($this->info->quantity) ) return 0;

        return $this->info->quantity;
    }

    public function getTimeLeft() {

        return $this->info->timeleft;
    }

}