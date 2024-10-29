<?php

class AliExpressAdminTpl{
        
	/**
	*	create template for admin page
	*/
	function createTpl( $content ) {
		
		$this->header();
		
		echo $content;
		
		$this->footer();

	}
	
	public function currentItemMenu( ) {
		
		$page = isset($_GET['aepage']) ? $_GET['aepage'] : 'dash';
		
		if( !$page ) {
				
			$list = templList();
			$page = key( $list );
		}

		return $page;
	}
	
	/**
	*	admin form before
	*/
	private function header( ) {
		?>
			<div class="wrap">
				<?php $this->sidebar() ?>
				
				<div class="page-content">
				
					<h2><span class="fa fa-<?php echo $this->icon ?>"></span> <?php echo $this->title ?></h2>
					<div class="description"><?php echo $this->description ?></div>

		<?php
	}
	
	/**
	*	admin form after
	*/
	private function footer( ) {
		?>
				</div>
			</div>
		<?php
	}
	
	/**
	*	additional sidebar
	*/
	private function sidebar( ) {
		
		?>
		
		<div id="admin-sidebar-back"></div>
		<div id="admin-sidebar-wrap">
			<div class="brand text-center"></div>
			<?php echo $this->createMenu() ?>
		</div>
		
		<?php
		
	}
	
	/**
     * list template slugs
     * @return array
     */
    public function templList( ) {

        return array();
    }
	
	/**
	*	walker to list menu
	*/
	private function createMenu( ) {
		
		$current 	= $this->currentItemMenu();
		$items 		= $this->listMenu();
		
		$return = "<ul>";
		
		foreach( $items as $slug => $args ) {
			
			$sub_result = $class = '';
			$sub_current = false;
			
			$class = ( $current == $slug ) ? 'item-active' : '';
			
			if( count( $args['submenu'] ) > 0 ) {
				
				$sub_result = '<ul class="sub-item">';
				
				foreach( $args['submenu'] as $sub_slug => $sub_args ) {
					
					$sub_class = ( $current == $sub_slug ) ? 'item-active' : '';
					
					if( $current == $sub_slug ) $sub_current = true;
						
					$sub_result .= '<li><a href="' . admin_url( 'admin.php?page=aliprice&aepage=' . $sub_slug ) . '" class="' . $sub_class . '">' . $sub_args['title'] . '</a></li>';
				}
				$sub_result .= '</ul>'; 
			}
		
			if($sub_current) $class = 'item-active';
			
			$return .= '<li class="' . $class . '"><a href="' . admin_url( 'admin.php?page=aliprice&aepage=' . $slug ) . '" class="' . $class . '"><span class="fa fa-' . $args['icon'] . '"></span> ' . $args['title']  . '</a>' . $sub_result . '</li>';
		}
		
		$return .= "</ul>";

		return $return;
	}
}

?>