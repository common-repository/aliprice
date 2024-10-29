<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 09.02.15 * Time: 15:34 */ ?>
<div class="b-filter-slider-base clearfix">
	<h2 class="h-left-sidebar"><?php _e('Sort by Price', 'ssdma'); ?></h2>
	<div class="b-filter-slider" data-toggle="slider" data-max="<?php echo floatval(aliprice_get_price(get_option('aliprice-max-price'), false)); ?>"></div>
	<div class="col-sm-11 col-xs-24"><input type="text" id="filter-slider-min"/></div>
	<div class="col-sm-2 col-xs-24"><hr/></div>
	<div class="col-sm-11 col-xs-24">
		<input type="text" id="filter-slider-max"/>
	</div>
</div>
<h2 class="h-left-sidebar"><?php _e('Categories', 'ssdma'); ?></h2>
<ul class="nav b-nav-categories b-checked-cats">
	<?php	$ids = ssdma_get_term_ids(); if($cid = ssdma_get_term_ids(true)) { $t = get_term_by('id', $cid, 'shopcategory'); 
			if($t) { $cid = $t->parent; } } $term_p = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
			$id = ($term_p) ? $term_p->term_id: $cid; $pid = ($term_p) ? $term_p->parent: $cid; $items = ssdma_categories_menu($id); ?>
	<li class="marker">
		<label>
			<input type="checkbox" name="ids" value="<?php echo $id; ?>" <?php if($ids && in_array($id, $ids)): ?>checked="checked"<?php endif; ?> />
			<?php _e('Select all', 'ssdma'); ?>
		</label>
		<a href="#" class="b-unselect">
			<?php _e('Unselect all', 'ssdma'); ?>
		</a>
	</li>
	<?php if($term_p && $pid != 0): ?>
		<?php $term = get_term_by('id', $pid, get_query_var( 'taxonomy' )); ?>
	<li>
		<a href="<?php echo get_term_link( $pid, get_query_var( 'taxonomy' ) ); ?><?php echo ssdma_get_to_string(); ?>">
			<span class="b-social-icon-angle-circled-left"></span>
			<?php echo $term->name; ?>
		</a>
	</li>
	<?php elseif($pid == 0 && $term_p): ?>
	<li>
		<a href="<?php echo esc_url(home_url('/products')); ?><?php echo ssdma_get_to_string(); ?>">
			<span class="b-social-icon-angle-circled-left"></span>
			<?php _e('Products', 'ssdma'); ?>
		</a>
	</li>
	<?php endif; ?>
	<?php if(count($items)): ?><?php foreach($items as $cat): ?>
	<li<?php if($ids && in_array($cat['id'], $ids)): ?> class="active"<?php endif; ?>>
		<input type="checkbox" name="ids" value="<?php echo $cat['id']; ?>" <?php if($ids && in_array($cat['id'], $ids)): ?>checked="checked"<?php endif; ?> />
		<a href="<?php echo $cat['link']; ?><?php echo ssdma_get_to_string(array('ids' => '')); ?>"><?php echo $cat['name']; ?> (<?php echo $cat['count']; ?>) </a>
	</li>
	<?php endforeach; ?>
	<?php endif; ?>
</ul>