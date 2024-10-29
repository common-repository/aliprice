<?php
/**
 *	
 */
class G_Posts extends WP_Widget
{
	private $_order = array(
		'date' => 'Date',
		'rand' => 'Random',
	);

	public function __construct()
	{
		// Instantiate the parent object
		parent::__construct( false, '(G) Posts', array(
			'description' => __( 'Output posts', 'ssdma' ),
		) );
	}

	public function getOrders()
	{
		return $this->_order;
	}

	public function getSelect($name, $options, $selected = 0, $attr = array())
	{
		$output = $attrs = '';
		foreach($attr as $k => $v) {
			$attrs .= $k .'="'. $v .'" ';
		}
		foreach($options as $k => $v) {
			$select = '';
			if($selected == $k) { $select = 'selected="selected"'; }
			$output .= '<option '.$select.' value="'. $k .'">'. $v .'</option>';
		}

		return '<select name="'.$name.'" '.$attrs.'>' . $output . '</select>';
	}

	public function widget( $args, $instance )
	{
		$instance = $this->initInstance($instance);

		// Widget output
		include('posts.php');
	}

	public function update( $new_instance, $old_instance )
	{
		// Save widget options

		$old_instance = $this->initInstance($new_instance);

		return $old_instance;
	}

	public function form( $instance )
	{
		// Output admin widget options form
		$instance = $this->initInstance($instance);

		include ('form.php');
	}

	protected function initInstance($instance)
	{
		// Output admin widget options form
		$instance['order']   = (isset($instance['order']) && !empty( $instance['order'])) ? strip_tags( $instance['order'] ) : current(array_keys($this->_order));

		if(isset( $instance['count']) && !empty( $instance['count']) && intval($instance['count']) < 20) {
			$instance['count'] = intval($instance['count']);
		} else {
			$instance['count'] = 4;
		}
		
		$instance['title']  = (isset( $instance['title']) && !empty( $instance['title'])) ? strip_tags( $instance['title'] ) : '';
		$instance['atitle'] = (isset( $instance['atitle']) && !empty( $instance['atitle']))? intval( $instance['atitle'] ) : 0;

        $instance['cat'] = (!empty( $instance['cat'])) ? intval( $instance['cat'] )  : -1;

		return $instance;
	}

}
register_widget('G_Posts');