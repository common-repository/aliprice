<?php /** * Created by AL1. * User: Dmitry Nizovsky * Date: 09.02.15 * Time: 16:37 */ ?>
<div class="b-product-sort">
	<ul class="nav nav-pills">
		<li class="title"><?php _e('Sort by', 'ssdma'); ?>:</li>
		<?php foreach(ssdma_sort_array() as $k => $v): ?>
			<li<?php echo (ssdma_is_var_in_get('orderby', $k)) ? ' class="active"' : ''; ?>>
				<?php if($v['sort']): ?>
					<?php $order = ssdma_is_var_in_get('order', false, 'ASC', array('string', array('ASC', 'DESC'), 'ASC')); if($order == 'ASC') { $order = 'DESC'; } else { $order = 'ASC'; } ?>
					<a href="<?php echo ssdma_get_to_string(array('orderby' => $k, 'order' => $order)); ?>"><?php echo $v['name']; ?><span class="b-social-icon-sort"></span></a>
				<?php else: ?>
				<a href="<?php echo ssdma_get_to_string(array('orderby' => $k, 'order' => 'DESC')); ?>">
				<?php echo $v['name']; ?></a>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
	</ul>
</div>