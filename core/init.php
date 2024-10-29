<?php

/**
*	Initialization the custom post type
*/
add_action( 'init', 'aliprice_init' );
function aliprice_init( ) {

	// describe the type of content
	$args = array(
			'labels' => array(
					'name' 					=> __('Products', 'aliprice'),
					'singular_name' 		=> __('Item', 'aliprice'),
					'add_new' 				=> __('Add new', 'aliprice'),
					'add_new_item' 			=> __('Add a new Item', 'aliprice'),
					'edit_item' 			=> __('Edit Item', 'aliprice'),
					'new_item' 				=> __('New Item', 'aliprice'),
					'all_items' 			=> __('All Items', 'aliprice'),
					'view_item' 			=> __('View', 'aliprice'),
					'search_items' 			=> __('Search', 'aliprice'),
					'not_found' 			=> __('Products not found', 'aliprice'),
					'not_found_in_trash' 	=> __('Trash is empty', 'aliprice'),
					'parent_item_colon' 	=> '',
					'menu_name' 			=> __('Products', 'aliprice')),

			'singular_label'		=> __('Item', 'aliprice'),
			'public' 				=> true,
			'publicly_queryable'	=> true,
			'show_ui' 				=> true,
			'show_in_menu' 			=> true,
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'products', 'with_front' => false),
			'capability_type'		=> 'post',
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_icon'				=> plugins_url( 'aliprice/img/shop.png'),
			'supports'				=> array('title', 'editor', 'thumbnail', 'comments'),
		);

	register_post_type( 'products' , $args );

	register_taxonomy( 'shopcategory', array( 'products' ),
		array (

			'labels' => array(
						'name' 				=> __('Categories', 'aliprice'),
						'singular_name' 	=> __('Category', 'aliprice'),
						'search_items' 		=> __('Search', 'aliprice'),
						'all_items' 		=> __('All categories', 'aliprice'),
						'parent_item' 		=> __('Parent category', 'aliprice'),
						'parent_item_colon' => __('Parent category: ', 'aliprice'),
						'edit_item' 		=> __('Edit category', 'aliprice'),
						'update_item' 		=> __('Update category', 'aliprice'),
						'add_new_item' 		=> __('Add a new category', 'aliprice'),
						'new_item_name' 	=> __('The new name of the category', 'aliprice'),
						'menu_name' 		=> __('Categories', 'aliprice')
					),
			'public' 			=> true,
			'show_in_nav_menus' => true,
			'hierarchical' 		=> true,
			'show_ui' 			=> true,
			'query_var' 		=> true,
			'rewrite' 			=> array( 'slug' => 'shopcategory' ),
		)
	);
}

//fix a bag in custom terms from WP
add_action( 'init', 'aliprice_fix_terms_bug' );
function aliprice_fix_terms_bug( ) {

	if( is_admin() ) {

		$val = get_site_option("shopcategory_children");

		if( $val && !empty($val) )
			delete_option("shopcategory_children");
	}
}

/**
*	add filter to ensure the text Product, or product, is displayed when user updates a product
*/
add_filter( 'post_updated_messages', 'aliprice_updated_messages' );
function aliprice_updated_messages( $messages ) {

	global $post, $post_ID;

	$messages['products'] = array(
		0 => '', 
		1 => sprintf( __('Product updated. <a href="%s">View product</a>', 'aliprice'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'aliprice'),
		3 => __('Custom field deleted.', 'aliprice'),
		4 => __('Product updated.', 'aliprice'),
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'aliprice'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Product published. <a href="%s">View product</a>', 'aliprice'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Product saved.', 'aliprice'),
		8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>', 'aliprice'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>', 'aliprice'),
		  date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview product</a>', 'aliprice'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}


function aliprice_add_meta_box() {

	$post_types = get_post_types( array( 'public' => true ) );

	if ( is_array( $post_types ) ) {
		foreach ( $post_types as $post_type ) {

			if( $post_type != 'products' )
				add_meta_box(
					'aliprice_seo_metadata',
					__( 'SEO Metadata', 'aliprice' ),
					'aliprice_options_meta',
					$post_type,
					'normal',
					'high'
				);
		}
	}
}

function aliprice_options_meta( ) {

	global $post;

	$description 	= get_post_meta($post->ID, 'description', true);
	$keywords 		= get_post_meta($post->ID, 'keywords', true);
	$noindex		= get_post_meta($post->ID, 'noindex', true);
	$seotitle		= get_post_meta($post->ID, 'seo-title', true);
	$special		= get_post_meta($post->ID, 'special', true);

	?>
	<input type="hidden" name="ae_noncename_aeseo" id="ae_noncename_aeseo" value="<?php echo wp_create_nonce( 'aliprice_noncename_aeseo' ); ?>" />
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">
					<label for="seo-title"><?php _e('SEO Title', 'aliprice') ?>:</label>
				</th>
				<td>
					<input id="seo-title" type="text" value="<?php echo $seotitle ?>" name="seo-title" class="large-text"/>
					<p class="description"><?php _e('Example: Samsung Galaxy Tab 10.1 GT', 'aliprice') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="description"><?php _e('SEO Description', 'aliprice') ?>:</label>
				</th>
				<td>
					<textarea id="description" class="large-text code" name="description"><?php echo $description ?></textarea>
					<p class="description"><?php _e('Example: World Map PU Leather Hard Stand Case For Samsung Galaxy Tab 10.1 GT P7500 P7510 Free Shipping', 'aliprice') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="keywords"><?php _e('SEO Keywords', 'aliprice') ?>:</label>
				</th>
				<td>
					<input id="keywords" type="text" value="<?php echo $keywords ?>" name="keywords" class="large-text"/>
					<p class="description"><?php _e('Example: screen protector', 'aliprice') ?></p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="noindex"><?php _e('Noindex', 'aliprice') ?>:</label>
				</th>
				<td>
					<fieldset>
						<label for="noindex">
							<input id="noindex" type="checkbox" value="1" name="noindex" <?php echo ( !empty($noindex) ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable noindex", 'aliprice') ?>
						</label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="special"><?php _e('Specials', 'aliprice') ?>:</label>
				</th>
				<td>
					<fieldset>
						<label for="special">
							<input id="special" type="checkbox" value="1" name="special" <?php echo ( !empty($special) ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable special", 'aliprice') ?>
						</label>
					</fieldset>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

// add a hook to initialize the block when adding products
add_action( "admin_init", 'aliprice_admin_init' );
function aliprice_admin_init( ) {

	add_meta_box( "aliprice", __('Products Option', 'aliprice'), 'aliprice_options', 'products', 'normal', 'high' );
	aliprice_add_meta_box();
}

function aliprice_options(){

	global $post;

	$edited = get_post_meta($post->ID, 'aliprice_can_edit', true);
	$edited = ( empty($edited) || $edited == 'can' ) ? true : false;

	$etitle = get_post_meta($post->ID, 'aliprice_can_edit_title', true);
	$etitle = ( empty($edited) || $edited == 'can' ) ? true : false;

	$noindex = get_post_meta($post->ID, 'aliprice_noindex', true);
	$noindex = ( !empty($noindex) && $noindex == '1' ) ? true : false;

	$special = get_post_meta($post->ID, 'aliprice_special', true);
	$special = ( !empty($special) && $special == '1' ) ? true : false;
	
	$seotitle = get_post_meta($post->ID, 'aliprice_seo-title', true);

	$info = new AEProducts();
	$info->set($post->ID);


	?>
		<input type="hidden" name="ae_noncename_inventory" id="ae_noncename_inventory" value="<?php echo wp_create_nonce( 'aliprice_noncename_inventory' ); ?>" />
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="seo-title"><?php _e('SEO Title', 'aliprice') ?>:</label>
					</th>
					<td>
						<input id="seo-title" type="text" value="<?php echo $seotitle ?>" name="seo-title" class="large-text"/>
						<p class="description"><?php _e('Example: Samsung Galaxy Tab 10.1 GT', 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="summary"><?php _e('SEO Description', 'aliprice') ?>:</label>
					</th>
					<td>
						<textarea id="summary" class="large-text code" name="summary"><?php echo $info->getSummary() ?></textarea>
						<p class="description"><?php _e('Example: World Map PU Leather Hard Stand Case For Samsung Galaxy Tab 10.1 GT P7500 P7510 Free Shipping', 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="keywords"><?php _e('SEO Keywords', 'aliprice') ?>:</label>
					</th>
					<td>
						<input id="keywords" type="text" value="<?php echo $info->getKeywords() ?>" name="keywords" class="large-text"/>
						<p class="description"><?php _e('Example: screen protector', 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="noindex"><?php _e('Noindex', 'aliprice') ?>:</label>
					</th>
					<td>
						<fieldset>
							<label for="noindex">
								<input id="noindex" type="checkbox" value="1" name="noindex" <?php echo ( $noindex ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable noindex", 'aliprice') ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="special"><?php _e('Specials', 'aliprice') ?>:</label>
					</th>
					<td>
						<fieldset>
							<label for="special">
								<input id="special" type="checkbox" value="1" name="special" <?php echo ( $special ) ? 'checked="checked"' : '' ?>/> <?php _e("Enable special", 'aliprice') ?>
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="price"><?php _e('Price', 'aliprice') ?>:</label>
					</th>
					<td>
						<input id="price" type="text" value="<?php echo $info->getPrice() ?>" name="price" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e('Example: US $14.98', 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="salePrice"><?php _e('Sale Price', 'aliprice') ?>:</label>
					</th>
					<td>
						<input id="salePrice" type="text" value="<?php echo $info->getSalePrice() ?>" name="salePrice" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e('Example: US $10.44', 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="detailUrl"><?php _e('Affiliate link', 'aliprice') ?>:</label>
					</th>
					<td>
						<input id="detailUrl" type="text" value="<?php echo $info->getLink() ?>" name="detailUrl" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Availability', 'aliprice') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo ( $info->getAvailability() == 1 ) ? "in stock" : "not available" ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Commission Rate', 'aliprice') ?>:</label>
					</th>
					<td>
						<input type="text" value="8%" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Purchase volume', 'aliprice') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getPromotion() ?>" class="regular-text" readonly="readonly"/>
						<p class="description"><?php _e("The amount of purchases of the product over the last 30-day period", 'aliprice') ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Pieces per package', 'aliprice') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getLotNum() ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Way of packaging', 'aliprice') ?>:</label>
					</th>
					<td>
						<input type="text" value="<?php echo $info->getPackageType() ?>" class="regular-text" readonly="readonly"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<h2><?php _e("Images", 'aliprice') ?></h2>
						<img class="img-responsive" src="<?php echo $info->getThumb( 'medium' )?>">
						<?php

							$images = $info->getImages();

							if( $images ) :

								$images = unserialize( $images );

								if( count($images) > 1 ) :

									foreach( $images as $key => $img ) {
										?>
											<img src="<?php echo $info->getSizeImg( $img, 'thumb' ) ?>" class="img-responsive">
										<?php
									}

								endif;
							endif;
						?>
					</th>
					<td style="vertical-align:top !important">
						<?php

							$attributes = $info->getAttribute();
							$count 	= count( $attributes );
							if( $count && $count > 0 ) :
						?>
								<h2><?php _e("Attributes", 'aliprice') ?></h2>
								<table class="meta-parametrs">
									
									<?php foreach( $attributes as $k => $v ) : ?>

										<tr>
											<th><?php  echo isset($v['name']) ? $v['name'] . ':' : '' ?></th>
											<td><?php  echo isset($v['value']) ? $v['value']  : '' ?></td>
										</tr>

									<?php endforeach ?>

								</table>
						<?php
							endif;
						?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
}

// add a hook to save the product
add_action( 'save_post', 'aliprice_save_product', 10, 1 );
function aliprice_save_product( $post_id ){

	if ( !isset($_POST['aliprice_noncename_inventory']) ||
		!wp_verify_nonce( $_POST['aliprice_noncename_inventory'], 'aliprice_noncename_inventory') ) return;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

	if ( !current_user_can( 'edit_page', $post_id ) ) return;

	global $wpdb;

	$foo = array('keywords', 'summary');
	$args = array();

	foreach( $foo as $key ){
		$args[$key] = isset($_POST[$key]) ? strip_tags($_POST[$key]) : "";
	}

	$wpdb->update( $wpdb->prefix . 'aliprice_products', $args, array( 'post_id' => $post_id ) );

	if( isset($_POST['can_edited']) )
		update_post_meta($post_id, 'aliprice_can_edit', 'can');
	else
		update_post_meta($post_id, 'aliprice_can_edit', '');

	if( isset($_POST['can_edited_title']) )
		update_post_meta($post_id, 'aliprice_can_edit_title', 'can');
	else
		update_post_meta($post_id, 'aliprice_can_edit_title', '');

	if( isset($_POST['seo-title']) )
		update_post_meta($post_id, 'aliprice_seo-title', sanitize_text_field($_POST['seo-title']));

	if( isset($_POST['noindex']) )
		update_post_meta($post_id, 'aliprice_noindex', '1');
	else
		update_post_meta($post_id, 'aliprice_noindex', '0');
	if( isset($_POST['special']) )
		update_post_meta($post_id, 'aliprice_special', '1');
	else
		update_post_meta($post_id, 'aliprice_special', '0');
}

// add a hook to save seo
add_action( 'save_post', 'aliprice_save_seo', 10, 1 );
function aliprice_save_seo( $post_id ){

	if ( !isset($_POST['aliprice_noncename_aeseo']) ||
		!wp_verify_nonce( $_POST['aliprice_noncename_aeseo'], 'aliprice_noncename_aeseo') ) return;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

	if ( !current_user_can( 'edit_page', $post_id ) ) return;

	$foo = array('keywords', 'description');

	foreach( $foo as $key ) {
		update_post_meta($post_id, $key, strip_tags($_POST[$key]));
	}

	if( isset($_POST['seo-title']) )
		update_post_meta($post_id, 'seo-title', sanitize_text_field($_POST['seo-title']));

	if( isset($_POST['noindex']) )
		update_post_meta($post_id, 'noindex', '1');
	else
		update_post_meta($post_id, 'noindex', '0');
	if( isset($_POST['special']) )
		update_post_meta($post_id, 'special', '1');
	else
		update_post_meta($post_id, 'special', '0');
}

/**
* 	Modify columns title
*/
add_filter("manage_edit-products_columns", "aliprice_columns");
function aliprice_columns( $columns ) {

	unset($columns['author']);
	unset($columns['cb']);
	unset($columns['title']);

	return array(
			"cb" 			=> __('Select All', 'wp'),
			"thumb" 		=> __("Thumbnail", 'aliprice'),
			"title" 		=> __("Title", 'wp'),
			"shopcategory" 	=> __("Category", 'aliprice'),
			"views" 		=> __("Views", 'aliprice'),
			"redirects" 	=> __("Redirects", 'aliprice'),
			"price" 		=> __("Price", 'aliprice'),
			"quantity" 	    => __("Stock", 'aliprice'),
		) + $columns;
}

/**
*	Content columns
*/
add_action("manage_products_posts_custom_column", "aliprice_custom_columns");
function aliprice_custom_columns( $column ) {

	global $post;

	if ( "thumb" == $column ) {

		if( !empty($post->imageUrl) )
			echo '<img width="110" src="' . $post->imageUrl . '">';
	}
	elseif ( "price" == $column ) {

		echo $post->price;
	}
	elseif ( "views" == $column ) {

		$view = get_post_meta( $post->ID, 'views', true );
		echo !empty( $view ) ? $view : 0;
	}
	elseif ("redirects" == $column) {

		$view = get_post_meta( $post->ID, 'redirects', true );
		echo !empty( $view ) ? $view : 0;
	}
	elseif ( "shopcategory" == $column ) {

		$categories = wp_get_object_terms( $post->ID, 'shopcategory' );

		if ( is_array( $categories ) )
			foreach( $categories as $k => $category )
				echo '<a href="' . admin_url( 'edit-tags.php?action=edit&taxonomy=shopcategory&post_type=products&tag_ID=' . $category->term_id ) . '">' . $category->name . '</a><br />';
	}
	elseif ( "quantity" == $column ) {

		$color = ($post->quantity <= 15) ? '#db0f1a' : '#6adb4b';

        printf('<span style="color:%s">%d</span>', $color, $post->quantity);
	}
}

/**
*	Adding a Taxonomy Filter to Admin List for a Custom Post Type
*/
add_action( 'restrict_manage_posts', 'aliprice_restrict_manage_posts' );
function aliprice_restrict_manage_posts( ) {

	global $typenow;

	if ( $typenow == 'products' ) {

		$filters = array( 'shopcategory' );

		foreach ( $filters as $tax_slug ) {

			$tax_obj 	= get_taxonomy( $tax_slug );
			$tax_name 	= $tax_obj->labels->name;

			?>
				<select name="<?php echo strtolower( $tax_slug ) ?>" id="<?php echo strtolower( $tax_slug ) ?>" class="postform">
					<option value=''><?php _e('Show All', 'aliprice') ?> <?php echo $tax_name ?></option>

					<?php
							aliprice_generate_taxonomy_options( $tax_slug,
								0, 0,
								( isset( $_GET[ strtolower($tax_slug) ] ) ?
								$_GET[ strtolower($tax_slug) ] : null )
							)
					?>

				</select>
			<?php
		}
	}
}

/**
*	Apply filter for taxonomy
*/
function aliprice_generate_taxonomy_options( $tax_slug, $parent = '', $level = 0, $selected = null ) {

	$args = array( 'show_empty' => 1 );

	if( !is_null( $parent ) )
		$args = array( 'parent' => $parent );

	$terms 	= get_terms( $tax_slug, $args );
	$tab	= '';

	for( $i = 0; $i < $level; $i++ )
		$tab .= '-- ';

	foreach ( $terms as $term ) {

		echo '<option value=' . $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' . $tab . $term->name .' (' . $term->count .')</option>';

		aliprice_generate_taxonomy_options( $tax_slug, $term->term_id, $level+1, $selected );
	}
}

/**
*	Sorting columns for custom post type Products
*/
add_filter( 'manage_edit-products_sortable_columns', 'aliprice_view_sortable_column' );
function aliprice_view_sortable_column( $columns ) {

	$columns['views'] 	  = 'views';
	$columns['redirects'] = 'redirects';
	$columns['quantity']  = 'quantity';

	return $columns;
}

/**
*	Request to sorting columns for custom post type Products
*/
add_filter( 'request', 'aliprice_view_column_orderby' );
function aliprice_view_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) && 'views' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' 	=> 'views',
			'orderby' 	=> 'meta_value_num'
		) );
	}

	if ( isset( $vars['orderby'] ) && 'redirects' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' 	=> 'redirects',
			'orderby' 	=> 'meta_value_num'
		) );
	}

	return $vars;
}


/**
* 	Alter different parts of the query
*
* 	@param array $pieces
* 	@return array $pieces
*/
function aliprice_query_clauses( $pieces ) {


	$screen = get_current_screen();

	if( !isset($screen->post_type) || $screen->post_type != 'products' || $screen->base != 'edit' ) return $pieces;

	global $wpdb;

	$pieces['join'] = $pieces['join'] . " INNER JOIN `{$wpdb->prefix}aliprice_products` ON ({$wpdb->posts}.ID = `{$wpdb->prefix}aliprice_products`.`post_id`) ";
	$pieces['fields'] = $pieces['fields'] . ", price, commissionRate, quantity, imageUrl";
	$pieces['posts_groupby'] = "GROUP BY `{$wpdb->postmeta}`.`post_id`";

	return $pieces;
}

/**
 * Additional order by custom query vars
 *
 * @param $orderby_statement
 *
 * @return string
 */
function aliprice_query_posts_orderby( $orderby_statement ) {

    global $wpdb;

    $orderby  = get_query_var( 'orderby', false );
    $order    = get_query_var( 'order', false );

    $foo = array('quantity');

    if ( $orderby && in_array($orderby, $foo) ) {

        $order = ( $order == 'ASC' ) ? 'ASC' : 'DESC';

        $orderby_statement = $wpdb->products . '.' . $orderby . ' ' . $order;
    }

    return $orderby_statement;
}

add_action( 'admin_init', 'aliprice_get_screen' );
function aliprice_get_screen( ) {

	if( is_admin() ){
		add_filter( 'posts_clauses', 'aliprice_query_clauses', 20, 1 );
        add_filter( 'posts_orderby', 'aliprice_query_posts_orderby', 20, 1 );
    }
}

add_action( 'shopcategory_edit_form_fields', 'aliprice_custom_metabox_taxonomy', 10, 2);
add_action( 'category_edit_form_fields', 'aliprice_custom_metabox_taxonomy', 10, 2);
add_action( 'post_tag_edit_form_fields', 'aliprice_custom_metabox_taxonomy', 10, 2);

function aliprice_custom_metabox_taxonomy($tag, $taxonomy) {

	$noindex = get_site_option( "noindex_$tag->term_id" );

	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="noindex"><?php _e('Noindex', 'aliprice') ?></label></th>
		<td>
			<fieldset>
				<label for="noindex"><input name="noindex" type="checkbox" id="noindex"
						<?php if( $noindex && !empty($noindex) ) echo 'checked="checked"'; ?> value="1">
					<?php _e('Enable noindex', 'aliprice') ?>
				</label>
			</fieldset>
		</td>
	</tr>
<?php
}

/**
 * @param $term_id
 * @param $tt_id
 */
function aliprice_save_custom_metabox_taxonomy( $term_id, $tt_id ) {

	if(isset($_POST['taxonomy'])):

		if (isset($_POST['noindex']))
			update_site_option("noindex_$term_id", '1');
		else
			update_site_option("noindex_$term_id", '0');

	endif;
}
add_action( 'edited_terms', 'aliprice_save_custom_metabox_taxonomy', 10, 2);
?>