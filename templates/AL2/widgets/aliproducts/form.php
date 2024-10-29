<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'gdn'); ?></label>
	<input type="text" class="widefat" 
		id="<?php echo $this->get_field_id('title'); ?>" 
		name="<?php echo $this->get_field_name('title'); ?>" 
		value="<?php echo $instance['title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id( 'atitle' ); ?>"><?php _e('Auto title: ', 'gdn'); ?></label>
	<input type="hidden" name="<?php echo $this->get_field_name('atitle'); ?>" value="0" />
	<?php 
		$selected = '';
		if(isset($instance['atitle']) && $instance['atitle']) {
			$selected = 'checked="checked" ';
		}
	?>
	<input <?php echo $selected; ?> type="checkbox" class="widefat" id="<?php echo $this->get_field_id('atitle'); ?>" 
		name="<?php echo $this->get_field_name('atitle'); ?>" value="1" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order: ', 'gdn'); ?></label>
	<?php 
		echo $this->getSelect($this->get_field_name('order'), $this->getOrders(), $instance['order'], array(
			'class' => 'widefat',
			'id'    => $this->get_field_id('order'),
		));
	?>
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Count:', 'gdn'); ?></label>
	<input type="text" class="widefat" 
		id="<?php echo $this->get_field_id('count'); ?>" 
		name="<?php echo $this->get_field_name('count'); ?>" 
		value="<?php echo $instance['count']; ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'cat' ); ?>"><?php _e('Category: ', 'gdn'); ?></label>
	<?php 
		echo ssdma_get_product_category(
			$this->get_field_name('cat'),
			$instance['cat'],
			array(
				'id' => $this->get_field_id( 'cat' ),
				'show_option_none' => 'New',
			)
		); 
	?>
</p>