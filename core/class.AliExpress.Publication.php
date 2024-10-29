<?php

class AliExpressPublish {

    private $id			= "";
    private $db			= "";
    private $products 	= "";
    private $owncat 	= "";
    private $status 	= "";

    function __construct( $productId = '', $owncat = '', $status = 'publish' ) {

        global $wpdb;

        $this->id = floatval($productId);
        $this->owncat = !empty( $owncat ) ? $owncat : '';
        $this->db = $wpdb;
        $this->products = $this->db->prefix . 'aliprice_products';

        $foo = ad_constant_status();

        $this->status = isset( $foo[$status] ) ? $status : 'publish';
    }

    public function setId( $productId ) {

        $this->id = $productId;
    }

    public function Published( $no_parent = false ) {

        global $user_ID;

        $args = $this->getDetails( );
       
        if( !$args )
            return false;

        $terms = false;

        if( $this->owncat != 0 && empty($args->categoryAE) && !empty($args->categoryId) ){

            $own_terms = get_term_by('slug', $args->owncat, 'shopcategory');

            if( empty($own_terms) )
                return false;

            $_terms = $this->addTerm( $own_terms->term_id, $args->categoryId, $args->categoryName, true );

            $terms = $this->get_termsList( $this->owncat );
            if(is_array($_terms)) {
                $terms = array_merge($_terms, $terms);
            }
            $terms = array_unique($terms);
        }
        elseif( empty($this->owncat) && empty($args->post_id) ) {


            if ( ($args->categoryId == "" || $args->categoryName == "") && $args->categoryAE != '' ) {

                $title = aliprice_search_category_by_id($args->categoryAE);
                $slug = sanitize_title($title);
                $terms = $this->addTermNoParent( $slug, $title );
            }
            elseif( !$no_parent )
                $terms = $this->addTerm( $args->categoryAE, $args->categoryId, $args->categoryName );
            else
                $terms = $this->addTermNoParent( $args->categoryId, $args->categoryName );
        }
        else {
            if( empty($this->owncat) )
                $terms = wp_get_post_terms( $args->post_id, 'shopcategory', array("fields" => "ids") );
            else
                $terms = $this->get_termsList( $this->owncat );
        }

        if( !$terms )
            return false;

        $foo = $this->getParametrs();
        if( $foo ) {

            $title = isset($foo['title']) ? wp_strip_all_tags($foo['title']) : wp_strip_all_tags($args->subject);

            unset($foo['title']);

            $foo['sku'] 		= ( isset($foo['sku']) && is_array($foo['sku']) ) ? serialize($foo['sku']) : '';
            $foo['quantity'] 	= isset($foo['quantity']) ? intval($foo['quantity']) : 0;
            $foo['pack'] 		= ( isset($foo['pack']) && is_array($foo['pack']) ) ? serialize($foo['pack']) : '';
            $foo['attribute'] 	= ( isset($foo['attribute']) && is_array($foo['attribute']) ) ? serialize($foo['attribute']) : '';

            $insert = new AliExpressInsert();
            $insert->updateProduct($this->id, $foo);
        }
        else
            $title = wp_strip_all_tags($args->subject);

        $content = $this->translateContent();
        if( !$content )
            $content = $args->description;

        $html = aliprice_clean_html_style($content, true);

        $content = $html['content'];

        $images_arr = array();

        if( $args->imageUrl != '' )
            $images_arr[] = str_replace('_220x220.jpg', '', $args->imageUrl);

        if( count($html['images']) > 0 )
            $images_arr = array_merge($images_arr, $html['images']);

        $this->updateGallery( $args->productId, $images_arr );

        $post = array(

            'comment_status' 	=> 'open',
            'ping_status' 		=> 'closed',
            'post_author' 		=> $user_ID,
            'post_status' 		=> $this->status,
            'post_title' 		=> $title, //The title of your post.
            'post_content'		=> $content, //the_content
            'post_type' 		=> 'products'
        );

        $ID = "";

        if( $args->post_id != 0 )
            $ID = $this->checkPublished( $args->post_id );

        if( !empty($ID) ) {

            $post['ID'] = $ID;

            $edited = get_post_meta($ID, 'aliprice_can_edit', true);
            $edtitle = get_post_meta($ID, 'aliprice_can_edit_title', true);

            $defaults = array(
                'inteval' 		=> 'daily',
                'enabled' 		=> '0',
                'description'	=> '0',
                'etitle'		=> '0'
            );

            $auto = get_site_option('aliprice-autoupdate');
            $auto = ( !$auto ) ? array() : unserialize($auto);

            $auto = wp_parse_args( $auto, $defaults );

            unset($post['post_status']);

            if( empty($edtitle) || $edtitle != 'can' ) {
                unset($post['post_author'], $post['post_title']);
            }
            elseif( $auto['etitle'] == 1 ) {
                unset($post['post_author'], $post['post_title']);
            }

            if( empty($edited) || $edited != 'can' ) {
                unset($post['post_author'], $post['post_content']);
            }
            elseif( $auto['description'] == 1 ) {
                unset($post['post_author'], $post['post_content']);
            }

            $ID = wp_update_post( $post );
        }
        else
            $ID = wp_insert_post( $post );

        if( $ID ) {

            $this->updatePostID( $args->productId, $ID );

            update_post_meta( $ID, 'ali_id', $args->productId);

            $terms = array_map( 'intval', $terms );
            $terms = array_unique( $terms );

            wp_set_object_terms( $ID, $terms, 'shopcategory' );

            return array('id' => $ID );
        }

        return false;
    }

    /**
     * Get description from AliExpress
     * @return array|bool|mixed|string|WP_Error
     */
    function translateContent() {

        if( ALIPRICE_LANG == 'en' )
            $content = wp_remote_get("http://desc.aliexpress.com/getDescModuleAjax.htm?productId=" . $this->id . "&t=" );
        else
            $content = wp_remote_get("http://" . ALIPRICE_LANG . ".aliexpress.com/getSubsiteDescModuleAjax.htm?productId=" . $this->id  );

        if( is_wp_error($content) )
            return false;

        $content = str_replace(array("window.productDescription='", "';"), '', $content['body']);
        $content = trim( mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8') );

        if( !empty($content) )
            return $content;

        return false;
    }

    /**
     * Get title from AliExpress
     * @return bool|string
     */
    function traslateTitle() {

        $url 	= "http://" . ALIPRICE_LANG . ".aliexpress.com/item/-/" . $this->id . ".html";
        $html 	= wp_remote_get( $url );

        if( is_wp_error($html) )
            return false;

        $str 	= mb_convert_encoding( $html['body'], 'HTML-ENTITIES', 'UTF-8' );

        $domd = new DOMDocument();

        libxml_use_internal_errors(true);
        $domd->loadHTML($str);
        libxml_use_internal_errors(false);
        $domd->preserveWhiteSpace = false;

        $titles = $domd->getElementsByTagName('h1');
        foreach( $titles as $title ) {

            if ( $title->getAttribute('class') == 'product-name' ) {
                return trim($title->nodeValue);
            }
        }

        return false;
    }

    /**
     * Get html content from AliExpress
     * @return bool|string
     */
    function htmlContent( ) {

        $lang 	= (ALIPRICE_LANG == 'en') ? 'www' : ALIPRICE_LANG;

        $url 	= "http://" . $lang . ".aliexpress.com/item//" . $this->id . ".html";

        $request = wp_remote_get($url);

        if( is_wp_error($request) )
            return false;

        return mb_convert_encoding( $request['body'], 'HTML-ENTITIES', 'UTF-8' );
    }

    /**
     * Update some parametrs
     */
    public function updateParametrs() {
        $foo = $this->getParametrs();
        if( $foo ) {

            unset($foo['title']);

            $foo['sku'] 		= ( isset($foo['sku']) && is_array($foo['sku']) ) ? serialize($foo['sku']) : '';
            $foo['quantity'] 	= isset($foo['quantity']) ? intval($foo['quantity']) : 0;
            $foo['pack'] 		= ( isset($foo['pack']) && is_array($foo['pack']) ) ? serialize($foo['pack']) : '';
            $foo['attribute'] 	= ( isset($foo['attribute']) && is_array($foo['attribute']) ) ? serialize($foo['attribute']) : '';
            $foo['timeleft'] 	= isset($foo['timeleft']) ? absint($foo['timeleft']) : 0;

            $insert = new AliExpressInsert();
            $insert->updateProduct($this->id, $foo);
        }
    }

    /**
     * Get parameters from SKU, Title Quantity and Timeleft
     * @return array|bool
     */
    function getParametrs() {

        $html = $this->htmlContent();

        $domd 	= new DOMDocument();

        libxml_use_internal_errors(true);

        try {
            $domd->loadHTML($html);
        }
        catch(Exception $e){
            return false;
        }

        $domd->preserveWhiteSpace = false;

        $foo = array();

        $titles = $domd->getElementsByTagName('h1');
        $end 	= false;

        foreach( $titles as $title ) {

            if( $end )
                continue;

            if ( $title->getAttribute('class') == 'product-name' ) {
                $foo['title'] = trim($title->nodeValue);
                $end = true;
            }
        }

        $sku = $domd->getElementById('product-info-sku');

        $foo['sku'] = $this->listSKUParams($sku);

        $pack = $domd->getElementById('shipping-payment');
        $foo['pack'] = $this->listPackParams($pack);

        $quantity = $domd->getElementById('quantity-no');
        if( !empty($quantity) )
            $foo['quantity'] = $quantity->textContent;

        $params = $domd->getElementById('product-desc');
        $foo['attribute'] = $this->listParams($params);

        $foo['timeleft'] = 0;

        $time = $domd->getElementById('discount-count-down');
        if( empty($time) ) {

            $xpath = new DOMXpath($domd);
            $times = $xpath->query('//span[@class="time-left"]');

            if( $times->length > 0 ) {
                $it = 0;

                foreach($times as $time) {

                    $it++;

                    if($it > 1) continue;

                    $foo['timeleft'] = strtotime('now') + ( preg_replace('/\D/', '', $time->nodeValue)*24*60*60 );
                }
            }
        }

        return $foo;
    }

    /**
     * Get SKU parameters from AliExpress
     * @param $dom
     * @param array $foo
     * @param int $i
     * @return array
     */
    function listSKUParams( $dom, $foo = array(), $i = 0 ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if ( $this->hasChild($node) ) {

                if( $node->nodeName == 'dl' ){
                    $i++;
                    $foo[$i] = array( );
                }

                $foo = $this->listSKUParams( $node, $foo, $i );

            } elseif ($node->nodeType == XML_ELEMENT_NODE){

                if( $node->nodeName == 'dt' ) {
                    $foo[$i]['title'] = trim( str_replace(':', '', $node->nodeValue) );
                }
                elseif($node->nodeName == 'span') {
                    if (!isset($foo[$i]['params']))
                        $foo[$i]['params'] = array();

                    if( !empty($node->nodeValue) )
                        $foo[$i]['params'][] = trim($node->nodeValue);
                    else{
                        $title = trim($node->getAttribute("title"));
                        if($title != '')
                            $foo[$i]['params'][] = $title;
                    }
                }
                elseif( $node->nodeName == 'img' ){
                    $foo[$i]['params'][] = trim($node->getAttribute("src"));
                }
            }
        }
        return $foo;
    }
    /**
     * Get Parametrs of product from AliExpress
     * @param $dom
     * @param array $foo
     * @param int $i
     * @return array
     */
    function listParams( $dom, $foo = array(), $i = 0 ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if ( $this->hasChild($node) ) {

                if( $node->nodeName == 'dl' ){
                    $i++;
                    $foo[$i] = array( );
                }

                $foo = $this->listParams( $node, $foo, $i );

            } elseif ($node->nodeType == XML_ELEMENT_NODE){

                if( $node->nodeName == 'dt' ) {
                    $foo[$i]['name'] = trim( str_replace(':', '', $node->nodeValue) );
                }
                elseif($node->nodeName == 'dd') {
                    $foo[$i]['value'] = $node->nodeValue;
                }
            }
        }
        return $foo;
    }

    /**
     * Get Package parameters from AliExpress
     * @param $dom
     * @param array $foo
     * @return array
     */
    function listPackParams( $dom, $foo = array() ){

        if( !isset($dom->childNodes) )
            return $foo;

        foreach ( $dom->childNodes as $node ){

            if ( $this->hasChild($node) ) {

                $foo = $this->listPackParams( $node, $foo );

            } elseif ($node->nodeType == XML_ELEMENT_NODE){

                if($node->nodeName == 'dd') {

                    if( $node->getAttribute('class') == 'pnl-packaging-weight' ) {
                        $foo['weight'] = $node->getAttribute("rel");
                    }
                    elseif( $node->getAttribute('class') == 'pnl-packaging-size' ) {
                        $foo['size'] = $node->getAttribute("rel");
                    }
                    else{
                        $foo['packagetype'] = trim($node->nodeValue);
                    }
                }
            }
        }
        return $foo;
    }

    /**
     * Check if DOM element has child
     * @param $p
     * @return bool
     */
    function hasChild($p) {

        if ($p->hasChildNodes()) {
            foreach ($p->childNodes as $c) {
                if ($c->nodeType == XML_ELEMENT_NODE)
                    return true;
            }
        }
        return false;
    }


    //get array from terms
    public function get_termsList( $slug, $too = array() ) {

        $term = get_term_by( 'slug', $slug, 'shopcategory' );

        if( !$term ) return false;

        $too[] = $term->term_id;

        if( $term->parent == 0 )
            return $too;

        $parent = get_term_by( 'id', $term->parent, 'shopcategory' );

        if( !$term ) return false;

        return $this->get_termsList( $parent->slug, $too );
    }

    //get detail by product
    public function getDetails( ) {

        return $this->db->get_row(
            $this->db->prepare( "SELECT * FROM `{$this->products}` WHERE `productId` = $this->id ")
        );
    }

    //get detail by post_id
    public function getDetailsByPost( $post_id ) {

        return $this->db->get_row(
            $this->db->prepare( "SELECT * FROM `{$this->products}` WHERE `post_id` = '%d'", $post_id )
        );
    }

    //check and add terms
    private function addTerm( $parent, $child, $name_child, $own = false ) {

        $term_child = get_site_option('term_child-' . $child);

        if( !$own )
            $term_parent = get_site_option('term_parent-' . $parent);
        else
            $term_parent = $parent;

        if( !$term_parent ) {

            $parent_name = $this->nameParent( $parent );

            if( !$parent_name )
                return false;

            $term_parent = wp_insert_term( $parent_name, 'shopcategory' );

            if( !$term_parent || is_wp_error($term_parent) ){

                $parent_arr = get_term_by( 'name', $parent_name, 'shopcategory' );

                if( empty($parent_arr) )
                    return false;

                $term_parent = $parent_arr->term_id;
            }
            else
                $term_parent = $term_parent['term_id'];

            add_site_option( 'term_parent-' . $parent, $term_parent );
        }

        if( !$term_child ) {

            $term_child = wp_insert_term( $name_child, 'shopcategory', array( 'parent' => $term_parent ) );

            if( !$term_child || is_wp_error($term_child) ){

                $code = $term_child->get_error_code();

                if( $code == 'missing_parent') {
                    $term_parent = $this->addParentTerm( $parent );

                    if( !$term_parent ) return false;

                    $term_parent = $term_parent['term_id'];

                    $term_child = wp_insert_term( $name_child, 'shopcategory', array( 'parent' => $term_parent ) );

                    if( !$term_child || is_wp_error($term_child) ) {

                        if( $code == 'missing_parent')
                            return false;

                        $child_arr = get_term_by( 'name', $name_child, 'shopcategory' );

                        if( empty($child_arr) )
                            return false;

                        $term_child = $child_arr->term_id;
                    }
                }
                else {

                    $child_arr = get_term_by( 'name', $name_child, 'shopcategory' );

                    if( empty($child_arr) )
                        return false;

                    $term_child = $child_arr->term_id;
                }
            }
            else
                $term_child = $term_child['term_id'];

            add_site_option( 'term_child-' . $child, $term_child );
        }

        return array( $term_parent, $term_child );
    }

    //check and add terms
    private function addTermNoParent( $child, $name_child ) {

        $term_child = get_site_option('term_child-' . $child);

        if( !$term_child ) {

            $term_child = wp_insert_term( $name_child, 'shopcategory' );

            if( is_wp_error($term_child) && isset($term_child->error_data['term_exists'])){
                $term_child = $term_child->error_data['term_exists'];
            }
            else
                $term_child = $term_child['term_id'];

            add_site_option( 'term_child-' . $child, $term_child );
        }

        return array( $term_child );
    }

    private function addParentTerm( $parent ) {

        $parent_name = $this->nameParent( $parent );

        if( !$parent_name )
            return false;

        $term_parent = wp_insert_term( $parent_name, 'shopcategory' );

        if( !$term_parent || is_wp_error( $term_parent ) ){

            $parent_arr = get_term_by( 'name', $parent_name, 'shopcategory' );

            if( empty($parent_arr) )
                return false;

            $term_parent = $parent_arr->term_id;
        }
        else
            $term_parent = $term_parent['term_id'];

        add_site_option( 'term_parent-' . $parent, $term_parent );

        return $term_parent;
    }

    //check exists product
    private function checkPublished( $post_id ) {

        return $this->db->get_var(
            $this->db->prepare( "SELECT `ID` FROM `{$this->db->posts}` WHERE `ID` = '%d'", $post_id )
        );
    }

    //get name by parent category
    private function nameParent( $ali_id ) {


        return aliprice_search_category_by_id( $ali_id );
    }

    //update post_id
    private function updatePostID( $product_id, $post_id ) {

        $this->db->update( $this->products,
            array('post_id' => $post_id),
            array('productId' => $product_id)
        );
    }
    //update gallery
    private function updateGallery( $product_id, $gallery ) {

        $this->db->update( $this->products,
            array('subImageUrl' => serialize($gallery) ),
            array('productId' => $product_id),
            array('%s'),
            array('%d')
        );
    }
}